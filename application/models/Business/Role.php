<?php


namespace models\Business;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use models\Exception\Business\RoleException;
use models\Exception\Business\RuleException;
use models\Exception\DAO\ModelException;
use models\DAO\EloquentPaginator;
use models\DAO\RoleModel;
use Yaf\Registry;
use Illuminate\Database\Capsule\Manager as Capsule;


class Role
{
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

            if (count($role_id_arr) > 1)
                $role_list = RoleModel::whereIn('id', $role_id_arr)->get()->toArray();
            else if (count($role_id_arr) == 1)
                $role_list[] = RoleModel::find(implode('', array_values($role_id_arr)))->toArray();

            $role_id_name_arr = array_column($role_list, 'name', 'id');

        } catch (\Exception $e) { }
        finally {
            foreach ($modules['data'] as $idx => $val) {
                if (isset($val->role))
                    $modules['data'][$idx]->role_name = isset($role_id_name_arr[$val->role]) ? $role_id_name_arr[$val->role] : '';
                else if (isset($val->role_id))
                    $modules['data'][$idx]->role_name = isset($role_id_name_arr[$val->role]) ? $role_id_name_arr[$val->role] : '';
            }

            return $modules;
        }
    }

    /**
     * 获取角色列表
     * @param array $parameters
     * @return array
     * @throws ModelException
     * @throws RoleException
     */
    static public function getRoleList($parameters = []) {
        try {
            $role_model = new RoleModel();

            if (isset($parameters['name']) && !empty($parameters['name'])) {
                $role_model = $role_model->where('name', 'like', '%' . $parameters['name'] . '%');
            }

            $paginator = EloquentPaginator::getInstance($role_model,
                isset($parameters['page']) ? $parameters['page'] : 1,
                isset($parameters['page_size']) ? $parameters['page_size'] : 10
            )->setSort(isset($parameters['sort']) ? $parameters['sort'] : 'desc')
                ->setOrder(isset($parameters['order']) ? $parameters['order'] : 'id')
                ->paginator();

            $role_list = ['data' => $paginator->getdata(), 'meta' => $paginator->getMeta()];

            $role_list = User::getUsersByModule($role_list);

            $role_list = Rule::getRulesByModules($role_list);

            return $role_list;
        } catch (ModelException $e) {
            if ($e->getCode() == ModelException::DATA_NOT_EXISTS_NO)
                throw new RoleException(RoleException::ROLE_NOT_EXISTS, RoleException::ROLE_NOT_EXISTS_NO);
            throw $e;
        }
    }

    /**
     * @param array $parameters
     * @return RoleModel
     * @throws RoleException
     */
    static public function createRole($parameters = []) {
        Capsule::beginTransaction();
        try {
            $role_model = new RoleModel();
            $role_model->name = $parameters['name'];
            $role_model->created_by = Registry::get('jwt_info')->id;
            $role_model->updated_by = Registry::get('jwt_info')->id;
            $role_model->save();

            $batch_insert_arr = [];
            foreach (explode(',', $parameters['access']) as $rule_id)
                array_push($batch_insert_arr, ['role_id' => $role_model->id, 'rule_id' => $rule_id]);

            if (!empty($batch_insert_arr))
                Capsule::table("authority")->insert($batch_insert_arr);

            Capsule::commit();

            return $role_model;
        } catch (QueryException $e) {
            if ($e->getCode() == '23000')
                throw new RoleException(RoleException::ROLE_UNIQUE, RoleException::ROLE_UNIQUE_NO);
            throw $e;
        } catch (\Exception $e) {
            Capsule::rollBack();
            throw new RoleException(RoleException::ROLE_CREATE_FAILURE, RoleException::ROLE_CREATE_FAILURE_NO);
        }
    }

    /**
     * 更新角色
     * @param array $parameters
     * @return RoleModel
     * @throws RoleException
     * @throws RuleException
     */
    static public function editRole($parameters = []) {
        Capsule::beginTransaction();
        try {
            if ( !isset($parameters['id']) || empty($parameters['id']))
                throw new RoleException(RoleException::ROLE_ID_IS_EMPTY, RoleException::ROLE_ID_IS_EMPTY_NO);

            // 测试用 一个id不存在role
//            $parameters['id'] = 100;
            $role_model = new RoleModel();
            $role = $role_model->findOrFail($parameters['id']);

            $update = false;
            if (isset($parameters['name'])) {
                $role->name = $parameters['name'];
                $update = true;
            }

            if ($update === true) {
                $role->updated_by = Registry::get('jwt_info')->id;
                $role->update();
            }

            // 删除已有权限
            Capsule::table("authority")->where('role_id', '=', $parameters['id'])->delete();

            // 添加新权限
            $batch_insert_arr = [];
            foreach (explode(',', $parameters['access']) as $rule_id)
                array_push($batch_insert_arr, ['role_id' => $parameters['id'], 'rule_id' => $rule_id]);
            if (!empty($batch_insert_arr))
                Capsule::table("authority")->insert($batch_insert_arr);

            Capsule::commit();

            return $role_model;
        } catch (ModelNotFoundException $e) {
            throw new RuleException(RuleException::RULE_NOT_EXISTS, RuleException::RULE_NOT_EXISTS_NO);
        } catch (RoleException $e) {
            throw $e;
        } catch (QueryException $e) {
            Capsule::rollBack();
            if ($e->getCode() == '23000')
                throw new RoleException(RoleException::ROLE_UNIQUE, RoleException::ROLE_UNIQUE_NO);
            throw new RoleException(RoleException::ROLE_EDIT_FAILURE, RoleException::ROLE_EDIT_FAILURE_NO);
        }
    }

    /**
     * @param $role_id
     * @throws RoleException
     */
    static public function deleteRole($role_id){
        Capsule::beginTransaction();
        try {
            if ( empty($role_id))
                throw new RoleException(RoleException::ROLE_ID_IS_EMPTY, RoleException::ROLE_ID_IS_EMPTY_NO);

            // 测试用 一个id不存在role
//            $parameters['id'] = 100;
            $role_model = new RoleModel();
            $role = $role_model->findOrFail($role_id);

            $role->delete();

            // 删除已有权限
            Capsule::table("authority")->where('role_id', '=', $role_id)->delete();

            Capsule::commit();

        } catch (ModelNotFoundException $e) {
            throw new RoleException(RoleException::ROLE_NOT_EXISTS, RoleException::ROLE_NOT_EXISTS_NO);
        } catch (RoleException $e) {
            throw $e;
        } catch (QueryException $e) {
            Capsule::rollBack();
            throw new RoleException(RoleException::ROLE_CREATE_FAILURE, RoleException::ROLE_CREATE_FAILURE_NO);
        }
    }

}
