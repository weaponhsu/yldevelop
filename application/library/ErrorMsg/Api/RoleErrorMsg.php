<?php

namespace ErrorMsg\Api;

use ErrorMsg\AbstractErrorMsg;


class RoleErrorMsg extends AbstractErrorMsg{
    const ROLE_BATCH_UPDATE_EMPTY_CONDITION = 'update_column或id不能为空';

    const ROLE_BATCH_UPDATE_EMPTY_CONDITION_NO = '6280003';

    const ROLE_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE = 'update_column必须与id为同一数据类型';

    const ROLE_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE_NO = '6280004';

    const ROLE_BATCH_UPDATE_RETURN_FALSE = '批量update语句生成失败';

    const ROLE_BATCH_UPDATE_RETURN_FALSE_NO = '6280005';

    const ROLE_BATCH_DELETE_RETURN_FALSE = '批量delete时参数类型不合法';

    const ROLE_BATCH_DELETE_RETURN_FALSE_NO = '6280006';

    const ROLE_BATCH_INSERT_RETURN_FALSE = '批量insert时参数类型不合法';

    const ROLE_BATCH_INSERT_RETURN_FALSE_NO = '6280007';

    const ROLE_UPDATE_ID_EMPTY = '修改数据时primary_key不能为空';

    const ROLE_UPDATE_ID_EMPTY_NO = '6280008';

    const ROLE_UPDATE_COLUMN_UPDATE_ARR_INVALID = '修改数据时column_arr不合法';

    const ROLE_UPDATE_COLUMN_UPDATE_ARR_INVALID_NO = '6280009';

    const ROLE_DELETE_ID_EMPTY = '删除数据时primary_key不能为空';

    const ROLE_DELETE_ID_EMPTY_NO = '6280010';

}