<?php


namespace models\Business;


use Doctrine\DBAL\Exception\DriverException;
use models\DAO\RuleModel;
use models\Exception\Business\MenuException;
use models\Exception\Business\RuleException;
use models\Exception\DAO\ModelDriverException;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\DAO\ModelSqlException;
use models\Exception\Service\ServiceException;
use models\Exception\Transformer\TransformerException;
use models\Service\AccessService;
use models\Service\MenuService;
use models\Service\RuleService;
use Yaf\Registry;

class Rule
{
    /**
     * @param $rule_id
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     */
    static public function deleteRule($rule_id) {
        try {
            RuleService::getInstance()->delete($rule_id);
            self::deleteAccess($rule_id);
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
     * @param $rule_id
     * @return bool
     */
    static public function deleteAccess($rule_id) {
        try {
            $access_list = AccessService::getInstance()->getList(1, 999999, 'desc', 'id',
                ['groupOp' => 'AND', 'rules' => [['field' => 'rule_id', 'op' => 'eq', 'data' => $rule_id]]]);
            $access_id_arr = [];
            foreach ($access_list['data'] as $value)
                array_push($access_id_arr, $value['id']);

            if (!empty($access_id_arr))
                AccessService::getInstance()->batchDelete($access_id_arr);

            return true;
        } catch (ModelDriverException $e) {
        } catch (ModelException $e) {
        } catch (ModelReflectionException $e) {
        } catch (ModelSqlException $e) {
        } catch (ServiceException $e) {
        } catch (TransformerException $e) {
        }
    }

    /**
     * @param $rule_id
     * @param $menu_id
     * @return array
     * @throws MenuException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws RuleException
     * @throws ServiceException
     * @throws TransformerException
     */
    static public function createAccess($rule_id, $menu_id) {
        try {
            $return_data = [];
            if (empty($rule_id) || empty($menu_id))
                return $return_data;

            $menu_list = MenuService::getInstance()->getList(1, count(explode(',', $menu_id)), 'desc', 'id',
                ['groupOp' => 'AND', 'rules' => [['field' => 'id', 'op' => 'in', 'data' => $menu_id]]]);

            $batch_insert_arr = [];
            foreach ($menu_list['data'] as $menu) {
                array_push($batch_insert_arr, ['rule_id' => $rule_id, 'menu_id' => $menu['id']]);
                $return_data['menu_id'] = ! isset($return_data['menu_id']) ? $menu['id'] : ($return_data['menu_id'] . ',' . $menu['id']);
                $return_data['menu_name'] = ! isset($return_data['menu_name']) ? $menu['name'] : ($return_data['menu_name'] . ',' . $menu['name']);
            }

            if (!empty($batch_insert_arr))
                AccessService::getInstance()->batchInsert($batch_insert_arr);

            return $return_data;

        } catch (ModelException $e) {
            if ($e->getCode() == ModelException::DATA_NOT_EXISTS_NO)
                throw new MenuException(MenuException::MENU_NOT_EXISTS, MenuException::MENU_NOT_EXISTS_NO);
        } catch (ModelDriverException $e) {
            if ($e->getCode() == ModelDriverException::DRIVER_EXCEPTION_MSG_NO)
                throw new RuleException(RuleException::RULE_BATCH_INSERT_MENU_FAILURE, RuleException::RULE_BATCH_INSERT_MENU_FAILURE_NO);
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
     * @return array|mixed|null
     * @throws MenuException
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws RuleException
     * @throws ServiceException
     * @throws TransformerException
     */
    static public function editRule($parameters = []) {
        try {
            if (!isset($parameters['id']) || empty($parameters['id']))
                throw new RuleException(RuleException::RULE_ID_NOT_EXISTS, RuleException::RULE_ID_NOT_EXISTS_NO);

            $update_arr = [];
            if (isset($parameters['name']))
                $update_arr['name'] = $parameters['name'];

            if (isset($parameters['stats']))
                $update_arr['stats'] = $parameters['stats'];

            if (! empty($update_arr)) {
                $update_arr['updated_at'] = date('Y-m-d H:i:s', time());
                $update_arr['updated_by'] = Registry::get('jwt_info')->id;

                $rule = RuleService::getInstance()->update($update_arr, $parameters['id']);
            } else
                $rule = RuleService::getInstance()->getOne($parameters['id']);

            if (isset($parameters['menu_id'])) {
                self::deleteAccess($parameters['id']);
                $access_res = self::createAccess($parameters['id'], $parameters['menu_id']);
                $rule['menu_id'] = $access_res['menu_id'];
                $rule['menu_name'] = $access_res['menu_name'];
            }

            return $rule;
        } catch (RuleException $e) {
            throw $e;
        } catch (ModelDriverException $e) {
            if ($e->getCode() == ModelDriverException::DRIVER_EXCEPTION_MSG_NO)
                throw new RuleException(RuleException::RULE_EDIT_FAILURE, RuleException::RULE_EDIT_FAILURE_NO);
            throw $e;
        } catch (ModelException $e) {
            if ($e->getCode() != ModelException::DATA_NOT_EXISTS_NO)
                throw new RuleException(RuleException::RULE_IS_EMPTY, RuleException::RULE_IS_EMPTY_NO);
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
     * @throws MenuException
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws RuleException
     * @throws TransformerException
     * @throws ServiceException
     */
    static public function createRule($parameters = []) {
        // 创建rule
        // $name = "", $stats = 0, $created_by = 0, $created_at = "", $updated_by = 0, $updated_at = ""
        try {
            $rule = RuleService::getInstance()->create($parameters['name'], isset($parameters['stats']) ? $parameters['stats'] : 0,
                Registry::get('jwt_info')->id, date("Y-m-d H:i:s", time()), Registry::get('jwt_info')->id);

            $access_res = self::createAccess($rule['id'], $parameters['menu_id']);
            $rule['menu_id'] = $access_res['menu_id'];
            $rule['menu_name'] = $access_res['menu_name'];

            return $rule;

        } catch (MenuException $e) {
            throw $e;
        } catch (RuleException $e) {
            throw $e;
        } catch (ModelDriverException $e) {
            if ($e->getCode() == ModelDriverException::DRIVER_EXCEPTION_MSG_NO)
                throw new RuleException(RuleException::RULE_CREATE_FAILURE, RuleException::RULE_CREATE_FAILURE_NO);
            throw $e;
        } catch (ModelException $e) {
            throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (TransformerException $e) {
            throw $e;
        }


    }

    /**
     * @param array $parameters
     * @return array
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws RuleException
     * @throws ServiceException
     * @throws TransformerException
     * @throws ModelException
     */
    static public function getRulesList($parameters = []) {
        try {

            $sql = "SELECT r.`id`, r.`name` AS rule_name, r.`stats`, r.`created_at`, r.`created_by`, r.`updated_at`, r.`updated_by`, m.`id` as menu_id, m.`name` as menu_name ".
                "FROM `rule` AS r LEFT JOIN `access` AS a ON r.`id` = a.`rule_id` ".
                "LEFT JOIN `menu` AS m ON a.`menu_id` = m.id ".
                "WHERE m.`is_operation` = 1";
            $rules = RuleModel::getInstance()->query($sql);

            $rules_list = ['data' => []];
            $match_rules_list = [];
            foreach ($rules as $idx => $val) {
                if (! in_array($val['id'], $match_rules_list)) {
                    array_push($rules_list['data'], [
                        'id' => $val['id'],
                        'name' => $val['rule_name'],
                        'stats' => $val['stats'],
                        'created_at' => $val['created_at'],
                        'created_by' => $val['created_by'],
                        'updated_at' => $val['updated_at'],
                        'updated_by' => $val['updated_by'],
                        'menu_id' => $val['menu_id'],
                        'menu_name' => $val['menu_name']
                    ]);
                    array_push($match_rules_list, $val['id']);
                } else {
                    $key = array_search($val['id'], $match_rules_list);
                    $rules_list['data'][$key]['menu_id'] .= ',' . $val['menu_id'];
                    $rules_list['data'][$key]['menu_name'] .= ',' . $val['menu_name'];
                }
            }

            $rules_list = User::getUsersByModule($rules_list);
            $rules_list['meta'] = new \stdClass();

            return $rules_list;

        } catch (ModelDriverException $e) {
            if ($e->getCode() == ModelDriverException::DRIVER_EXCEPTION_MSG_NO)
                throw new RuleException(RuleException::RULE_EDIT_FAILURE, RuleException::RULE_EDIT_FAILURE_NO);
            throw $e;
        } catch (ModelException $e) {
            if ($e->getCode() == '120002')
                throw new RuleException(RuleException::RULE_IS_EMPTY, RuleException::RULE_IS_EMPTY_NO);
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
     * 通过模块下的id查询这个id所对应的rule表的信息
     * @param array $modules
     * @return array
     */
    static public function getRulesByModules($modules = []) {
        try {
            $role_id_rule_name_arr = $role_id_rule_id_arr = [];

            $role_id_arr = array_column($modules['data'], 'id');

            $sql = "SELECT r.`id`, r.`name`, a.`role_id` FROM `authority` AS a LEFT JOIN `rule` as r ON a.`rule_id` = r.`id` WHERE a.`role_id` in ('" . implode("', '", $role_id_arr) . "')";
            $rules = RuleModel::getInstance()->query($sql);

            foreach ($rules as $rule) {
                if (! isset($role_id_rule_name_arr[$rule['role_id']])) {
                    $role_id_rule_id_arr[$rule['role_id']] = $rule['id'];
                    $role_id_rule_name_arr[$rule['role_id']] = $rule['name'];
                } else {
                    $role_id_rule_id_arr[$rule['role_id']] .= ',' . $rule['id'];
                    $role_id_rule_name_arr[$rule['role_id']] .= ',' . $rule['name'];
                }
            }

        } catch (ModelSqlException $e) {
        } finally {
            foreach ($modules['data'] as $idx => $val) {
                $modules['data'][$idx]['rule_name'] = isset($role_id_rule_name_arr[$val['id']]) ? $role_id_rule_name_arr[$val['id']] : '';
                $modules['data'][$idx]['rule_id'] = isset($role_id_rule_id_arr[$val['id']]) ? $role_id_rule_id_arr[$val['id']] : '';
            }

            return $modules;
        }


    }

}
