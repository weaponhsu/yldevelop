<?php


namespace models\Exception\Cache;

use Exception;


class CacheException extends Exception
{
    // 2开头的错误编号为redis的错误提示信息
    const REDIS_HASH_KEY_IS_INVALID = '%s不是一个有效的redis hash的key，请是否字符串作为redis hash的key';
    const REDIS_HASH_KEY_IS_INVALID_NO = '200001';
    const REDIS_HASH_KEY_LEN_INVALID = '%s的长度超过%d个字符，不能作为redis hash的key';
    const REDIS_HASH_KEY_LEN_INVALID_NO = '200002';
    const REDIS_HASH_VALUE_MUST_BE_ARRAY = 'redis hash的值必须是一个不为空的数组';
    const REDIS_HASH_VALUE_MUST_BY_ARRAY_NO = '200003';
    const REDIS_HASH_GET_FIELD_NOT_EXISTS = '%s的field不存在，无法获取redis hash';
    const REDIS_HASH_GET_FIELD_NOT_EXISTS_NO = '200004';

    const REDIS_STRING_KEY_IS_INVALID = '%s不是一个有效的redis string的key，请是否字符串作为redis string的key';
    const REDIS_STRING_KEY_IS_INVALID_NO = '200005';
    const REDIS_STRING_VALUE_IS_INVALID = 'redis string的值必须是一个字符串';
    const REDIS_STRING_VALUE_IS_INVALID_NO = '200006';

    const REDIS_KEY_GENERATE_FAILURE = 'redis的key生成失败';
    const REDIS_KEY_GENERATE_FAILURE_NO = '200007';
    const REDIS_KEY_IS_NOT_EMPTY = '缓存名不能为空。';
    const REDIS_KEY_IS_NOT_EMPTY_NO = '200008';
    const REDIS_KEY_IS_INVALID = '无效redis key。';
    const REDIS_KEY_IS_INVALID_NO = '200010';
    const REDIS_KEY_VALUE_BOTH_NO_ARRAY = 'key与value都必须为数组.';
    const REDIS_KEY_VALUE_BOTH_NO_ARRAY_NO = '200011';

    const REDIS_KEY_DELETE_FAILURE = '删除redis key失败';
    const REDIS_KEY_DELETE_FAILURE_NO = '200009';
}
