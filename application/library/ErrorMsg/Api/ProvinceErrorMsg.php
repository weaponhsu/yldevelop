<?php

namespace ErrorMsg\Api;

use ErrorMsg\AbstractErrorMsg;


class ProvinceErrorMsg extends AbstractErrorMsg{
    const PROVINCE_BATCH_UPDATE_EMPTY_CONDITION = 'update_column或id不能为空';

    const PROVINCE_BATCH_UPDATE_EMPTY_CONDITION_NO = '6250003';

    const PROVINCE_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE = 'update_column必须与id为同一数据类型';

    const PROVINCE_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE_NO = '6250004';

    const PROVINCE_BATCH_UPDATE_RETURN_FALSE = '批量update语句生成失败';

    const PROVINCE_BATCH_UPDATE_RETURN_FALSE_NO = '6250005';

    const PROVINCE_BATCH_DELETE_RETURN_FALSE = '批量delete时参数类型不合法';

    const PROVINCE_BATCH_DELETE_RETURN_FALSE_NO = '6250006';

    const PROVINCE_BATCH_INSERT_RETURN_FALSE = '批量insert时参数类型不合法';

    const PROVINCE_BATCH_INSERT_RETURN_FALSE_NO = '6250007';

    const PROVINCE_UPDATE_ID_EMPTY = '修改数据时primary_key不能为空';

    const PROVINCE_UPDATE_ID_EMPTY_NO = '6250008';

    const PROVINCE_UPDATE_COLUMN_UPDATE_ARR_INVALID = '修改数据时column_arr不合法';

    const PROVINCE_UPDATE_COLUMN_UPDATE_ARR_INVALID_NO = '6250009';

    const PROVINCE_DELETE_ID_EMPTY = '删除数据时primary_key不能为空';

    const PROVINCE_DELETE_ID_EMPTY_NO = '6250010';

}