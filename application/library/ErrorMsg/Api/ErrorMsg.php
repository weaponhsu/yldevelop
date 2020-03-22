<?php

namespace ErrorMsg\Api;

use ErrorMsg\AbstractErrorMsg;

class ErrorMsg extends AbstractErrorMsg
{
    const SIGN_IS_EMPTY = '签名不存在';
    const SIGN_IS_INVALID = '无效签名';
    const SIGN_VERIFY_FAILURE = '解密失败';
    const INVALID_PEM = "无效证书";
    const INVALID_IP = "无效IP";
    const SIGN_INVALID_NO = '400';

    const REQUIRED_PARAMETER_IS_MISSING = '缺少必须参数';
    const PARAMETER_IS_INVALID = '包含非法参数';
    const REQUIRED_IS_INVALID_NO = '400';

    const METHOD_IS_NOT_INVALID = '方法已过期';
    const METHOD_IS_NOT_INVALID_NO = '600003';

    const TRAIT_FOREIGN_RELATIONSHIP_INVALID = '关系表异常';
    const TRAIT_FOREIGN_RELATIONSHIP_INVALID_NO = '600006';

    const LOGIN_FIRST = '请先登录';
    const LOGIN_FIRST_NO = '999';

    const SECRET_IS_NULL = '验签失败';
    const INVALID_METHOD_NAME = '控制器不存在';
    const INVALID_ACTION_NAME = '接口不存在';
    const INVALID_PARAMETER = '%s参数不合法';
    const API_PARAMETERS_DOES_NOT_CONFIGURATION = '接口不允许访问';

    const ACCESS_KEY_IS_NULL = 'access_key不能为空';
    const DATA_IS_NULL = '加密参数必须为数组';
    const DATA_IS_NOT_NULL = '加密参数为空';
    const SIGN_IS_NOT_NULL = '解密参数不能为空';
    const VERIFICATION_ERROR = '解密失败';

    const SERVICE_IS_NOT_INSTANTIATION = '服务不存在';

    const MOBILE_LENGTH_INVALID = '请输入正确手机号码';
    const MOBILE_LENGTH_INVALID_NO = '500002';
    const MOBILE_INVALID = '请输入正确的手机号码';
    const MOBILE_INVALID_NO = '500002';

    const EMAIL_INVALID = '请输入正确邮箱地址';
    const EMAIL_INVALID_NO = '500004';
    const EMAIL_ADDRESS_INVALID = '请输入正确的邮箱地址';
    const EMAIL_ADDRESS_INVALID_NO = '500004';

    const IDENTIFICATION_NUM_LENGTH_INVALID = '请输入18号身份证号码';
    const IDENTIFICATION_NUM_LENGTH_INVALID_NO = '500005';
    const IDENTIFICATION_NUM_FORMATTER_INVALID = '请输入有效的身份证号';
    const IDENTIFICATION_NUM_FORMATTER_INVALID_NO = '500005';
    const IDENTIFICATION_NUM_FORMATTER_INVALID_1 = '请输入有效的身份证号';
    const IDENTIFICATION_NUM_FORMATTER_INVALID_1_NO = '500005';
    const IDENTIFICATION_NUM_INVALID = '请输入有效的身份证好吗';
    const IDENTIFICATION_NUM_INVALID_NO = '500005';
}
