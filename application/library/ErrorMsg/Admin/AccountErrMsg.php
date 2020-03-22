<?php


namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class AccountErrMsg extends AbstractErrorMsg
{
    const BATCH_IMPORT_INVALID_PARAMETER = "无效导入参数";
    const BATCH_IMPORT_INVALID_PARAMETER_NO = "400";

    const ACCOUNT_NOT_EXISTS = "账号不存在";
    const ACCOUNT_NOT_EXISTS_NO = "404";

    const GET_ONE_ACCOUNT_INVALID_PARAMETER = "无效查询参数";
    const GET_ONE_ACCOUNT_INVALID_PARAMETER_NO = "400";

    const ACCOUNT_EDIT_FAILURE = "账号编辑失败";
    const ACCOUNT_EDIT_FAILURE_NO = "422";

    const ACCOUNT_ID_EMPTY = "账号编号不能为空";
    const ACCOUNT_ID_EMPTY_NO = "400";

    const BATCH_MODIFY_STATS_INVALID_PARAMETER = "无效状态参数";
    const BATCH_MODIFY_STATS_INVALID_PARAMETER_NO = "400";

}
