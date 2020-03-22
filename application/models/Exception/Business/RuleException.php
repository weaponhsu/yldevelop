<?php


namespace models\Exception\Business;


use Exception;

class RuleException extends Exception
{
    const RULE_IS_EMPTY = '权限不存在';
    const RULE_IS_EMPTY_NO = '404';

    const USER_LOGIN_FIRST = '请先登录';
    const USER_LOGIN_FIRST_NO = '401';

    const PERMISSION_DENIED = '无权访问';
    const PERMISSION_DENIED_NO = '403';

    const RULE_CREATE_FAILURE = "权限创建失败";
    const RULE_CREATE_FAILURE_NO = "422";

    const RULE_ID_NOT_EXISTS = "权限编号不存在";
    const RULE_ID_NOT_EXISTS_NO = "400";

    const RULE_EDIT_FAILURE = "权限创建失败";
    const RULE_EDIT_FAILURE_NO = "422";

    const RULE_NOT_EXISTS = "权限不存在";
    const RULE_NOT_EXISTS_NO = "404";

    const RULE_BATCH_INSERT_MENU_FAILURE = "权限绑定菜单失败";
    const RULE_BATCH_INSERT_MENU_FAILURE_NO = "422";
}
