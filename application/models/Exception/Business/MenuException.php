<?php


namespace models\Exception\Business;

use Exception;

class MenuException extends Exception
{
    const MENU_ID_EMPTY = "id不能为空";
    const MENU_ID_EMPTY_NO = "400";

    const MENU_NOT_EXISTS = "菜单不存在";
    const MENU_NOT_EXISTS_NO = "404";

    const API_HAS_NO_URL = "接口url参数不能为空";
    const API_HAS_NO_URL_NO = "400";

    const MENU_CREATE_FAILURE = "菜单创建失败";
    const MENU_CREATE_FAILURE_NO = "422";

    const MENU_EDIT_FAILURE = "菜单编辑失败";
    const MENU_EDIT_FAILURE_NO = "422";

}
