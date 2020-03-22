<?php

namespace models\Business;


use Common\AccessToken4Api;
use ErrorMsg\Admin\AdminErrMsg;
use Hashids\Hashids;
use models\DAO\AuthorityModel;
use models\DAO\MenuModel;
use models\Exception\Business\RoleException;
use models\Exception\Business\UserException;
use models\Exception\DAO\ModelDriverException;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\DAO\ModelSqlException;
use models\Exception\Service\ServiceException;
use models\Exception\Transformer\TransformerException;
use models\Service\RoleService;
use models\Service\UserService;
use Yaf\Exception;
use Yaf\Registry;
use Yaf\Session;
use youliPhpLib\Common\PwdAss;

class User
{
    /**
     * 登录
     * @param string $username
     * @param string $password
     * @return array|mixed|null
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws UserException
     * @throws TransformerException
     */
    public function login($username = '', $password = '') {
        try {
            if (empty($username) || empty($password))
                throw new UserException(UserException::USERNAME_OR_PASSWORD_IS_EMPTY, UserException::USERNAME_OR_PASSWORD_IS_EMPTY_NO);

            // 查询用户
            $user = UserService::getInstance()->getOne([
                'groupOp' => 'AND',
                'rules' => [
                    ['field' => 'username', 'op' => 'eq', 'data' => $username]
                ]]);

            // 判断状态
            if ($user['stats'] == 0)
                throw new UserException(UserException::USER_INVALID_STATS, UserException::USER_INVALID_STATS_NO);

            // 判断密码
            if (false === PwdAss::getInstance()->CheckPassword($password, $user['password']))
                throw new UserException(UserException::USER_INVALID_PASSWORD, UserException::USER_INVALID_PASSWORD_NO);

            // 更新用户最后登陆时间与登陆次数
            $user = UserService::getInstance()->update([
                'login_times' => $user['login_times'] + 1,
                'last_login_time' => date('Y-m-d H:i:s', time())
            ], $user['id']);

            // 写入session
            Session::getInstance()->set('role_id', $user['role']);
            Session::getInstance()->set('admin_id', $user['id']);
            Session::getInstance()->set('username', $user['username']);

            // 生成jwt
            $user['jwt'] = AccessToken4Api::generateJWT($user['uuid'], $user['id'], $user['role']);

            // 判断是否需要使用谷歌验证器登陆
            // 测试用
            $user_info['google_secret'] = false;
            if (!empty($user_info['google_secret'])) {
                Session::getInstance()->set("google_secret", $user_info['google_secret']);
                Session::getInstance()->set("google", false);
                $user['google_secret'] = true;
            } else
                $user['google_secret'] = false;

            // 生成权限
            // 测试用 一个没有权限的角色编号
//            $user['role'] = 100;
            $sql = "SELECT r.`name` as role_name, r1.`name` as rule_name, m.`name` as menu_name, m.`parent`, CONCAT(m.`path` , m.`id`) AS route, m.`url`, m.`id` " .
                "FROM `role` as r left join `authority` as o on r.`id` = o.`role_id` " .
                "left join `rule` as r1 on o.`rule_id` = r1.`id` " .
                "left join `access` as a on r1.`id` = a.`rule_id` " .
                "left join `menu` as m on a.`menu_id` = m.`id` " .
                "where r.`id` = '" . $user['role'] . "' and m.`is_operation` order by route asc, m.`id` asc";
            $menu_arr = MenuModel::getInstance()->query($sql);
            if (empty($menu_arr))
                throw new UserException(UserException::USER_HAS_NO_ACCESS, UserException::USER_HAS_NO_ACCESS_NO);
            // 权限写入session
            Session::getInstance()->set('access_list', json_encode(array_column($menu_arr, 'url')));

            return $user;

        } catch (ModelException $e) {
            if ($e->getCode() == '110002')
                throw new UserException(UserException::USER_IS_NOT_EXISTS, UserException::USER_IS_NOT_EXISTS_NO);
            throw $e;
        } catch (UserException $e) {
            throw $e;
        }

    }

