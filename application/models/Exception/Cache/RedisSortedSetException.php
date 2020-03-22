<?php


namespace models\Exception\Cache;


class RedisSortedSetException extends CacheException
{
    const REDIS_SORTED_SET_INVALID_VALUE = "sorted set的值必须为数组";
    const REDIS_SORTED_SET_INVALID_VALUE_NO = "210012";

    const INVALID_ORDER_PARAM = "无效排序参数";
    const INVALID_ORDER_PARAM_NO = "210013";

    const REDIS_SORTED_SET_NOT_EXISTS = "%key%不存在";
    const REDIS_SORTED_SET_NOT_EXISTS_NO = "210014";

    const REDIS_MEMBER_IS_EMPTY = "member不能为空";
    const REDIS_MEMBER_IS_EMPTY_NO = "210015";
}
