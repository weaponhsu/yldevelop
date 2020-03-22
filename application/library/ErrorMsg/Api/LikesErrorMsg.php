<?php

namespace ErrorMsg\Api;

use ErrorMsg\AbstractErrorMsg;


class LikesErrorMsg extends AbstractErrorMsg{
    const LIKES_BATCH_UPDATE_EMPTY_CONDITION = 'update_column或id不能为空';

    const LIKES_BATCH_UPDATE_EMPTY_CONDITION_NO = '60003';

    const LIKES_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE = 'update_column必须与id为同一数据类型';

    const LIKES_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE_NO = '60004';

    const LIKES_BATCH_UPDATE_RETURN_FALSE = '批量update语句生成失败';

    const LIKES_BATCH_UPDATE_RETURN_FALSE_NO = '60005';

    const LIKES_BATCH_DELETE_RETURN_FALSE = '批量delete时参数类型不合法';

    const LIKES_BATCH_DELETE_RETURN_FALSE_NO = '60006';

    const LIKES_BATCH_INSERT_RETURN_FALSE = '批量insert时参数类型不合法';

    const LIKES_BATCH_INSERT_RETURN_FALSE_NO = '60007';

    const LIKES_UPDATE_ID_EMPTY = '修改数据时primary_key不能为空';

    const LIKES_UPDATE_ID_EMPTY_NO = '60008';

    const LIKES_UPDATE_COLUMN_UPDATE_ARR_INVALID = '修改数据时column_arr不合法';

    const LIKES_UPDATE_COLUMN_UPDATE_ARR_INVALID_NO = '60009';

    const LIKES_DELETE_ID_EMPTY = '删除数据时primary_key不能为空';

    const LIKES_DELETE_ID_EMPTY_NO = '60010';

}