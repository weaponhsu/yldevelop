<?php
/**
 *
 *            ┏┓　　  ┏┓+ +
 *           ┏┛┻━━━━━┛┻┓ + +
 *           ┃         ┃ 　
 *           ┃   ━     ┃ ++ + + +
 *          ████━████  ┃+
 *           ┃　　　　　 ┃ +
 *           ┃　　　┻　　┃
 *           ┃　　　　　 ┃ + +
 *           ┗━┓　　　┏━┛
 *             ┃　　　┃　　　　
 *             ┃　　　┃ + + + +
 *             ┃　　　┃    Code is far away from bug with the alpaca protecting
 *             ┃　　　┃ + 　　　　        神兽保佑,代码无bug
 *             ┃　　　┃
 *             ┃　　　┃　　+
 *             ┃     ┗━━━┓ + +
 *             ┃         ┣┓
 *             ┃ 　　　　　┏┛
 *             ┗┓┓┏━━┳┓┏━┛ + + + +
 *              ┃┫┫  ┃┫┫
 *              ┗┻┛  ┗┻┛+ + + +
 * Created by PhpStorm.
 * User: weaponhsu
 * Date: 2017/4/12
 * Time: 上午9:54
 */

namespace ErrorMsg;


use Yaf\Registry;

class AbstractErrorMsg
{
    // 1开头的错误编号为数据库的错误提示信息
    const BASE_MODEL_EMPTY_SQL = 'sql不能为空';
    const BASE_MODEL_EMPTY_SQL_NO = '100001';

    const BASE_MODEL_EMPTY_RESULT = '查无结果';
    const BASE_MODEL_EMPTY_RESULT_NO = '100002';

    const BASE_MODEL_EMPTY_TABLE_NAME = '表名不能为空';
    const BASE_MODEL_EMPTY_TABLE_NAME_NO = '100003';

    const INSTANCE_NOT_ALLOW_TO_CLONE = '%s禁止clone';
    const INSTANCE_NOT_ALLOW_TO_CLONE_NO = '100004';

    const TRAIT_FOREIGN_RELATIONSHIP_IS_ABNORMAL = '外键关系异常';
    const TRAIT_FOREIGN_RELATIONSHIP_IS_ABNORMAL_NO = '100005';

    const VERIFICATION_IS_EMPTY = '验证码不能为空';
    const VERIFICATION_IS_EMPTY_NO = '100006';

    const FORM_VALIDATOR_INVALID_MOBILE = '%s不是一个有效的手机号码';
    const FORM_VALIDATOR_INVALID_STRING_LENGTH = '%s长度必须在%min与%max之间';
    const FORM_VALIDATOR_INVALID_PASSWORD = '%s不是一个有效的密码(密码必须至少包含大小写字母与数字)';
    const FORM_VALIDATOR_INVALID_PASSWORD_NOT_EQUAL_REPEAT_PASSWORD = '两边密码不一致';
    const FORM_VALIDATOR_INVALID_PASSWORD_IS_EMPTY = '密码不能为空';
    const FORM_VALIDATOR_UNIQUE_IS_EXISTS = '%s必须唯一，当前输入值已经存在，请重试';

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
    const REDIS_KEY_IS_NOT_EMPTY = '缓存名不能为空';
    const REDIS_KEY_IS_NOT_EMPTY_NO = '200008';

    const REDIS_KEY_DELETE_FAILURE = '删除redis key失败';
    const REDIS_KEY_DELETE_FAILURE_NO = '200009';

    /*const FORM_VALIDATOR_INVALID_TYPE = '%s是无效类型';
    const FORM_VALIDATOR_INVALID_TYPE_STRING = '%s不是一个有效的字符串';
    const FORM_VALIDATOR_INVALID_TYPE_INTEGER = '%s不是一个有效的数字';
    const FORM_VALIDATOR_INVALID_TYPE_FLOAT = '%s不是一个有效的小数';
    const FORM_VALIDATOR_INVALID_TYPE_ARRAY= '%s不是一个有效的数组';*/

    const UNKNOWN_ERROR = '未知错误';
    const UNKNOWN_ERROR_NO = '111111';

    const UPLOAD_NO_FILE = '请选择文件';
    const UPLOAD_INVALID_FILE_TYPE = '%s是非法上传类型';
    const UPLOAD_INVALID_FILE_MAX_SIZE = '%s超过限定文件大小%max_size';
    const UPLOAD_INVALID_FILE_MAX_WIDTH = '%s超过限定文件宽度%w';
    const UPLOAD_INVALID_FILE_MAX_HEIGHT = '%s超过限定文件高度%h';
    const UPLOAD_INVALID_DESTINATION_DIR = '%s目录不存在';
    const UPLOAD_FILE_MOVE_FAILED = '%s文件移动失败';
    const UPLOAD_FILE_CONVERT_2_WEBP_FALIURE = '%s文件转webp格式失败';
    const UPLOAD_SUCCESS = '%s文件上传成功';
    const UPLOAD_SUCCESS_DESCRIPTION = '%s文件上传成功，请点击按钮返回上个页面';
    const UPLOAD_MAKE_DIR_FAILED = '%s保存路径创建失败';
}