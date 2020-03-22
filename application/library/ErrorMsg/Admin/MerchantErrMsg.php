<?php


namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class MerchantErrMsg extends AbstractErrorMsg
{
    const MERCHANT_NOT_EXISTS = "商户不存在";
    const MERCHANT_NOT_EXISTS_NO = "404";

    const MERCHANT_CREATE_FAILURE = "商户创建失败";
    const MERCHANT_CREATE_FAILURE_NO = "422";

    const MERCHANT_IS_EXISTS = "商户号或商户id已经存在,请勿重复";
    const MERCHANT_IS_EXISTS_NO = "400";

    const MERCHANT_ID_EMPTY = "编号不能为空";
    const MERCHANT_ID_EMPTY_NO = "400";

    const MERCHANT_EDIT_FAILURE = "商户编辑失败";
    const MERCHANT_EDIT_FAILURE_NO = "422";

    const MERCHANT_NO_NOT_EXISTS = "商户号不存在";
    const MERCHANT_NO_NOT_EXISTS_NO = "400";

    const MERCHANT_INVALID_STATS = "非法商户状态";
    const MERCHANT_INVALID_STATS_NO = "400";

    const ROUTER_CREATE_FAILURE = "商户路由创建失败";
    const ROUTER_CREATE_FAILURE_NO = "400";

    const INVALID_MERCHANT_FIRST = "请先禁用商户";
    const INVALID_MERCHANT_FIRST_NO = "400";

    const USERNAME_OR_PASSWORD_IS_EMPTY = "商户号或密码不能为空";
    const USERNAME_OR_PASSWORD_IS_EMPTY_NO = "400";

    const USER_INVALID_PASSWORD = "密码错误";
    const USER_INVALID_PASSWORD_NO = "400";

    const MERCHANT_PUBLIC_PEM_NOT_EXISTS = "商户证书不存在";
    const MERCHANT_PUBLIC_PEM_NOT_EXISTS_NO = "404";

    const INVALID_MERCHANT_STATS = "商户处于禁用状态";
    const INVALID_MERCHANT_STATS_NO = "403";
}
