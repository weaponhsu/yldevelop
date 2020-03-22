<?php

namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class MenuErrMsg extends AbstractErrorMsg
{
    const MENU_IS_NOT_EXISTS = '菜单不存在';
    const MENU_IS_NOT_EXISTS_NO = '404';

    const GEN_MENU_ARR_INVALID_PARAMETERS = '菜单数组为空';
    const GEN_MENU_ARR_INVALID_PARAMETERS_NO = '400';

    const ACCESS_IS_NOT_EXISTS = '权限不存在';
    const ACCESS_IS_NOT_EXISTS_NO = '404';

    const ACCESS_INSERT_FAILURE = '权限插入失败';
    const ACCESS_INSERT_FAILURE_NO = '422';

    const ACCESS_IS_DELETED = '已被删除了';
    const ACCESS_IS_DELETED_NO = '410';
}