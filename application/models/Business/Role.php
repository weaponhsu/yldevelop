<?php


namespace models\Business;


use models\Exception\Business\RoleException;
use models\Exception\Business\RuleException;
use models\Exception\DAO\ModelDriverException;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\DAO\ModelSqlException;
use models\Exception\Service\ServiceException;
use models\Exception\Transformer\TransformerException;
use models\Service\AuthorityService;
use models\Service\RoleService;
use models\Service\RuleService;
use Yaf\Registry;


class Role
{
    /**
     * @param $role_id
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws RoleException
     * @throws ServiceException
     */
    static public function deleteRole($role_id){
        try {
            RoleService::getInstance()->delete($role_id);
            self::deleteAuthority($role_id);

        } catch (ModelDriverException $e) {
            throw $e;
        } catch (ModelException $e) {
            throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (ServiceException $e) {
            throw $e;
        }

    }

    /**
     * @param $role_id
     * @return bool
     * @throws RoleException
     */
    static public function deleteAuthority($role_id) {
        try {
            $authority_list = AuthorityService::getInstance()->getList(1, 999999, 'desc', 'id',
                ['groupOp' => 'AND', 'rules' => [['field' => 'role_id', 'op' => 'eq', 'data' => $role_id]]]);

            $authority_id_arr = [];
            foreach ($authority_list['data'] as $value)
                array_push($authority_id_arr, $value['id']);

            if (!empty($authority_id_arr))
                AuthorityService::getInstance()->batchDelete($authority_id_arr);

            return true;
        } catch (ModelDriverException $e) {
            if ($e->getCode() == ModelDriverException::DRIVER_EXCEPTION_MSG_NO)
                throw new RoleException(RoleException::ROLE_BATCH_DELETE_RULE_FAILURE, RoleException::ROLE_BATCH_DELETE_RULE_FAILURE_NO);
        } catch (ModelException $e) {
        } catch (ModelReflectionException $e) {
        } catch (ModelSqlException $e) {
        } catch (ServiceException $e) {
        } catch (TransformerException $e) {
        }

    }

    /**
     * @param array $parameters
     * @return array|mixed|null
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws RoleException
     * @throws RuleException
     * @throws ServiceException
     * @throws TransformerException
     */
    static public function editRole($parameters = []) {
        try {
            if (! isset($parameters['id']) || empty($parameters['id']))
                throw new RoleException(RoleException::ROLE_ID_IS_EMPTY, RoleException::ROLE_ID_IS_EMPTY_NO);

            $update_arr = [];
            if (isset($parameters['name']))
                $update_arr['name'] = $parameters['name'];

            if (!empty($update_arr)) {
                $update_arr['updated_by'] = Registry::get('jwt_info')->id;
                $update_arr['updated_at'] = date("Y-m-d H:i:s", time());


                $role = RoleService::getInstance()->update($update_arr, $parameters['id']);
            } else
                $role = RoleService::getInstance()->getOne($parameters['id']);

            if (isset($parameters['access'])) {
                self::deleteAuthority($role['id']);
                $rule_list = self::createAuthority($role['id'], $parameters['access']);
                $role['rule_id'] = $rule_list['rule_id'];
                $role['rule_name'] = $rule_list['rule_name'];
            }

            return $role;
        } catch (RoleException $e) {
            throw $e;
        } catch (ModelDriverException $e) {
            if ($e->getCode() == ModelDriverException::DRIVER_EXCEPTION_MSG_NO)
                throw new RoleException(RoleException::ROLE_EDIT_FAILURE, RoleException::ROLE_EDIT_FAILURE_NO);
            throw $e;
        } catch (ModelException $e) {
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
     * @param array $parameters
     * @return array
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws RoleException
     * @throws RuleException
     * @throws ServiceException
     * @throws TransformerException
     */
    static public function createRole($parameters = []) {
        try {
            $role = RoleService::getInstance()->create($parameters['name'], Registry::get('jwt_info')->id, Registry::get('jwt_info')->id);

            $rule_list = self::createAuthority($role['id'], $parameters['access']);
            $role['rule_id'] = $rule_list['rule_id'];
            $role['rule_name'] = $rule_list['rule_name'];

            return $role;

        } catch (RoleException $e) {
            throw $e;
        } catch (RuleException $e) {
            throw $e;
        } catch (ModelDriverException $e) {
            if ($e->getCode() == ModelDriverException::DRIVER_EXCEPTION_MSG_NO)
                throw new RoleException(RoleException::ROLE_CREATE_FAILURE, RoleException::ROLE_CREATE_FAILURE_NO);
        } catch (ModelException $e) {
            throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (TransformerException $e) {
            throw $e;
        } catch (ServiceException $e) {
            throw $e;
        }
    }

    /**
     * @param $role_id
     * @param $rule_id
     * @return array
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws RoleException
     * @throws RuleException
     * @throws ServiceException
     * @throws TransformerException
     */
    static public function createAuthority($role_id, $rule_id) {
        try {
            $return_data = [];
            if (empty($role_id) || empty($rule_id))
                return $return_data;

            $rule_list = RuleService::getInstance()->getList(1, count(explode(',', $rule_id)), 'desc', 'id',
                ['groupOp' => 'AND', 'rules' => [['field' => 'id', 'op' => 'in', 'data' => $rule_id]]]);

            $batch_insert_arr = [];
            foreach ($rule_list['data'] as $rule) {
                array_push($batch_insert_arr, ['role_id' => $role_id, 'rule_id' => $rule['id']]);
                $return_data['rule_id'] = ! isset($return_data['rule_id']) ? $rule['id'] : ($return_data['rule_id'] . ',' . $rule['id']);
                $return_data['rule_name'] = ! isset($return_data['rule_name']) ? $rule['name'] : ($return_data['rule_name'] . ',' . $rule['name']);
            }

            if (!empty($batch_insert_arr))
                AuthorityService::getInstance()->batchInsert($batch_insert_arr);

            return $return_data;

        } catch (ModelDriverException $e) {
            if ($e->getCode() == ModelDriverException::DRIVER_EXCEPTION_MSG_NO)
                throw new RoleException(RoleException::ROLE_BATCH_INSERT_RULE_FAILURE, RoleException::ROLE_BATCH_INSERT_RULE_FAILURE_NO);
            throw $e;
        } catch (ModelException $e) {
            if ($e->getCode() == ModelException::DATA_NOT_EXISTS_NO)
                throw new RuleException(RuleException::RULE_NOT_EXISTS, RuleException::RULE_NOT_EXISTS_NO);
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
     * 获取角色列表
     * @param array $parameters
     * @return array|mixed
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws RoleException
     * @throws ServiceException
     * @throws TransformerException
     */
    static public function getRoleList($parameters = []) {
        try {
            $rules = $condition = [];
            if (isset($parameters['name']) && !empty($parameters['name']))
                array_push($rules, ['field' => 'name', 'op' => 'nc', 'data' => '%' . $parameters['name'] . '%']);

            if (!empty($rules))
                $condition = ['groupOp' => 'AND', 'rules' => $rules];

            $role_list = RoleService::getInstance()->getList(
                $parameters['page'], $parameters['page_size'], $parameters['sort'], $parameters['order'], $condition);

            $role_list = User::getUsersByModule($role_list);

            $role_list = Rule::getRulesByModules($role_list);

            return $role_list;

        } catch (ModelDriverException $e) {
            throw $e;
        } catch (ModelException $e) {
            if ($e->getCode() == '110002')
                throw new RoleException(RoleException::ROLE_IS_EMPTY, RoleException::ROLE_IS_EMPTY_NO);
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
     * @param array $modules
     * @return array
     */
    static public function getRolesByModules($modules = []) {
        try {
            $role_id_name_arr = $role_list = [];
            $role_id = array_column($modules['data'], 'role');
            $role_id_arr = array_column($modules['data'], 'role_id');
            $role_id_arr = array_filter(array_merge($role_id, $role_id_arr));

            if (count($role_id_arr) > 1) {
                $role_list = RoleService::getInstance()->getList(1, count($role_id_arr), 'desc', 'id', [
                    'groupOp' => 'AND', 'rules' => [
                        ['field' => 'id', 'op' => 'in', 'data' => implode(',', $role_id_arr)]]
                ]);
            } else if (count($role_id_arr) == 1) {
                $role_list['data'][] = RoleService::getInstance()->getOne(implode(',', $role_id_arr));

            }

            $role_id_name_arr = array_column($role_list['data'], 'name', 'id');

        } catch (ModelDriverException $e) {
        } catch (ModelException $e) {
        } catch (ModelReflectionException $e) {
        } catch (ModelSqlException $e) {
        } catch (ServiceException $e) {
        } catch (TransformerException $e) {
        } finally {
            foreach ($modules['data'] as $idx => $val) {
                if (isset($val['role']))
                    $modules['data'][$idx]['role_name'] = isset($role_id_name_arr[$val['role']]) ? $role_id_name_arr[$val['role']] : '';
                else if (isset($val['role_id']))
                    $modules['data'][$idx]['role_name'] = isset($role_id_name_arr[$val['role']]) ? $role_id_name_arr[$val['role']] : '';
            }

            return $modules;
        }
    }

}
