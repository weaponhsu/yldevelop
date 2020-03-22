<?php


namespace models\Exception\Service;

use models\Exception\Cache\CacheException;


class ServiceException extends \Exception
{
    const SERVICE_GET_LIST_WITH_REDIS_IDX_NOT_EXISTS = "缓存数据键值对不存在";
    const SERVICE_GET_LIST_WITH_REDIS_IDX_NOT_EXISTS_NO = "300001";

    const SERVICE_CACHE_NAME_IS_EMPTY = "缓存名不能为空";
    const SERVICE_CACHE_NAME_IS_EMPTY_NO = "300002";

    const SERVICE_UPDATE_ID_EMPTY = "修改数据时，主键不能为空";
    const SERVICE_UPDATE_ID_EMPTY_NO = "300003";

    const SERVICE_UPDATE_INVALID_COLUMN_ARR = "要修改的数据必须为数组";
    const SERVICE_UPDATE_INVALID_COLUMN_ARR_NO = "300004";

    const SERVICE_DELETE_ID_EMPTY = "删除数据时，主键不能为空";
    const SERVICE_DELETE_ID_EMPTY_NO = "300005";

    const SERVICE_BATCH_INSERT_RETURN_FALSE = '批量insert时参数类型不合法';
    const SERVICE_BATCH_INSERT_RETURN_FALSE_NO = '300006';

    const SERVICE_BATCH_UPDATE_DATA_EMPTY = "批量修改的数据不合法或不能为空";
    const SERVICE_BATCH_UPDATE_DATA_EMPTY_NO = "300007";

    const SERVICE_BATCH_DELETE_DATA_EMPTY = '批量delete时参数类型不合法';
    const SERVICE_BATCH_DELETE_DATA_EMPTY_NO = '60006';

}
