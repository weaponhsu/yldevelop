<?php

use Yaf\Bootstrap_Abstract;
use Yaf\Dispatcher;
use Yaf\Application;
use Yaf\Request\Http;
use Yaf\Registry;
use Yaf\Session;
use models\Mysql\db;
//use models\Redis\RedisManager;
use models\Cache\Redis\RedisManager;
use models\Cache\Redis\RedisSortedSetManager;
use models\Cache\Redis\RedisStringManager;
use Common\Log;
use Hooks\routerStartupMiddlewarePlugin;
use Hooks\HookMiddlewarePlugin;
use Hooks\IpFilterMiddlewarePlugin;

class Bootstrap extends Bootstrap_Abstract
{
    /**
     * 导入composer
     */
    public function _initVendor()
    {
        require realpath(dirname(__FILE__)) . '/../vendor/autoload.php';
    }

    public function _initSession(Dispatcher $dispatcher)
    {
        if($dispatcher->getRequest()->isCli() === false)
            Session::getInstance()->start();
    }

    /**
     * 设置日志
     */
    public function _initLog()
    {
        $log = new Log('db_log', realpath(dirname(__FILE__)) . '/../log/db/', 'db');
        $log->genLog();

        $log->setLogName('user_log');
        $log->setLogPath(realpath(dirname(__FILE__)) . '/../log/user/');
        $log->setRegistryName('user');
        $log->genLog();

        $log->setLogName('transformer_log');
        $log->setLogPath(realpath(dirname(__FILE__)) . '/../log/transformer/');
        $log->setRegistryName('transformer');
        $log->genLog();

        $log->setLogName('order_log');
        $log->setLogPath(realpath(dirname(__FILE__)) . '/../log/orders/');
        $log->setRegistryName('orders');
        $log->genLog();

        $log->setLogName('notify_log');
        $log->setLogPath(realpath(dirname(__FILE__)) . '/../log/notifies/');
        $log->setRegistryName('notify');
        $log->genLog();

        $log->setLogName('upstream_notify_log');
        $log->setLogPath(realpath(dirname(__FILE__)) . '/../log/upstream_notifies/');
        $log->setRegistryName('upstream_notify');
        $log->genLog();

        $log->setLogName('confirm_log');
        $log->setLogPath(realpath(dirname(__FILE__)) . '/../log/confirm/');
        $log->setRegistryName('confirm');
        $log->genLog();

        $log->setLogName('ip_log');
        $log->setLogPath(realpath(dirname(__FILE__)) . '/../log/ip/');
        $log->setRegistryName('ip');
        $log->genLog();
    }

    /**
     * 导入配置文件
     */
    public function _initConfig()
    {
        $config = Application::app()->getConfig()->toArray();

        //判断路由配置文件是否存在，并合并配置文件
        if(! file_exists(APP_PATH . '/conf/route.ini')){
            exit("路由文件不存在");
        }
        $route = new Yaf\Config\Ini(APP_PATH . '/conf/route.ini');

        $config = array_merge($config, $route->toArray());

        Registry::set("config", $config);
        Dispatcher::getInstance()->autoRender(false);
    }


    public function _initRouter(Dispatcher $dispatcher){
        $dispatcher->catchException(true);
        $router = $dispatcher->getRouter();
        if (isset(Registry::get("config")['routes']))
            $router->addConfig(Registry::get("config")['routes']);
    }

    public function _initHttp(){
        if(! Registry::get('http')){
            Registry::set('http', new Http());
        }
    }

    /**
     * 导入插件
     * @param Dispatcher $dispatcher
     */
    public function _initPlugin(Dispatcher $dispatcher)
    {
        $admin_middleware = new HookMiddlewarePlugin();
        $dispatcher->registerPlugin($admin_middleware);
    }

    /**
     * 实例化redis
     */
    public function _initRedis()
    {
        try {
            $redis = RedisManager::getInstance([
                'schema' => 'tcp',
                'host' => Registry::get("config")["redis"]["master"]["host"],
                'port' => Registry::get("config")["redis"]["master"]["port"],
                'password' => Registry::get("config")["redis"]["master"]["auth"]
            ]);
            Registry::set("redis", $redis->getClient());

            $redis_sorted_set = RedisSortedSetManager::getInstance($redis);
            Registry::set('redis_sorted_set', $redis_sorted_set);

            $redis_string = RedisStringManager::getInstance($redis);
            Registry::set('redis_string', $redis_string);
        } catch (Exception $e) {
            exit(json_encode($e->getMessage()));
        }
    }

    /**
     * 实例化mysql数据库
     */
    public function _initDb()
    {
        try {
            $db = db::getInstance();
            // 配置写库(主库)
            $db->setConn('master');
            $master_db = $db->getConn();

            Registry::set("write", $master_db);

            // 配置读库(从库)
            if (isset(Registry::get("config")['db']['slave'])) {
                $db->setConn('slave');
                $slave_db = $db->getConn('slave');
                Registry::set("read", $slave_db);
            } else
                Registry::set("read", $master_db);

            if (isset(Registry::get("config")['db']['schema'])) {
                $db->setConn('schema');
                $schema_db = $db->getConn('schema');
                Registry::set("schema", $schema_db);
            }

        } catch (Exception $e) {
            exit(json_encode($e->getMessage()));
        }

    }

    /*public function _initMemcache(){
        require_once realpath(dirname(__FILE__)) . '/../application/models/Memcache/MemcacheManager.php';
        $memcache = new MemcacheManager(
            Registry::get("config")['admin']['master']['memecache']['host'],
            Registry::get("config")['admin']['master']['memecache']['port']
        );

        Registry::set("memcache", $memcache->getMemcached());
    }*/
}
