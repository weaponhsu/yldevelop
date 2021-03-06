<?php

namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class AdminErrMsg extends AbstractErrorMsg
{
    const USERNAME_OR_PASSWORD_IS_EMPTY = '用户名密码不能为空';
    const USERNAME_OR_PASSWORD_IS_EMPTY_NO = '401';

    const USER_IS_NOT_EXISTS = '用户不存在';
    const USER_IS_NOT_EXISTS_NO = '404';

    const USER_INVALID_PASSWORD = '密码错误';
    const USER_INVALID_PASSWORD_NO = '401';

    const USER_DATA_UPDATE_FAILURE = '用户数据修改失败';
    const USER_DATA_UPDATE_FAILURE_NO = '400';

    const USER_CREATE_FAILURE = '用户创建失败';
    const USER_CREATE_FAILURE_NO = '422';

    const USER_EDIT_ID_IS_EMPTY = '用户编号不存在';
    const USER_EDIT_ID_IS_EMPTY_NO = '422';

    const USER_EDIT_FAILURE = '用户编辑失败';
    const USER_EDIT_FAILURE_NO = '422';

    const USER_ID_IS_EMPTY = '用户编号不能为空';
    const USER_ID_IS_EMPTY_NO = '400';

    const USER_IS_DELETED = '已被删除了';
    const USER_IS_DELETED_NO = '404';

    const USER_INVALID_PARAMETERS = '无效查询条件';
    const USER_INVALID_PARAMETERS_NO = '400';

    const USER_INVALID_GOOGLE_AUTHENTICATOR = '无效谷歌验证码';
    const USER_INVALID_GOOGLE_AUTHENTICATOR_NO = '400';

    const INVALID_GOOGLE_AUTHENTICATOR = "谷歌验证失败";
    const INVALID_GOOGLE_AUTHENTICATOR_NO = "400";

    const USER_INVALID_ACTION = "无效操作";
    const USER_INVALID_ACTION_NO = "400";

}
