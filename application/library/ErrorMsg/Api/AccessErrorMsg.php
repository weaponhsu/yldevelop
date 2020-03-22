<?php

namespace ErrorMsg\Api;

use ErrorMsg\AbstractErrorMsg;


class AccessErrorMsg extends AbstractErrorMsg{
    const ACCESS_BATCH_UPDATE_EMPTY_CONDITION = 'update_column或id不能为空';

    const ACCESS_BATCH_UPDATE_EMPTY_CONDITION_NO = '600003';

    const ACCESS_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE = 'update_column必须与id为同一数据类型';

    const ACCESS_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE_NO = '600004';

    const ACCESS_BATCH_UPDATE_RETURN_FALSE = '批量update语句生成失败';

    const ACCESS_BATCH_UPDATE_RETURN_FALSE_NO = '600005';

    const ACCESS_BATCH_DELETE_RETURN_FALSE = '批量delete时参数类型不合法';

    const ACCESS_BATCH_DELETE_RETURN_FALSE_NO = '600006';

    const ACCESS_BATCH_INSERT_RETURN_FALSE = '批量insert时参数类型不合法';

    const ACCESS_BATCH_INSERT_RETURN_FALSE_NO = '600007';

    const ACCESS_UPDATE_ID_EMPTY = '修改数据时primary_key不能为空';

    const ACCESS_UPDATE_ID_EMPTY_NO = '600008';

    const ACCESS_UPDATE_COLUMN_UPDATE_ARR_INVALID = '修改数据时column_arr不合法';

    const ACCESS_UPDATE_COLUMN_UPDATE_ARR_INVALID_NO = '600009';

    const ACCESS_DELETE_ID_EMPTY = '删除数据时primary_key不能为空';

    const ACCESS_DELETE_ID_EMPTY_NO = '600010';

}