    /**
     * @param string $code
     * @param string $secret
     * @throws UserException
     */
    public function googleAuthenticator($code = '', $secret = '') {
        try {
            if (empty($code) || empty($secret))
                throw new UserException(UserException::USER_INVALID_GOOGLE_AUTHENTICATOR, UserException::USER_INVALID_GOOGLE_AUTHENTICATOR_NO);

            $ga = new \PHPGangsta_GoogleAuthenticator();
            $res = $ga->verifyCode($secret, $code, 1);

            if ($res === false)
                throw new UserException(UserException::INVALID_GOOGLE_AUTHENTICATOR, UserException::INVALID_GOOGLE_AUTHENTICATOR_NO);

            Session::getInstance()->set("google", true);
        } catch (UserException $e) {
            throw $e;
        }
    }

    /**
     * 获取当前登陆账号所拥有的权限的分组名是什么并返回
     * @return array
     * @throws ModelSqlException
     * @throws UserException
     */
    public function info() {
        // 尚未验证谷歌认证器
        if (! is_null(Session::getInstance()->get('google')) && Session::getInstance()->get('google') === false)
            throw new UserException(UserException::USER_HAS_NO_GOOGLE_VERIFY, UserException::USER_HAS_NO_GOOGLE_VERIFY_NO);

        // 测试用 一个没有权限的角色编号
//        Registry::get('jwt_info')->role_id = 100;
        $sql = "SELECT r.`name` FROM `authority` AS a LEFT JOIN `rule` AS r ON a.`rule_id` = r.`id` WHERE a.`role_id` = '" . Registry::get('jwt_info')->role_id . "'";
        $rule_name = AuthorityModel::getInstance()->query($sql);


        return array_column($rule_name, 'name');
    }

