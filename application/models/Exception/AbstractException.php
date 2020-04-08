<?php


namespace models\Exception;


use Yaf\Exception;

class AbstractException extends Exception
{
    const SIGN_VERIFY_FAILURE = '解密失败';
    const INVALID_PEM = "无效证书";
    const INVALID_IP = "无效IP";
    const SIGN_INVALID_NO = '400';

    const REQUIRED_PARAMETER_IS_MISSING = '缺少必须参数';
    const PARAMETER_IS_INVALID = '包含非法参数';
    const REQUIRED_IS_INVALID_NO = '400';

    const LOGIN_FIRST = '请先登录';
    const LOGIN_FIRST_NO = '401';

    const SECRET_IS_NULL = '验签失败';
    const INVALID_METHOD_NAME = '控制器不存在';
    const INVALID_ACTION_NAME = '接口不存在';
    const INVALID_PARAMETER = '%s参数不合法';
    const API_PARAMETERS_DOES_NOT_CONFIGURATION = '接口不允许访问';

    const PERMISSION_DENIED = '无权访问';
    const PERMISSION_DENIED_NO = '403';

    const UPLOAD_MAKE_DIR_FAILED = '%s保存路径创建失败';

}
