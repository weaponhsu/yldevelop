<?php

namespace models\Mysql;

use Yaf\Registry;
use Doctrine\Common\Cache\RedisCache;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\DBALException;

class db
{
    public static $instance = null;

    private static $__config = [];
    private static $__conn = [];

    static public function setConfig($type = 'master'){
        self::$__config[$type] = [
            'dbname' => Registry::get('config')['db'][$type]['dbname'],
            'user' => Registry::get('config')['db'][$type]['user'],
            'password' => Registry::get('config')['db'][$type]['password'],
            'host' => Registry::get('config')['db'][$type]['host'],
            'port' => Registry::get("config")['db'][$type]['port'],
            'driver' => 'pdo_mysql',
            'charset' => 'utf8'
        ];
    }

    static public function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    /**
     * db constructor.
     */
    private function __construct(){}

    /**
     * 获取数据库实例
     * @param string $type
     * @return mixed|null
     */
    public function getConn($type = 'master') {
        return isset(self::$__conn[$type]) ? self::$__conn[$type] : null;
    }

    /**
     * 初始化数据库
     * @param string $type
     */
    public function setConn($type = 'master') {
        try {
            self::setConfig($type);

            $config = new Configuration();

            if($type !== 'schema' && isset(Registry::get("config")['db'][$type]['cache'])
                && Registry::get("config")['db'][$type]['cache'] === '1'){
                $db_result_cache = new RedisCache();
                $db_redis = new \Redis();
                $db_redis->connect(Registry::get("config")["db"][$type]["redis"]["host"],
                    Registry::get("config")["db"][$type]["redis"]["port"]);
                $db_redis->auth(Registry::get("config")["db"][$type]["redis"]["auth"]);

                $db_result_cache->setRedis($db_redis);
                $config->setResultCacheImpl($db_result_cache);
            }

            self::$__conn[$type] = DriverManager::getConnection(self::$__config[$type], $config);
        } catch (DBALException $e) {
            Registry::get('db_log')->err("数据库初始化失败{$e->getMessage()}");
        }
    }
}
