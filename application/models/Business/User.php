<?php

namespace models\Business;


use Common\AccessToken4Api;
use Hashids\Hashids;
use Illuminate\Database\Capsule\Manager AS Capsule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use models\Exception\Business\RoleException;
use models\Exception\Business\UserException;
use models\Exception\DAO\ModelException;
use models\DAO\EloquentPaginator;
use models\DAO\RoleModel;
use models\DAO\UserModel;
use Throwable;
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
     * @return mixed
     * @throws UserException
     */
    static public function login($username = '', $password = '') {
        if (empty($username) || empty($password))
            throw new UserException(UserException::USERNAME_OR_PASSWORD_IS_EMPTY, UserException::USERNAME_OR_PASSWORD_IS_EMPTY_NO);

        $user = UserModel::where("username", "=", $username)->first();

        if (is_null($user))
            throw new UserException(UserException::USER_IS_NOT_EXISTS, UserException::USER_IS_NOT_EXISTS_NO);

        if ($user->stats == 0)
            throw new UserException(UserException::USER_INVALID_STATS, UserException::USER_INVALID_STATS_NO);

        // 判断密码
        if (false === PwdAss::getInstance()->CheckPassword($password, $user->password))
            throw new UserException(UserException::USER_INVALID_PASSWORD, UserException::USER_INVALID_PASSWORD_NO);

        $user->login_times += 1;
        $user->last_login_time = date('Y-m-d H:i:s', time());
        $user->save();

        $user = $user->toArray();

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
//        $user['role'] = 100;
        $sql = "SELECT r.name as role_name, r1.name as rule_name, m.name as menu_name, m.parent, CONCAT(m.path , m.id) AS route, m.url, m.id " .
            "FROM role as r left join authority as o on r.id = o.role_id " .
            "left join rule as r1 on o.rule_id = r1.id " .
            "left join access as a on r1.id = a.rule_id " .
            "left join menu as m on a.menu_id = m.id " .
            "where r.id = :r_id and m.is_operation order by route asc, m.id asc";
        $menu_arr = Capsule::select($sql, [':r_id' => $user['role']]);
        if (empty($menu_arr))
            throw new UserException(UserException::USER_HAS_NO_ACCESS, UserException::USER_HAS_NO_ACCESS_NO);

        // 权限写入session
        Session::getInstance()->set('access_list', json_encode(array_column($menu_arr, 'url')));

        return $user;
    }

    /**
     * 获取当前登陆账号所拥有的权限的分组名是什么并返回
     * @return array
     * @throws UserException
     */
    static public function info() {
        // 尚未验证谷歌认证器
        if (! is_null(Session::getInstance()->get('google')) && Session::getInstance()->get('google') === false)
            throw new UserException(UserException::USER_HAS_NO_GOOGLE_VERIFY, UserException::USER_HAS_NO_GOOGLE_VERIFY_NO);

        // 测试用 一个没有权限的角色编号
//        Registry::get('jwt_info')->role_id = 100;
        $sql = "SELECT r.`name` FROM `authority` AS a LEFT JOIN `rule` AS r ON a.`rule_id` = r.`id` WHERE a.`role_id` = :role_id";
        $rule_name = Capsule::select($sql, [':role_id' => Registry::get('jwt_info')->role_id]);
        if (empty($rule_name))
            throw new UserException(UserException::USER_HAS_NO_ACCESS, UserException::USER_HAS_NO_ACCESS_NO);

        return array_column($rule_name, 'name');
    }

    /**
     * 获取后台账号列表
     * @param array $parameters
     * @return array
     * @throws ModelException
     * @throws UserException
     */
    static public function getUserList($parameters = []) {
        try {
            $user_model = new UserModel();

            if (isset($parameters['stats']))
                $user_model = $user_model->where('stats', '=', $parameters['stats']);
            if (isset($parameters['role']))
                $user_model = $user_model->where('role', '=', $parameters['role']);
            if (isset($parameters['username']))
                $user_model = $user_model->where('username', 'like', '%' . $parameters['username'] . '%');
            if (isset($parameters['mobile']))
                $user_model = $user_model->where('mobile', 'like', '%' . $parameters['mobile'] . '%');

            $paginator = EloquentPaginator::getInstance($user_model,
                isset($parameters['page']) ? $parameters['page'] : 1,
                isset($parameters['page_size']) ? $parameters['page_size'] : 10
            )->setSort(isset($parameters['sort']) ? $parameters['sort'] : 'desc')
                ->setOrder(isset($parameters['order']) ? $parameters['order'] : 'id')
                ->paginator();

            $user_list = ['data' => $paginator->getdata(), 'meta' => $paginator->getMeta()];

            $user_list = Role::getRolesByModules($user_list);

            return $user_list;
        } catch (ModelException $e) {
            if ($e->getCode() == ModelException::DATA_NOT_EXISTS_NO)
                throw new UserException(UserException::USER_IS_NOT_EXISTS, UserException::USER_IS_NOT_EXISTS_NO);
            throw $e;
        }
    }

    /**
     * 创建后台账号
     * @param array $parameters
     * @return UserModel
     * @throws RoleException
     * @throws UserException
     */
    static public function createUser($parameters = []) {
        try {

            $user = new UserModel();
            $user->mobile = $parameters['mobile'];
            $user->username = $parameters['username'];
            $user->stats = $parameters['stats'];
            $user->password = PwdAss::getInstance(8, true)->HashPassword($parameters['password']);

            try {
                $role = RoleModel::findOrFail($parameters['role']);
            } catch (ModelNotFoundException $e) {
                throw new RoleException(RoleException::ROLE_NOT_EXISTS, RoleException::ROLE_NOT_EXISTS_NO);
            }
            $user->role = $role->id;

            $hash_id = new Hashids('yaf', 16, 'abcdefghijklmnopqrstuvwxyz01234569');
            $user->uuid = $hash_id->encode($parameters['mobile']);

            $user->created_by = Registry::get('jwt_info')->id;
            $user->updated_by = Registry::get('jwt_info')->id;

            // 开启日志
            Capsule::connection()->enableQueryLog();
            $user->saveOrFail();

            return $user;
        } catch (RoleException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new UserException(UserException::USER_CREATE_FAILURE, UserException::USER_CREATE_FAILURE_NO);
        } catch (Throwable $e) {
            throw new UserException(UserException::USER_CREATE_FAILURE, UserException::USER_CREATE_FAILURE_NO);
        }
    }

    /**
     * 更新用户数据
     * @param array $parameters
     * @return mixed
     * @throws RoleException
     * @throws UserException
     */
    static public function updateUser($parameters = []) {
        try {
            if (! isset($parameters['id']) && empty($parameters['id']))
                throw new UserException(UserException::USER_EDIT_ID_IS_EMPTY, UserException::USER_EDIT_ID_IS_EMPTY_NO);

            // 测试用 一个不存在的user id
//            $parameters['id'] = 100;
            $user = UserModel::findOrFail($parameters['id']);

            $update = false;
            if (isset($parameters['password']) && ! empty($parameters['password'])) {
                $user->password = PwdAss::getInstance(8, true)->HashPassword($parameters['password']);
                $update = true;
            }

            if (isset($parameters['role']) && $parameters['role'] != $user->role) {
                try {
                    $role = RoleModel::findOrFail($parameters['role']);
                    $user->role = $role->id;
                    $update = true;
                } catch (ModelNotFoundException $e) {
                    throw new RoleException(RoleException::ROLE_NOT_EXISTS, RoleException::ROLE_NOT_EXISTS_NO);
                }
            }

            if (isset($parameters['stats']) && $parameters['stats'] != $user->stats) {
                $user->stats = $parameters['stats'];
                $update = true;
            }


            if (isset($parameters['google_secret']) && !empty($parameters['google_secret']) &&
                $user->google_secret != $parameters['google_secret']
            ) {
                $user->google_secret = $parameters['google_secret'];
                $update = true;
            }


            if (isset($parameters['mobile']) && !empty($parameters['mobile']) &&
                $user->mobile != $parameters['mobile']
            ) {
                $user->mobile = $parameters['mobile'];
                $update = true;
            }

            if ($update === true) {
                $user->updated_by = Registry::get('jwt_info')->id;

                // 开启日志
                Capsule::connection()->enableQueryLog();
                $user->saveOrFail();
            }

            return $user;

        } catch (UserException $e) {
            throw $e;
        } catch (RoleException $e) {
            throw $e;
        } catch (ModelNotFoundException $e) {
            throw new UserException(UserException::USER_IS_NOT_EXISTS, UserException::USER_IS_NOT_EXISTS_NO);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000')
                throw new UserException(UserException::USER_UNIQUE, UserException::USER_UNIQUE_NO);
            throw new UserException(UserException::USER_EDIT_FAILURE, UserException::USER_EDIT_FAILURE_NO);
        } catch (Throwable $e) {
            throw new UserException(UserException::USER_EDIT_FAILURE, UserException::USER_EDIT_FAILURE_NO);
        }
    }

    /**
     * 删除后台账号
     * @param int $user_id
     * @throws UserException
     */
    static public function deleteUser($user_id = 0) {
        try {
            if ( empty($user_id))
                throw new UserException(UserException::USER_ID_IS_EMPTY, UserException::USER_ID_IS_EMPTY_NO);

            $user_model = UserModel::findOrfail($user_id);

            // 开启日志
            Capsule::connection()->enableQueryLog();
            $user_model->delete();

        } catch (UserException $e) {
            throw $e;
        } catch (ModelNotFoundException $e) {
            throw new UserException(UserException::USER_IS_DELETED, UserException::USER_IS_DELETED_NO);
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
            if (!empty($module_info->owner_id) && ! in_array($module_info->owner_id, $user_id_arr))
                array_push($user_id_arr, $module_info->owner_id);
            if (!empty($module_info->created_by) && ! in_array($module_info->created_by, $user_id_arr))
                array_push($user_id_arr, $module_info->created_by);
            if (!empty($module_info->updated_by) && ! in_array($module_info->created_by, $user_id_arr))
                array_push($user_id_arr, $module_info->updated_by);
            $user_id_arr = array_unique($user_id_arr);

            if (count($user_id_arr) == 1)
                $user_list[] = UserModel::find($user_id_arr[0])->toArray();
//                $user_list['data'][] = UserService::getInstance()->getOne($user_id_arr[0]);
            else if (count($user_id_arr) > 1)
                $user_list = UserModel::whereIn('id', array_values($user_id_arr))->get()->toArray();

            $user_name_id_arr = array_column($user_list, 'username', 'id');

            $module_info->created_by_name = isset($user_name_id_arr[$module_info->created_by]) ?
                $user_name_id_arr[$module_info->created_by] : '';
            $module_info->updated_by_name = isset($user_name_id_arr[$module_info->updated_by]) ?
                $user_name_id_arr[$module_info->updated_by] : '';
            $module_info->owner = isset($user_name_id_arr[$module_info->owner_id]) ?
                $user_name_id_arr[$module_info->owner_id] : '';

            return $module_info;
        } catch (Exception $e) {
            throw new Exception(UseException::USER_IS_NOT_EXISTS, UseException::USER_IS_NOT_EXISTS_NO);
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
                $user_list[] = UserModel::find($user_id_arr[0])->toArray();
//                $user_list['data'][] = UserService::getInstance()->getOne($user_id_arr[0]);
            else if (count($user_id_arr) > 1)
                $user_list = UserModel::whereIn('id', array_values($user_id_arr))->get()->toArray();

            $user_id_name_arr = array_column($user_list, 'username', 'id');

        } catch (\Exception $e) {
        } finally {
            foreach ($module_list['data'] as $idx => $info) {
                if (isset($info->created_by)) {
                    $module_list['data'][$idx]->created_by_name = isset($user_id_name_arr[$info->created_by]) ?
                        $user_id_name_arr[$info->created_by] : '';
                }
                if (isset($info->updated_by)) {
                    $module_list['data'][$idx]->updated_by_name = isset($user_id_name_arr[$info->updated_by]) ?
                        $user_id_name_arr[$info->updated_by] : '';
                }
                if (isset($info->owner_id)) {
                    $module_list['data'][$idx]->owner = isset($user_id_name_arr[$info->owner_id]) ?
                        $user_id_name_arr[$info->owner_id] : '';
                }
                if (isset($info->agent)) {
                    $module_list['data'][$idx]->agent_name = isset($user_id_name_arr[$info->agent]) ?
                        $user_id_name_arr[$info->agent] : '';
                }
            }
            return $module_list;
        }
    }

    static public function genGoogleAuthenticator($parameters) {
        if (! isset($parameters['action']) || $parameters['action'] !== 'genGoogleAuth')
            throw new Exception(UseException::USER_INVALID_ACTION, UseException::USER_INVALID_ACTION_NO);

        $ga = new \PHPGangsta_GoogleAuthenticator();

        $secret = $ga->createSecret();

        return [$secret, $ga->getQRCodeGoogleUrl(Session::getInstance()->get('admin_name'), $secret, "yaf")];
    }

    /**
     * @param string $code
     * @param string $secret
     * @throws UserException
     */
    static public function googleAuthenticator($code = '', $secret = '') {
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
}
