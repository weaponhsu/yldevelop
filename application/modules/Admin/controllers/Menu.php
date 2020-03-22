<?php

use Yaf\Registry;
use models\Business\Menu;

class MenuController extends ApiBaseController
{

    /**
     * @SWG\Get(
     *     path="/admin/menu/list",
     *     tags={"菜单模块"},
     *     summary="获取菜单列表",
     *     description="",
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="Authorization 登录接口返回的jwt字段的值",
     *          in="header",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="page",
     *          description="页码",
     *          in="query",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="page_size",
     *          description="每页显示条数",
     *          in="query",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="sort",
     *          description="排序方式 可选值: desc|asc",
     *          in="query",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="order",
     *          description="排序字段 可选值: id",
     *          in="query",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="sign",
     *          description="签名",
     *          in="query",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="请求成功",
     *         @SWG\Schema(type="object", ref="#/definitions/menuListData")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="签名不存在或无效签名"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="jwt无效或过期，需要登录"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="无权访问"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="找不到数据"
     *     )
     * )
     */
    public function listAction() {
        $parameters = Registry::get('parameters');

        $menu_list = Menu::getMenuList($parameters);

        return $this->_responseJson($menu_list);
    }

    /**
     * @SWG\Post(
     *     path="/admin/menu/create",
     *     tags={"菜单模块"},
     *     summary="创建菜单接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="Authorization 登录接口返回的jwt字段的值",
     *          in="header",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="name",
     *          description="菜单中文名",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="parent",
     *          description="上级编号 admin/menu/list接口传入is_operation=0",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="type",
     *          description="类型，可选值: 0为菜单项、1为接口",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="url",
     *          description="接口地址 若是菜单项则该参数为空",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="sign",
     *          description="签名",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="请求成功",
     *         @SWG\Schema(type="object", ref="#/definitions/menuSingleData")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="签名不存在或无效签名"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="jwt无效或过期，需要登录"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="无权访问"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="找不到数据"
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="创建失败"
     *     )
     * )
     */
    public function createAction() {
        $parameters = Registry::get('parameters');

        $menu = Menu::createMenu($parameters);

        return $this->_responseJson(['data' => $menu]);
    }

    /**
     * @SWG\Put(
     *     path="/admin/menu/{id}/edit",
     *     tags={"菜单模块"},
     *     summary="编辑菜单接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="id",
     *          description="/admin/menu/list接口返回的id字段的值",
     *          in="path",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="Authorization 登录接口返回的jwt字段的值",
     *          in="header",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="name",
     *          description="菜单中文名",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="parent",
     *          description="上级编号 admin/menu/list接口传入is_operation=0",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="type",
     *          description="类型，可选值: 0为菜单项、1为接口",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="url",
     *          description="接口地址 若是菜单项则该参数为空",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="sign",
     *          description="签名",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="请求成功",
     *         @SWG\Schema(type="object", ref="#/definitions/menuSingleData")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="签名不存在或无效签名"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="jwt无效或过期，需要登录"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="无权访问"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="找不到数据"
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="编辑失败"
     *     )
     * )
     */
    public function editAction() {
        $parameters = Registry::get('parameters');

        $menu = Menu::editMenu($parameters);

        return $this->_responseJson(['data' => $menu]);
    }

    /**
     * @SWG\Delete(
     *     path="/admin/menu/{id}/delete",
     *     tags={"菜单模块"},
     *     summary="删除菜单接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="id",
     *          description="/admin/menu/list接口返回的id字段的值",
     *          in="path",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="Authorization 登录接口返回的jwt字段的值",
     *          in="header",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="删除成功, 没有返回结果"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="签名不存在或无效签名"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="jwt无效或过期，需要登录"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="无权访问"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="角色已经不存在了"
     *     )
     * )
     */
    public function deleteAction() {
        $parameters = Registry::get('parameters');

        Menu::deleteMenu($parameters['id']);

        return $this->_responseJson(new stdClass(), '000', '删除成功');
    }

}
