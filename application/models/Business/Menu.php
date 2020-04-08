<?php


namespace models\Business;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use models\Exception\Business\MenuException;
use Yaf\Registry;
use models\DAO\MenuModel;
use Illuminate\Database\Capsule\Manager as Capsule;

class Menu
{
    /**
     * @param $menu_id
     * @throws MenuException
     */
    static public function deleteMenu($menu_id) {
        try {
            $menu = MenuModel::findOrFail($menu_id);
            $menu->delete();
        } catch (ModelNotFoundException $e) {
            throw new MenuException(MenuException::MENU_NOT_EXISTS, MenuException::MENU_NOT_EXISTS_NO);
        }
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws MenuException
     */
    static public function editMenu($parameters= []) {
        try {
            if (! isset($parameters['id']) || empty($parameters['id']))
                throw new MenuException(MenuException::MENU_ID_EMPTY, MenuException::MENU_ID_EMPTY_NO);

            // 测试用 会报错的情况
//            $parameters['id'] = '1000';
            $menu_model = new MenuModel();
            $menu = $menu_model->findOrFail($parameters['id']);

            $update = false;
            if (isset($parameters['name']) && $parameters['name'] != $menu->name) {
                $update = true;
                $menu->name = $parameters['name'];
            }

            if (isset($parameters['parent'])) {
                // 测试用 会报错的情况
//                $parameters['parent'] = 1000;
                $parent = $menu_model->findOrFail($parameters['parent']);
                if ($parameters['parent'] !== $menu->parent) {
                    $menu->path = $parent->path . $parent->id . '-';
                    $menu->parent = $parent->id;
                    $update = true;
                }
            }

            if (isset($parameters['type'])) {
                $menu->display = $parameters['type'] == 0 ? 1 : 0;
                $menu->is_operation = $parameters['type'] == 1 ? 1 : 0;
                $update = true;
            }

            if (isset($parameters['url'])) {
                if (isset($parameters['type']) && $parameters['type'] == 1 && empty($parameters['url']))
                    throw new MenuException(MenuException::API_HAS_NO_URL, MenuException::API_HAS_NO_URL_NO);

                $menu->url = $parameters['url'];
                $menu->updated_by =  Registry::get('jwt_info')->id;
                $update = true;
            }

            if ($update === true) {
                $menu->save();
            }

            return $menu;

        } catch (MenuException $e) {
            throw $e;
        } catch (ModelNotFoundException $e) {
            throw new MenuException(MenuException::MENU_NOT_EXISTS, MenuException::MENU_NOT_EXISTS_NO);
        } catch (QueryException $e) {
            throw new MenuException(MenuException::MENU_EDIT_FAILURE, MenuException::MENU_EDIT_FAILURE_NO);
        }
    }

    /**
     * @param array $parameters
     * @return MenuModel
     * @throws MenuException
     */
    static public function createMenu($parameters = []) {
        try {
            $menu = new MenuModel();

            if (!empty($parameters['parent'])) {
                $parent = $menu->findOrFail($parameters['parent']);
                $menu->path = $parent->path . $parent->id . '-';
                $menu->parent = $parent->id;
            } else {
                $menu->path = '0-';
                $menu->parent = 0;
            }

            if ($parameters['type'] == 1 && empty($parameters['url']))
                throw new MenuException(MenuException::API_HAS_NO_URL, MenuException::API_HAS_NO_URL_NO);
            else {
                if ($parameters['type'] == 1) {
                    $menu->display = 0;
                    $menu->is_operation = 1;
                } else if ($parameters['type'] == 0) {
                    $menu->display = 1;
                    $menu->is_operation = 0;
                }
            }

            $menu->name = $parameters['name'];
            $menu->url = $parameters['url'];
            $menu->name = $parameters['name'];

            $menu->save();

            return $menu;
        } catch (MenuException $e) {
            throw $e;
        } catch (QueryException $e) {
            throw new MenuException(MenuException::MENU_CREATE_FAILURE, MenuException::MENU_CREATE_FAILURE_NO);
        } catch (ModelNotFoundException $e) {
            throw new MenuException(MenuException::MENU_NOT_EXISTS, MenuException::MENU_NOT_EXISTS_NO);
        }
    }

    /**
     * @param array $parameters
     * @return array
     * @throws MenuException
     */
    static public function getMenuList($parameters = []) {
        $where_arr = $prepare_arr = $rules = $condition = [];
        $menu_model = new MenuModel();

        if (isset($parameters['is_operation'])) {
            $menu_model = $menu_model->where("is_operation", $parameters['is_operation']);
            array_push($where_arr, 'is_operation = :is_operation');
            $prepare_arr[':is_operation'] = $parameters['is_operation'];
        }

        if (isset($parameters['display'])) {
            $menu_model = $menu_model->where("display", $parameters['display']);
            array_push($where_arr, 'display = :display');
            $prepare_arr[':display'] = $parameters['display'];
        }

        $order = isset($parameters['order']) ? $parameters['order'] : 'route';
        $sort = isset($parameters['sort']) ? $parameters['sort'] : 'asc';
        $menu_model = $menu_model->orderBy($order, $sort);

        $total = $menu_model->count();
        $page = isset($parameters['page']) ? $parameters['page'] : 1;
        $end_pos = $page_size = isset($parameters['page_size']) ? $parameters['page_size'] : 10;
        $total_page = ceil($total / $page_size);
        if ($page > $total_page)
            throw new MenuException(MenuException::MENU_NOT_EXISTS, MenuException::MENU_NOT_EXISTS_NO);

        $start_pos = ($page >= $total_page ? ($total_page - 1) : ($page - 1)) * $page_size;
        $meta = [
            'total' => $total,
            'total_page' => $total_page,
            'current_page' => $page,
            'page_size' => $page_size,
            'link' => []
        ];
        if ($total_page > 1) {
            if ($total_page > $page) {
                $meta['link']['next_page'] =$page + 1;
                if ($page > 1) {
                    $meta['link']['pre_page'] = $page - 1;
                }
            } else if ($total_page == $page) {
                $meta['link']['pre_page'] = $page - 1;
            }
        }

        $sql = "SELECT `id`, `name`, `parent`, CONCAT(`path`, `id`) AS route, `url`, `display`, `is_operation` FROM `menu`";
        if (!empty($where_arr))
            $sql .= " WHERE " . implode(' AND ', $where_arr);
        $sql .= " ORDER BY " . $order . " " . $sort . " LIMIT " . $start_pos . ", " . $end_pos;

        $menu = Capsule::select($sql, $prepare_arr);
        $return_data = [
            'data' => $menu,
            'meta' => $meta
        ];

        $parent_id_arr = array_unique(array_column($return_data['data'], 'parent'));
        $parent_menu = new MenuModel();
        $parent = $parent_menu->whereIn("id", array_values($parent_id_arr))->get()->toArray();
        $parent_arr = array_column($parent, 'name', 'id');

        foreach ($return_data['data'] as $idx => $data) {
            $return_data['data'][$idx]->parent_name = isset($parent_arr[$data->parent]) ?
                $parent_arr[$data->parent] : '';
        }

        return $return_data;
    }
}
