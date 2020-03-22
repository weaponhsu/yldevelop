<?php


namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class GoodsErrMsg extends AbstractErrorMsg
{
    const GOODS_IMPORT_INVALID_PARAMETER = "无效导入数据参数";
    const GOODS_IMPORT_INVALID_PARAMETER_NO = "400";

    const GOODS_ID_EMPTY = "商品编号不能为空";
    const GOODS_ID_EMPTY_NO = "400";

    const GOODS_EDIT_FAILURE = "商品编辑失败";
    const GOODS_EDIT_FAILURE_NO = "422";

    const THERE_IS_NO_CONDITION = "没有查询条件";
    const THERE_IS_NO_CONDITION_NO = "400";

    const GOODS_NOT_EXISTS = "商品不存在";
    const GOODS_NOT_EXISTS_NO = "404";

    const BATCH_MODIFY_STATS_INVALID_PARAMETER = "无效批量修改商品状态参数";
    const BATCH_MODIFY_STATS_INVALID_PARAMETER_NO = "400";

    const BATCH_MODIFY_TAKEOFF_INVALID_PARAMETER = "无效批量修改商品上、下架状态参数";
    const BATCH_MODIFY_TAKEOFF_INVALID_PARAMETER_NO = "400";

    const INVALID_STATS = "上架商品时，商品必须是启用状态";
    const INVALID_STATS_NO = "400";

}
