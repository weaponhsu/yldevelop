<?php


namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class StoreErrMsg extends AbstractErrorMsg
{
    const STORE_NOT_EXISTS = "店铺不存在";
    const STORE_NOT_EXISTS_NO = "404";

    const STORE_CREATE_FAILURE = "店铺创建失败";
    const STORE_CREATE_FAILURE_NO = "422";

    const STORE_EDIT_FAILURE = "店铺编辑失败";
    const STORE_EDIT_FAILURE_NO = "422";

    const STORE_ID_EMPTY = "店铺id不能为空";
    const STORE_ID_EMPTY_NO = "400";

}
