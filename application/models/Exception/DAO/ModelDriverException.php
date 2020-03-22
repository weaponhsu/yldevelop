<?php


namespace models\Exception\DAO;

use Exception;


class ModelDriverException extends Exception {
    const DRIVER_EXCEPTION_MSG = "%class_name%ModelDriverException报错: {%msg%}";
    const DRIVER_EXCEPTION_MSG_NO = '120001';
}
