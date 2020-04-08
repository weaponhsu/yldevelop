<?php


namespace models\Exception\DAO;

use Exception;

class ModelException extends Exception
{
    const INSTANCE_NOT_ALLOW_TO_CLONE = '%s禁止clone';
    const INSTANCE_NOT_ALLOW_TO_CLONE_NO = '110001';

    const DATA_NOT_EXISTS = "%class_name%报错，数据不存在";
    const DATA_NOT_EXISTS_NO = "110002";

    const THERE_IS_NO_GET_METHOD = "不存在__get方法";
    const THERE_IS_NO_GET_METHOD_NO = '130002';

    const THERE_IS_NOT_DATA_VAR = "不存在data属性";
    const THERE_IS_NOT_DATA_VAR_NO = "130003";

    const THERE_IS_NOT_META_VAR = "不存在meta属性";
    const THERE_IS_NOT_META_VAR_NO = "130004";

    const THERE_IS_NO_PAGE_VAR = "不存在page属性";
    const THERE_IS_NO_PAGE_VAR_NO = "130005";

    const THERE_IS_NO_PAGE_SIZE_VAR = "不存在perPage属性";
    const THERE_IS_NO_PAGE_SIZE_VAR_NO = "130006";

    const THERE_IS_NO_PRIMARY_KEY_ARR_VAR = "不存在primary_key_arr属性";
    const THERE_IS_NO_PRIMARY_KEY_ARR_VAR_NO = "130007";

    const THERE_IS_NO_SET_METHOD = "不存在__set方法";
    const THERE_IS_NO_SET_METHOD_NO = '130008';

    const THERE_IS_NO_PRIMARY_KEY_ARR = "不存在primary_key_arr属性";
    const THERE_IS_NO_PRIMARY_KEY_ARR_NO = '130009';

    const THERE_IS_NO_PROPERTY = "不存在%property%属性";
    const THERE_IS_NO_PROPERTY_NO = "130010";

    const INVALID_DATA_VAR = "data不为数组或为空";
    const INVALID_DATA_VAR_NO = "130011";

    const INVALID_BATCH_UPDATE_PRIMARY_KEY_ARR = "批量更新时出现无效primary_key";
    const INVALID_BATCH_UPDATE_PRIMARY_KEY_ARR_NO = "130012";

    const INVALID_BUILDER = "无效builder类型";
    const INVALID_BUILDER_NO = 400;

    const INVALID_BUILDER_CLASS = "builder必须是Eloquent\Model或Eloquent\Builder";
    const INVALID_BUILDER_CLASS_NO = 400;
}
