<?php


namespace models\Business;


use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use models\Exception\Business\MenuException;
use models\Exception\Business\RuleException;
use models\DAO\RuleModel;
use models\DAO\AccessModel;
use models\DAO\MenuModel;
use Yaf\Registry;

class Rule
{
    /**
     * @param $rule_id
     * @return mixed
     * @throws RuleException
     */
    static public function deleteRule($rule_id) {
        try {
            if (empty($rule_id))
                throw new RuleException(RuleException::RULE_ID_NOT_EXISTS, RuleException::RULE_ID_NOT_EXISTS_NO);

            // 测试用 一个不存在rule_id
//            $rule_id = 100;
            Capsule::transaction(function () use (&$rule_id) {
                Capsule::table('rule')->where('id', '=', $rule_id)->delete();
                Capsule::table('access')->where('rule_id', '=', $rule_id)->delete();
            }, 5);

        } catch (QueryException $e) {
            throw new RuleException(RuleException::RULE_NOT_EXISTS, RuleException::RULE_NOT_EXISTS_NO);
        } catch (RuleException $e) {
            throw $e;
        }
    }

    /**
     * 删除指定rule_id在access表中的所有记录
     * @param $rule_id
     * @throws RuleException
     */
    static public function deleteAccess($rule_id) {
        try {
            if (empty($rule_id))
                throw new RuleException(RuleException::RULE_ID_NOT_EXISTS, RuleException::RULE_ID_NOT_EXISTS_NO);

            $access_model = new AccessModel();
            $access_model->where('rule_id', '=', $rule_id)->delete();
        } catch (QueryException $e) {
            throw new RuleException(RuleException::RULE_NOT_EXISTS, RuleException::RULE_NOT_EXISTS_NO);
        }
    }

    /**
     * @param $rule_id
     * @param $menu_id
     * @return array
     * @throws MenuException
     * @throws RuleException
     */
    static public function createAccess($rule_id, $menu_id) {
        try {
            $return_data = [];
            if (empty($rule_id) || empty($menu_id))
                return $return_data;

            $menu = new MenuModel();
            // 测试用 测试菜单不存在的情况
//            $menu_id = '100,101';
            $menus = $menu->whereIn('id', explode(',', $menu_id))->get()->toArray();
            if (empty($menus))
                throw new MenuException(MenuException::MENU_NOT_EXISTS, MenuException::MENU_NOT_EXISTS_NO);

            $batch_insert_arr = [];
            foreach ($menus as $idx => $menu) {
                array_push($batch_insert_arr, ['rule_id' => $rule_id, 'menu_id' => $menu['id']]);
            }

            if (!empty($batch_insert_arr)) {
                $access = new AccessModel();
                if ($access->insert($batch_insert_arr) === false)
                    throw new RuleException(RuleException::RULE_BATCH_INSERT_MENU_FAILURE, RuleException::RULE_BATCH_INSERT_MENU_FAILURE_NO);
            }
        } catch (QueryException $e) {
            throw new RuleException(RuleException::RULE_BATCH_INSERT_MENU_FAILURE, RuleException::RULE_BATCH_INSERT_MENU_FAILURE_NO);
        } catch (MenuException $e) {
            throw $e;
        } catch (RuleException $e) {
            throw $e;
        }
    }

    /**
     * @param array $parameters
     * @throws MenuException
     * @throws RuleException
     */
    static public function editRule($parameters = []) {
        try {
            if (!isset($parameters['id']) || empty($parameters['id']))
                throw new RuleException(RuleException::RULE_ID_NOT_EXISTS, RuleException::RULE_ID_NOT_EXISTS_NO);

            $rule_model = new RuleModel();
            $rule = $rule_model->findOrFail($parameters['id']);
            $parameters['updated1_by'] = Registry::get('jwt_info')->id;

            foreach ($parameters as $column_name => $value) {
                if (in_array($column_name, array_keys($rule->getAttributes())) &&
                    !in_array($column_name, [$rule_model->getKeyName(), 'sign']) &&
                    $rule->$column_name != $value
                ) {
                    $rule->$column_name = $value;
                }
            }
            $rule->save();

            if (isset($parameters['menu_id'])) {
                self::deleteAccess($parameters['id']);
                self::createAccess($parameters['id'], $parameters['menu_id']);
//                $rule['menu_id'] = $access_res['menu_id'];
//                $rule['menu_name'] = $access_res['menu_name'];
            }
        } catch (ModelNotFoundException $e) {
            throw new RuleException(RuleException::RULE_NOT_EXISTS, RuleException::RULE_NOT_EXISTS_NO);
        } catch (RuleException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new RuleException(RuleException::RULE_EDIT_FAILURE, RuleException::RULE_EDIT_FAILURE_NO);
        }
    }

