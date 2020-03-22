<?php

namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class RoleErrMsg extends AbstractErrorMsg
{
    const ROLE_ID_IS_EMPTY = '角色编号不能为空';
    const ROLE_ID_IS_EMPTY_NO = '400';

    const ROLE_IS_EMPTY = '角色不存在';
    const ROLE_IS_EMPTY_NO = '404';

    const ROLE_CREATE_FAILURE = '角色创建失败';
    const ROLE_CREATE_FAILURE_NO = '422';

    const ROLE_EDIT_ID_IS_EMPTY = '角色编号不存在';
    const ROLE_EDIT_ID_IS_EMPTY_NO = '422';

    const ROLE_EDIT_FAILURE = '用户编辑失败';
    const ROLE_EDIT_FAILURE_NO = '422';

    const ROLE_IS_DELETED = '已被删除了';
    const ROLE_IS_DELETED_NO = '404';

}