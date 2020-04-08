<?php

use Yaf\Registry;
use models\Business\Role;

class RoleController extends ApiBaseController
{
    /**
     * @SWG\Get(
     *     path="/admin/role/list",
     *     tags={"角色模块"},
     *     summary="角色列表接口",
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
     *          name="name",
     *          description="角色名 模糊查询",
     *          in="query",
     *          required=false,
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
     *         @SWG\Schema(type="object", ref="#/definitions/roleListData")
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

        $role_list = Role::getRoleList($parameters);

        return $this->_responseJson($role_list);
    }

    /**
     * @SWG\Post(
     *     path="/admin/role/create",
     *     tags={"角色模块"},
     *     summary="创建角色接口",
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
     *          description="角色名",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="access",
     *          description="多个权限用半角逗号间隔 admin/access/list接口返回的id",
     *          in="formData",
     *          required=true,
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
     *         @SWG\Schema(type="object", ref="#/definitions/roleSingleData")
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

        $role = Role::createRole($parameters);

        return $this->_responseJson(['data' => $role]);
    }

    /**
     * @SWG\Put(
     *     path="/admin/role/{id}/edit",
     *     tags={"角色模块"},
     *     summary="编辑角色接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="id",
     *          description="/admin/role/list接口返回的id字段的值",
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
     *          description="角色名",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="access",
     *          description="多个权限用半角逗号间隔 admin/access/list接口返回的id",
     *          in="formData",
     *          required=true,
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
     *         @SWG\Schema(type="object", ref="#/definitions/roleSingleData")
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

        $role = Role::editRole($parameters);

        return $this->_responseJson(['data' => $role]);
    }

    /**
     * @SWG\Delete(
     *     path="/admin/role/{id}/delete",
     *     tags={"角色模块"},
     *     summary="删除角色接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="id",
     *          description="/admin/role/list接口返回的id字段的值",
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
        //删除角色
        Role::deleteRole(Registry::get('parameters')['id']);

        return $this->_responseJson(new stdClass(), '000', '删除成功');
    }

}
