<?php

namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class AccessErrMsg extends AbstractErrorMsg
{
    const ACCESS_IS_EMPTY = '权限不存在';
    const ACCESS_IS_EMPTY_NO = '404';

    const USER_LOGIN_FIRST = '请先登录';
    const USER_LOGIN_FIRST_NO = '401';

    const PERMISSION_DENIED = '无权访问';
    const PERMISSION_DENIED_NO = '403';

}