    /**
     * @param array $parameters
     * @return RuleModel
     * @throws MenuException
     * @throws RuleException
     */
    static public function createRule($parameters = []) {

        try {
            $rule_model = new RuleModel();

            if (isset($parameters['name']))
                $rule_model->name = $parameters['name'];

            $rule_model->stats = 1;

            $rule_model->save();

            $access_res = self::createAccess($rule_model->id, $parameters['menu_id']);
//            $rule_model->menu_id = $access_res['menu_id'];
//            $rule_model->menu_name = $access_res['menu_name'];

            return $rule_model;
        } catch (QueryException $e) {
            throw new RuleException(RuleException::RULE_CREATE_FAILURE, RuleException::RULE_CREATE_FAILURE_NO);
        }
    }

    /**
     * @param array $parameters
     * @return array
     * @throws RuleException
     */
    static public function getRulesList($parameters = []) {
        try {
            $where_arr = $prepare_arr = [];
            $sql = "SELECT r.`id`, r.`name` AS rule_name, r.`stats`, r.`created_at`, r.`created_by`, r.`updated_at`, r.`updated_by`, m.`id` as menu_id, m.`name` as menu_name ".
                "FROM `rule` AS r LEFT JOIN `access` AS a ON r.`id` = a.`rule_id` ".
                "LEFT JOIN `menu` AS m ON a.`menu_id` = m.id ";
//                "WHERE m.`is_operation` = ?";
            if (isset($parameters['name']) && ! empty($parameters['name'])) {
                array_push($where_arr, "r.`name` like :r_name");
                $prepare_arr[':r_name'] = '%' . $parameters['name'] . '%';
            }
            array_push($where_arr, "m.`is_operation` = :m_is_operation");
            $prepare_arr[':m_is_operation'] = 1;

            if (!empty($where_arr))
                $sql .= "WHERE " . implode(' AND ', $where_arr);

            $rules = Capsule::select($sql, $prepare_arr);
            if (empty($rules))
                throw new RuleException(RuleException::RULE_NOT_EXISTS, RuleException::RULE_NOT_EXISTS_NO);

            $rules_list = ['data' => []];
            $match_rules_list = [];
            foreach ($rules as $idx => $val) {
                if (! in_array($val->id, $match_rules_list)) {
                    array_push($rules_list['data'], [
                        'id' => $val->id,
                        'name' => $val->rule_name,
                        'stats' => $val->stats,
                        'created_at' => $val->created_at,
                        'created_by' => $val->created_by,
                        'updated_at' => $val->updated_at,
                        'updated_by' => $val->updated_by,
                        'menu_id' => $val->menu_id,
                        'menu_name' => $val->menu_name
                    ]);
                    array_push($match_rules_list, $val->id);
                } else {
                    $key = array_search($val->id, $match_rules_list);
                    $rules_list['data'][$key]['menu_id'] .= ',' . $val->menu_id;
                    $rules_list['data'][$key]['menu_name'] .= ',' . $val->menu_name;
                }
            }

            $rules_list = User::getUsersByModule($rules_list);
            $rules_list['meta'] = new \stdClass();

            return $rules_list;

        } catch (RuleException $e) {
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

            $where_arr = $prepare_arr = [];
            foreach ($role_id_arr as $idx => $role_id) {
                array_push($where_arr, ':a_role_id_' . $idx);
                $prepare_arr[':a_role_id_' . $idx] = $role_id;
            }
            $sql = "SELECT r.`id`, r.`name`, a.`role_id` FROM `authority` AS a LEFT JOIN `rule` as r ON a.`rule_id` = r.`id` WHERE a.`role_id` in (" . implode(',', $where_arr) . ")";
            $rules = Capsule::select($sql, $prepare_arr);

            foreach ($rules as $rule) {
                if (! isset($role_id_rule_name_arr[$rule->role_id])) {
                    $role_id_rule_id_arr[$rule->role_id] = $rule->id;
                    $role_id_rule_name_arr[$rule->role_id] = $rule->name;
                } else {
                    $role_id_rule_id_arr[$rule->role_id] .= ',' . $rule->id;
                    $role_id_rule_name_arr[$rule->role_id] .= ',' . $rule->name;
                }
            }

        } catch (\Exception $e) {
        } finally {
            foreach ($modules['data'] as $idx => $val) {
                $modules['data'][$idx]->rule_name = isset($role_id_rule_name_arr[$val->id]) ? $role_id_rule_name_arr[$val->id] : '';
                $modules['data'][$idx]->rule_id = isset($role_id_rule_id_arr[$val->id]) ? $role_id_rule_id_arr[$val->id] : '';
            }

            return $modules;
        }


    }

}
