<?php


namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class OrdersErrMsg extends AbstractErrorMsg
{
    const ORDER_CREATE_FAILURE = "订单创建失败";
    const ORDER_CREATE_FAILURE_NO = "422";

    const ORDER_NOT_EXISTS = "订单不存在";
    const ORDER_NOT_EXISTS_NO = "404";

    const ORDER_EDIT_FAILURE = "订单创建失败";
    const ORDER_EDIT_FAILURE_NO = "422";

    const ORDER_SN_NOT_EXISTS = "订单sn不存在";
    const ORDER_SN_NOT_EXISTS_NO = "400";

}
