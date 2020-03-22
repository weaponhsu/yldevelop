<?php


namespace models\Exception\DAO;

use Exception;


class ModelSqlException extends Exception
{
    // 1开头的错误编号为数据库的错误提示信息
    const BASE_MODEL_EMPTY_SQL = 'sql不能为空';
    const BASE_MODEL_EMPTY_SQL_NO = '100001';

    const BASE_MODEL_EMPTY_TABLE_NAME = '表名不能为空';
    const BASE_MODEL_EMPTY_TABLE_NAME_NO = '100003';

    const BASE_MODEL_BATCH_UPDATE_INVALID = '批量update时，字段数量不想等';
    const BASE_MODEL_BATCH_UPDATE_INVALID_NO = '100004';
}
