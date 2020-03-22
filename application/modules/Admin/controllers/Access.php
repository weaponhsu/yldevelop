<?php

use Yaf\Registry;
use models\Business\Rule;

class AccessController extends ApiBaseController
{
    /**
     * @SWG\Get(
     *     path="/admin/access/list",
     *     tags={"权限模块"},
     *     summary="获取权限列表",
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
     *         @SWG\Schema(type="object", ref="#/definitions/ruleListData")
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

        $rule_list = Rule::getRulesList($parameters);

        return $this->_responseJson($rule_list);
    }

    /**
     * @SWG\Post(
     *     path="/admin/access/create",
     *     tags={"权限模块"},
     *     summary="创建权限接口",
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
     *          description="权限名称",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="stats",
     *          description="状态 可选值: 0为否,1为是",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="menu_id",
     *          description="菜单编号 多个用半角逗号间隔 数据从admin/menu/list接口获取",
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

        $access = Rule::createRule($parameters);

        return $this->_responseJson($access);
    }

    /**
     * @SWG\Put(
     *     path="/admin/access/{id}/edit",
     *     tags={"权限模块"},
     *     summary="编辑权限接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="id",
     *          description="/admin/access/list接口返回的id字段的值",
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
     *          description="权限名",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="stats",
     *          description="状态 可选值: 0为否,1为是",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="menu_id",
     *          description="菜单编号 多个用半角逗号间隔 数据从admin/menu/list接口获取",
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

        $access = Rule::editRule($parameters);

        return $this->_responseJson($access);
    }

    /**
     * @SWG\Delete(
     *     path="/admin/access/{id}/delete",
     *     tags={"权限模块"},
     *     summary="删除单个权限接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="id",
     *          description="/admin/access/list接口返回的id字段的值",
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

        Rule::deleteRule($parameters['id']);

        return $this->_responseJson(new stdClass(), '000', '删除成功');
    }
}