    /**
     * 创建后台账号
     * @param array $parameters
     * @return array
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws RoleException
     * @throws UserException
     * @throws TransformerException
     */
    public function createUser($parameters = []) {
        try {
            // 生成uuid
            $hash_id = new Hashids('youli', 16, 'abcdefghijklmnopqrstuvwxyz01234569');
            $uuid = $hash_id->encode($parameters['mobile']);

            // 生成密码
            $password = PwdAss::getInstance(8, true)->HashPassword($parameters['password']);

            // 验证手机号码有效性

            // 验证后台角色有效性
            $role_info = RoleService::getInstance()->getOne($parameters['role']);

            // 创建后台账号
            $create_res = UserService::getInstance()->create(
                $parameters['username'], $password,
                isset($parameters['google']) ? $parameters['google'] : '',
                $parameters['role'],
                $parameters['mobile'], $parameters['stats'],
                $uuid,
                0, $parameters['created_by'], $parameters['created_by']);


            $create_res['role_name'] = $role_info['name'];

            return $create_res;

        } catch (ModelDriverException $e) {
            if ($e->getCode() == '120001')
                throw new UserException(UserException::USER_CREATE_FAILURE, UserException::USER_CREATE_FAILURE_NO);
            throw $e;
        } catch (ModelException $e) {
            if ($e->getCode() == '110002')
                throw new RoleException(RoleException::ROLE_IS_EMPTY, RoleException::ROLE_IS_EMPTY_NO);
            throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (TransformerException $e) {
            throw $e;
        }
    }


    public function genGoogleAuthenticator($parameters) {
        if (! isset($parameters['action']) || $parameters['action'] !== 'genGoogleAuth')
            throw new Exception(AdminErrMsg::USER_INVALID_ACTION, AdminErrMsg::USER_INVALID_ACTION_NO);

        $ga = new \PHPGangsta_GoogleAuthenticator();

        $secret = $ga->createSecret();

        return [$secret, $ga->getQRCodeGoogleUrl(Session::getInstance()->get('admin_name'), $secret, "pdd")];

    }

    /**
     * 获取后台账号列表
     * @param array $parameters
     * @return array|mixed
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws UserException
     * @throws TransformerException
     */
    public function getUserList($parameters = []) {
        try {
            $rules = $condition = [];
            if (isset($parameters['username']) && !empty($parameters['username']))
                array_push($rules, ['field' => 'username', 'op' => 'nc', 'data' => '%' . $parameters['username'] . '%']);

            if (isset($parameters['mobile']) && !empty($parameters['mobile']))
                array_push($rules, ['field' => 'mobile', 'op' => 'nc', 'data' => '%' . $parameters['mobile'] . '%']);

            if (isset($parameters['role']) && !empty($parameters['role']))
                array_push($rules, ['field' => 'role', 'op' => 'eq', 'data' => $parameters['role']]);

            if (isset($parameters['stats']))
                array_push($rules, ['field' => 'stats', 'op' => 'eq', 'data' => $parameters['stats']]);

            if (isset($parameters['created_start_time']) &&
                !empty($parameters['created_start_time']))
                array_push($rules, ['field' => 'created_at', 'op' => 'ge', 'data' => $parameters['created_start_time']]);

            if (isset($parameters['created_end_time']) &&
                !empty($parameters['created_end_time']))
                array_push($rules, ['field' => 'created_at', 'op' => 'le', 'data' => $parameters['created_end_time']]);

            if (!empty($rules))
                $condition = ['groupOp' => 'AND', 'rules' => $rules];

            $cache_name_arr = [];
            if (!empty($rules)) {
                foreach ($rules as $idx => $column_name) {
                    $cache_name_arr[$column_name['field']] = $column_name['data'];
                }
            }
//            $cache_name = 'user:list:' . http_build_query($cache_name_arr) . ':' .
//                (isset($parameters['page']) ? $parameters['page'] : 1) . ':' .
//                (isset($parameters['page_size']) ? $parameters['page_size'] : 10);

            $user_list = UserService::getInstance()->getList(
                isset($parameters['page']) ? $parameters['page'] : 1,
                isset($parameters['page_size']) ? $parameters['page_size'] : 10,
                isset($parameters['sort']) ? $parameters['sort'] : 'desc',
                isset($parameters['order']) ? $parameters['order'] : 'id',
                $condition/*, true, $cache_name*/);

            $user_list = Role::getRolesByModules($user_list);

            return $user_list;

        } catch (ModelDriverException $e) {
            throw $e;
        } catch (ModelException $e) {
            if ($e->getCode() == '110002')
                throw new UserException(UserException::USER_IS_NOT_EXISTS, UserException::USER_IS_NOT_EXISTS_NO);
            throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (ServiceException $e) {
            throw $e;
        } catch (TransformerException $e) {
            throw $e;
        }
    }

    /**
     * 更新用户数据
     * @param array $parameters
     * @return array|mixed|null
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws UserException
     * @throws TransformerException
     */
    public function update($parameters = []) {
        try {
            if (! isset($parameters['id']) && empty($parameters['id']))
                throw new UserException(UserException::USER_EDIT_ID_IS_EMPTY, UserException::USER_EDIT_ID_IS_EMPTY_NO);

            $update_arr = [];
            $update_res = UserService::getInstance()->getOne($parameters['id']);

            if (isset($parameters['stats']) && $update_res['stats'] != $parameters['stats'])
                $update_arr['stats'] = $parameters['stats'];

            if (isset($parameters['mobile']) && !empty($parameters['mobile']) && $update_res['mobile'] != $parameters['mobile'])
                $update_arr['mobile'] = $parameters['mobile'];

            if (isset($parameters['password']) && !empty($parameters['password']))
                $update_arr['password'] = PwdAss::getInstance(8, true)->HashPassword($parameters['password']);

            if (isset($parameters['role']) && !empty($parameters['role']) && $update_res['role'] != $parameters['role'])
                $update_arr['role'] = $parameters['role'];

            if (isset($parameters['google_secret']) && !empty($parameters['google_secret']) && $update_res['google_secret'] != $parameters['google_secret'])
                $update_arr['google_secret'] = $parameters['google_secret'];

            if (!empty($update_arr)) {
                // 设置最后一次编辑者与最后一次编辑时间
                $update_arr['updated_by'] = Registry::get('jwt_info')->id;
                $update_arr['updated_at'] = date('Y-m-d H:i:s', time());

                $update_res = UserService::getInstance()->update($update_arr, $parameters['id']);
            }

            $role_info = RoleService::getInstance()->getOne($update_res['role']);
            $update_res['role_name'] = $role_info['name'];

            return $update_res;
        } catch (ModelDriverException $e) {
            if ($e->getCode() == '130001')
                throw new UserException(UserException::USER_EDIT_FAILURE, UserException::USER_EDIT_FAILURE_NO);
            throw $e;
        } catch (ModelException $e) {
            if ($e->getCode() == '110002')
                throw new UserException(UserException::USER_IS_NOT_EXISTS, UserException::USER_IS_NOT_EXISTS_NO);
            throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (ServiceException $e) {
            throw $e;
        } catch (TransformerException $e) {
            throw $e;
        }
    }

    /**
     * 删除后台账号
     * @param int $user_id
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     */
    public function deleteUser($user_id = 0) {
        try {
            UserService::getInstance()->delete($user_id);
        } catch (ModelDriverException $e) {
            throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (ServiceException $e) {
            throw $e;
        } catch (ModelException $e) {
            throw $e;
        }
    }

    /**
     * 批量删除user
     * @param array $id_arr
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws UserException
     */
    public function batchDeleteUsers($id_arr = []) {

        try {
            if (empty($id_arr))
                throw new UserException(UserException::USER_ID_IS_EMPTY, UserException::USER_ID_IS_EMPTY_NO);

            UserService::getInstance()->batchDelete($id_arr);

        } catch (ModelDriverException $e) {
            throw $e;
        } catch (ModelException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (ServiceException $e) {
            throw $e;
        } catch (UserException $e) {
            throw $e;
        }
    }

    /**
     * 通过username like出对应的id记录
     * @param string $username
     * @return array
     * @throws Exception
     */
    static public function getOwnerInfoByUsername($username = '') {
        if (empty($username))
            throw new Exception(AdminErrMsg::USER_INVALID_PARAMETERS, AdminErrMsg::USER_INVALID_PARAMETERS_NO);

        $username = strpos($username, ',') !== false ? explode(',', $username) : $username;
        $rules = $condition = [];
        $where_or = false;

        if (is_array($username)) {
            foreach ($username as $real_username)
                array_push($rules, ['field' => 'username', 'op' => 'nc', 'data' => '%' . $real_username . '%']);
            $where_or = true;
        } else
            array_push($rules, ['field' => 'username', 'op' => 'nc', 'data' => '%' . $username . '%']);

        if (!empty($rules)) {
            $condition = $where_or === false ? ['groupOp' => 'AND', 'rules' => $rules] :
                ['groupOp' => 'OR', 'rules' => $rules];
        }

        try {
            if (count($rules) == 1)
                $user_info['data'][] = UserService::getInstance()->getOne($condition);
            else
                $user_info = UserService::getInstance()->getList(1, count($rules), 'desc', 'id', $condition);

            return $user_info;

        } catch (Exception $e) {
            throw new Exception(AdminErrMsg::USER_IS_NOT_EXISTS, AdminErrMsg::USER_IS_NOT_EXISTS_NO);
        }
    }

    /**
     * 将module_info数组下的created_by,updated_by,owner_id的值放到user表中找出对应的username
     * @param array $module_info
     * @return array
     * @throws Exception
     */
    static public function getUserByModule($module_info = []) {
        try {
            $user_id_arr = [];
            if (!empty($module_info['owner_id']) && ! in_array($module_info['owner_id'], $user_id_arr))
                array_push($user_id_arr, $module_info['owner_id']);
            if (!empty($module_info['created_by']) && ! in_array($module_info['created_by'], $user_id_arr))
                array_push($user_id_arr, $module_info['created_by']);
            if (!empty($module_info['updated_by']) && ! in_array($module_info['created_by'], $user_id_arr))
                array_push($user_id_arr, $module_info['updated_by']);
            $user_id_arr = array_unique($user_id_arr);

            if (count($user_id_arr) == 1)
                $user_list['data'][] = UserService::getInstance()->getOne($user_id_arr[0]);
            else
                $user_list = UserService::getInstance()->getList(1, count($user_id_arr), 'desc', 'id',
                    ['groupOp' => 'AND', 'rules' => [
                        ['field' => 'id', 'op' => 'eq', 'data' => implode(',', $user_id_arr)]]]);

            $user_name_id_arr = array_column($user_list['data'], 'username', 'id');

            $module_info['created_by_name'] = isset($user_name_id_arr[$module_info['created_by']]) ?
                $user_name_id_arr[$module_info['created_by']] : '';
            $module_info['updated_by_name'] = isset($user_name_id_arr[$module_info['updated_by']]) ?
                $user_name_id_arr[$module_info['updated_by']] : '';
            $module_info['owner'] = isset($user_name_id_arr[$module_info['owner_id']]) ?
                $user_name_id_arr[$module_info['owner_id']] : '';

            return $module_info;
        } catch (Exception $e) {
            throw new Exception(AdminErrMsg::USER_IS_NOT_EXISTS, AdminErrMsg::USER_IS_NOT_EXISTS_NO);
        }
    }

    /**
     * 将module_list['data']数组下的created_by,updated_by,owner_id的值放到user表中找出对应的username
     * @param array $module_list
     * @return array
     */
    static public function getUsersByModule($module_list = []) {
        try {
            $user_id_name_arr = [];
            $created_by = array_column($module_list['data'], 'created_by');
            $updated_by = array_column($module_list['data'], 'updated_by');
            $user_id_arr = array_merge($created_by, $updated_by);

            $agent = array_column($module_list['data'], 'agent');
            if ($agent)
                $user_id_arr = array_merge($user_id_arr, $agent);

            $owner_id_arr = array_column($module_list['data'], 'owner_id');
            $user_id_arr = array_merge($user_id_arr, $owner_id_arr);

            $user_id_arr = array_values(array_filter(array_unique($user_id_arr)));

            $user_list = [];
            if (count($user_id_arr) == 1)
                $user_list['data'][] = UserService::getInstance()->getOne($user_id_arr[0]);
            else if (count($user_id_arr) > 1)
                $user_list = UserService::getInstance()->getList(1, count($user_id_arr), 'desc', 'id',
                    ['groupOp' => 'AND',
                        'rules' => [['field' => 'id', 'op' => 'in', 'data' => implode(',', $user_id_arr)]]]);

            $user_id_name_arr = array_column($user_list['data'], 'username', 'id');

        } catch (ModelDriverException $e) {
        } catch (ModelException $e) {
        } catch (ModelReflectionException $e) {
        } catch (ModelSqlException $e) {
        } catch (ServiceException $e) {
        } catch (TransformerException $e) {
        } finally {
            foreach ($module_list['data'] as $idx => $info) {
                if (isset($info['created_by'])) {
                    $module_list['data'][$idx]['created_by_name'] = isset($user_id_name_arr[$info['created_by']]) ?
                        $user_id_name_arr[$info['created_by']] : '';
                }
                if (isset($info['updated_by'])) {
                    $module_list['data'][$idx]['updated_by_name'] = isset($user_id_name_arr[$info['updated_by']]) ?
                        $user_id_name_arr[$info['updated_by']] : '';
                }
                if (isset($info['owner_id'])) {
                    $module_list['data'][$idx]['owner'] = isset($user_id_name_arr[$info['owner_id']]) ?
                        $user_id_name_arr[$info['owner_id']] : '';
                }
                if (isset($info['agent'])) {
                    $module_list['data'][$idx]['agent_name'] = isset($user_id_name_arr[$info['agent']]) ?
                        $user_id_name_arr[$info['agent']] : '';
                }
            }
            return $module_list;
        }
    }
}
