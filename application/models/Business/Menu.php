<?php


namespace models\Business;


use models\DAO\MenuModel;
use models\Exception\Business\MenuException;
use models\Exception\DAO\ModelDriverException;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\DAO\ModelSqlException;
use models\Exception\Service\ServiceException;
use models\Exception\Transformer\TransformerException;
use models\Service\MenuService;
use Yaf\Registry;

class Menu
{
    /**
     * @param $menu_id
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     */
    static public function deleteMenu($menu_id) {
        try {
            MenuService::getInstance()->delete($menu_id);
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
     * @param array $parameters
     * @return array|mixed|null
     * @throws MenuException
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws TransformerException
     */
    static public function editMenu($parameters= []) {
        try {
            if (! isset($parameters['id']) || empty($parameters['id']))
                throw new MenuException(MenuException::MENU_ID_EMPTY, MenuException::MENU_ID_EMPTY_NO);

            $update_arr = [];
            if (isset($parameters['name']))
                $update_arr['name'] = $parameters['name'];

            if (isset($parameters['parent'])) {
                $parent = MenuService::getInstance()->getOne($parameters['parent']);
                $update_arr['path'] = $parent['path'] . $parent['id'] . '-';
                $update_arr['parent'] = $parameters['parent'];
            }

            if (isset($parameters['type'])) {
                $update_arr['display'] = $parameters['type'] == 0 ? 1 : 0;
                $update_arr['is_operation'] = $parameters['type'] == 1 ? 1 : 0;
            }

                $update_arr['type'] = $parameters['type'];

            if (isset($parameters['url'])) {
                if ($update_arr['type'] == 1 && empty($parameters['url']))
                    throw new MenuException(MenuException::API_HAS_NO_URL, MenuException::API_HAS_NO_URL_NO);

                $update_arr['url'] = $parameters['url'];
                $update_arr['updated_at'] = date("Y-m-d H:i:s", time());
                $update_arr['updated_by'] = Registry::get('jwt_info')->id;

                $menu = MenuService::getInstance()->update($update_arr, $parameters['id']);
            } else
                $menu = MenuService::getInstance()->getOne($parameters['id']);

            return $menu;

        } catch (MenuException $e) {
            throw $e;
        } catch (ModelDriverException $e) {
            if ($e->getCode() == ModelDriverException::DRIVER_EXCEPTION_MSG_NO)
                throw new MenuException(MenuException::MENU_EDIT_FAILURE, MenuException::MENU_EDIT_FAILURE_NO);
            throw $e;
        } catch (ModelException $e) {
            if ($e->getCode() == ModelException::DATA_NOT_EXISTS_NO)
                throw new MenuException(MenuException::MENU_NOT_EXISTS, MenuException::MENU_NOT_EXISTS_NO);
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
     * @throws MenuException
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws TransformerException
     */
    static public function createMenu($parameters = []) {
        try {
            if (!empty($parameters['parent'])) {
                $parent = MenuService::getInstance()->getOne($parameters['parent']);
                $parameters['path'] = $parent['path'] . $parent['id'] . '-';
            } else {
                $parameters['path'] = '0-';
            }

            if ($parameters['type'] == 1 && empty($parameters['url']))
                throw new MenuException(MenuException::API_HAS_NO_URL, MenuException::API_HAS_NO_URL_NO);

            return MenuService::getInstance()->create($parameters['name'], $parameters['parent'], $parameters['path'],
                isset($parameters['url']) ? $parameters['url'] : '0',
                $parameters['type'] == 0 ? 1 : 0,
                $parameters['type'] == 1 ? 1 : 0, 0,
                Registry::get('jwt_info')->id, Registry::get('jwt_info')->id);
        } catch (MenuException $e) {
            throw $e;
        } catch (ModelDriverException $e) {
            if ($e->getCode() == '120001')
                throw new MenuException(MenuException::MENU_CREATE_FAILURE, MenuException::MENU_CREATE_FAILURE_NO);
            throw $e;
        } catch (ModelException $e) {
            if ($e->getCode() == '110002')
                throw $e;
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
     * @throws MenuException
     */
    static public function getMenuList($parameters = []) {
        try {
            $where_arr = $rules = $condition = [];
            if (isset($parameters['is_operation'])) {
                array_push($rules, ['field' => 'is_operation', 'op' => 'eq', 'data' => $parameters['is_operation']]);
                array_push($where_arr, 'is_operation = ' . $parameters['is_operation']);
            }

            if (isset($parameters['is_display'])) {
                array_push($rules, ['field' => 'display', 'op' => 'eq', 'data' => $parameters['display']]);
                array_push($where_arr, 'display = ' . $parameters['display']);
            }

            $sql = "SELECT `id`, `name`, `parent`, CONCAT(`path`, `id`) AS route, `url`, `display`, `is_operation` FROM `menu`";
            if (!empty($where_arr))
                $sql .= " WHERE " . implode(' AND ', $where_arr);

            $menu_model = MenuModel::getInstance();
            $menu_model->page = isset($parameters['page']) ? $parameters['page'] : 1;
            $menu_model->page_size = isset($parameters['page_size']) ? $parameters['page_size'] : 10;
            $count = $menu_model->getCount(empty($rules) ? [] : ['groupOp' => 'AND', 'rules' => $rules]);
            $total = $count->fetchColumn();
            $menu_model->genMeta($total);

            $sql .= " ORDER BY route ASC, `id` DESC";
            $sql .= ($parameters['page'] === 0 && $parameters['page_size'] === 0 ? " LIMIT 1" : " LIMIT " . (($parameters['page'] - 1) * $parameters['page_size']) . ', ' . $parameters['page_size']);
            $result = $menu_model->query($sql);
            $menu_model->setModelProperty($result, true);
            $return_data = [
                'data' => $menu_model->data,
                'meta' => $menu_model->meta
            ];

            $parent_id_arr = array_unique(array_column($return_data['data'], 'parent'));
            $parent = MenuService::getInstance()->getList(1, count($parent_id_arr), 'asc', 'id',
                ['groupOp' => 'AND', 'rules' => [['field' => 'id', 'op' => 'in', 'data' => implode(',', array_values($parent_id_arr))]]]);
            $parent_arr = array_column($parent['data'], 'name', 'id');

            foreach ($return_data['data'] as $idx => $data) {
                $return_data['data'][$idx]['parent_name'] = isset($parent_arr[$data['parent']]) ?
                    $parent_arr[$data['parent']] : '';
            }

            return $return_data;

            /*return MenuService::getInstance()->getList(
                isset($parameters['page']) ? $parameters['page'] : 1,
                isset($parameters['page_size']) ? $parameters['page_size'] : 10,
                isset($parameters['sort']) ? $parameters['sort'] : 'desc',
                isset($parameters['order']) ? $parameters['order'] : 'id',
                $condition
            );*/
        } catch (ModelDriverException $e) {
        } catch (ModelException $e) {
            if ($e->getCode() == '120002')
                throw new MenuException(MenuException::MENU_NOT_EXISTS, MenuException::MENU_NOT_EXISTS_NO);
        } catch (ModelReflectionException $e) {
        } catch (ModelSqlException $e) {
        } catch (ServiceException $e) {
        } catch (TransformerException $e) {
        }
    }
}
