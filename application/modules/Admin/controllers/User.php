<?php

use Yaf\Registry;
use Yaf\Session;
use Common\AccessToken4Api;
use ErrorMsg\Admin\AccessErrMsg;
use models\Business\User;

class UserController extends ApiBaseController
{
    /**
     * @SWG\Post(
     *     path="/admin/user/login",
     *     tags={"登录登出"},
     *     summary="后台账号登录接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="username",
     *          description="用户名",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="password",
     *          description="密码",
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
     *         response="200",
     *         description="请求成功",
     *         @SWG\Schema(type="object", ref="#/definitions/userSingleData")
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="签名不存在或无效签名"
     *     )
     * )
     */
    public function loginAction() {
        // 登录
        $user_info = User::login(Registry::get('parameters')['username'], Registry::get('parameters')['password']);

        return $this->_responseJson(['data' => $user_info]);
    }

    /**
     * @SWG\Get(
     *     path="/admin/user/{id}/authenticator",
     *     tags={"登录登出"},
     *     summary="谷歌认证接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="Authorization 登录接口返回的jwt字段的值",
     *          in="header",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          description="登陆接口返回的id字段的值",
     *          in="path",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="code",
     *          description="谷歌验证码",
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
     *         description="请求成功"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="签名不存在或无效签名"
     *     )
     * )
     */
    public function authenticatorAction() {
        $parameters = Registry::get('parameters');

        User::googleAuthenticator($parameters['code'], Session::getInstance()->get('google_secret'));

        return $this->_responseJson(['verification' => true], '000', '验证成功');
    }

    /**
     * @SWG\Get(
     *     path="/admin/user/{id}/info",
     *     tags={"登录登出"},
     *     summary="获取当前登陆账号都有哪些权限模块分组",
     *     description="",
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="Authorization 登录接口返回的jwt字段的值",
     *          in="header",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="id",
     *          description="登陆接口返回的id字段的值",
     *          in="path",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="请求成功"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="签名不存在或无效签名"
     *     )
     * )
     */
    public function infoAction() {
        $roles = User::info();

        return $this->_responseJson([
            'roles' => $roles,
            'username' => Session::getInstance()->get('username')
        ]);
    }

    /**
     * @SWG\Post(
     *     path="/admin/user/logout",
     *     tags={"登录登出"},
     *     summary="后台账号退出登录接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="Authorization 登录接口返回的jwt字段的值",
     *          in="header",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="请求成功",
     *         @SWG\Schema(type="object", ref="#/definitions/userSingleData")
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="签名不存在或无效签名"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="签名不存在或无效签名"
     *     )
     * )
     */
    public function logoutAction() {
        // 删除session
        Session::getInstance()->del('access_list');
        Session::getInstance()->del('admin_id');
        Session::getInstance()->del('role_id');

        return $this->_responseJson(new stdClass(), '000', '退出成功');
    }

    /**
     * @SWG\Get(
     *     path="/admin/user/list",
     *     tags={"后台账号模块"},
     *     summary="后台账号列表接口",
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
     *          name="username",
     *          description="后台账号登录名 模糊查询",
     *          in="query",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="role",
     *          description="角色编号 admin/role/list接口返回的id",
     *          in="query",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="stats",
     *          description="账号状态 可选值: 0封禁|1允许登录",
     *          in="query",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="created_start_time",
     *          description="后台账号创建时间",
     *          in="query",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="created_end_time",
     *          description="后台账号创建时间",
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
     *         @SWG\Schema(type="object", ref="#/definitions/userListData")
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
        $user_list = User::getUserList(Registry::get('parameters'));

        return $this->_responseJson($user_list);
    }

    /**
     * @SWG\Post(
     *     path="/admin/user/create",
     *     tags={"后台账号模块"},
     *     summary="创建后台账号接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="Authorization",
     *          description="Authorization 登录接口返回的jwt字段的值",
     *          in="header",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="username",
     *          description="后台账号登录名",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="password",
     *          description="登录密码",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="role",
     *          description="角色编号 admin/role/list接口返回的id",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="stats",
     *          description="账号状态 可选值: 0封禁|1允许登录",
     *          in="formData",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="mobile",
     *          description="手机号码 用来找回密码用的",
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
     *         @SWG\Schema(type="object", ref="#/definitions/userSingleData")
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

        $create_res = User::createUser($parameters);

        return $this->_responseJson(['data' => $create_res]);
    }

    /**
     * @SWG\Put(
     *     path="/admin/user/{id}/edit",
     *     tags={"后台账号模块"},
     *     summary="编辑后台账号接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="id",
     *          description="/admin/user/list接口返回的id字段的值",
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
     *          name="password",
     *          description="登录密码",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="role",
     *          description="角色编号 admin/role/list接口返回的id",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="stats",
     *          description="账号状态 可选值: 0封禁|1允许登录",
     *          in="formData",
     *          required=false,
     *          type="string"
     *     ),
     *     @SWG\Parameter(
     *          name="mobile",
     *          description="手机号码 用来找回密码用的",
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
     *         @SWG\Schema(type="object", ref="#/definitions/userSingleData")
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

        $update_res = User::updateUser($parameters);

        return $this->_responseJson(['data' => $update_res]);
    }

    /**
     * @SWG\Delete(
     *     path="/admin/user/{id}/delete",
     *     tags={"后台账号模块"},
     *     summary="删除后台账号接口",
     *     description="",
     *     @SWG\Parameter(
     *          name="id",
     *          description="/admin/user/list接口返回的id字段的值",
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
     *         description="用户已经不存在了"
     *     )
     * )
     */
    public function deleteAction() {
        User::deleteUser(Registry::get('parameters')['id']);
        return $this->_responseJson(new stdClass(), '000', '删除成功');
    }

    public function genGoogleAuthAction() {
        $parameters = Registry::get('parameters');

        list($google_secret, $qr_code_url) = User::genGoogleAuthenticator($parameters);

        return $this->_responseJson(['google_secret' => $google_secret, 'qr_code_url' => $qr_code_url], '000', '生成成功');
    }

}
