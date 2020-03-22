<?php

namespace Common;

use youliPhpLib\Common\DirFileOperation;
use Yaf\Exception;
use Yaf\Registry;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use ErrorMsg\Admin\ErrorMsg;


class Log
{
    private $__log_name = null;
    private $__log_path = null;
    private $__registry_name = null;

    /**
     * @param null|string $_log_name
     */
    public function setLogName($_log_name)
    {
        $this->__log_name = $_log_name;
    }

    /**
     * @param null|string $_log_path
     */
    public function setLogPath($_log_path)
    {
        $this->__log_path = $_log_path;
    }

    /**
     * @param null|string $_registry_name
     */
    public function setRegistryName($_registry_name)
    {
        $this->__registry_name = $_registry_name;
    }

    public function __construct($log_name = '', $log_path = '', $registry_name = '')
    {
        $this->__log_name = $log_name;
        $this->__log_path = $log_path;
        $this->__registry_name = $registry_name;
    }

    /**
     * 生成日志
     * @return bool
     */
    public function genLog(){
        $log_file_name = "log_" . date('Y-m-d', time()) . ".log";


        $db_file = new DirFileOperation($this->__log_path . $log_file_name);
        if ($db_file->genFile() !== true) {
            return false;
        }

        $db_log = new Logger($this->__registry_name);

        $db_log->pushHandler(new StreamHandler($this->__log_path . $log_file_name), Logger::WARNING);

        Registry::set($this->__log_name, $db_log);

        return true;
    }

}