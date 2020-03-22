<?php

namespace ErrorMsg\Api;

use ErrorMsg\AbstractErrorMsg;


class MenuErrorMsg extends AbstractErrorMsg{
    const MENU_BATCH_UPDATE_EMPTY_CONDITION = 'update_column或id不能为空';

    const MENU_BATCH_UPDATE_EMPTY_CONDITION_NO = '6190003';

    const MENU_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE = 'update_column必须与id为同一数据类型';

    const MENU_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE_NO = '6190004';

    const MENU_BATCH_UPDATE_RETURN_FALSE = '批量update语句生成失败';

    const MENU_BATCH_UPDATE_RETURN_FALSE_NO = '6190005';

    const MENU_BATCH_DELETE_RETURN_FALSE = '批量delete时参数类型不合法';

    const MENU_BATCH_DELETE_RETURN_FALSE_NO = '6190006';

    const MENU_BATCH_INSERT_RETURN_FALSE = '批量insert时参数类型不合法';

    const MENU_BATCH_INSERT_RETURN_FALSE_NO = '6190007';

    const MENU_UPDATE_ID_EMPTY = '修改数据时primary_key不能为空';

    const MENU_UPDATE_ID_EMPTY_NO = '6190008';

    const MENU_UPDATE_COLUMN_UPDATE_ARR_INVALID = '修改数据时column_arr不合法';

    const MENU_UPDATE_COLUMN_UPDATE_ARR_INVALID_NO = '6190009';

    const MENU_DELETE_ID_EMPTY = '删除数据时primary_key不能为空';

    const MENU_DELETE_ID_EMPTY_NO = '6190010';

}