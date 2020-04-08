<?php


namespace models\Mysql;


use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher as EloquentDispatcher;
use Yaf\Registry;

class Eloquent
{
    public static $instance = null;

    /**
     * db constructor.
     */
    private function __construct(){}

    static public function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    public function getConn($type) {
        $capsule = new Capsule;
        $db_conf_arr = Registry::get('config')['db'][$type];

        $db_config = [
            'driver'    => 'mysql',
            'host'    => $db_conf_arr['host'],
            'database'    => $db_conf_arr['dbname'],
            'username'    => $db_conf_arr['user'],
            'password'    => $db_conf_arr['password'],
            'charset'    => 'utf8mb4',
            'collation'    => 'utf8mb4_general_ci',
            'prefix'    => '',
        ];

        $capsule->addConnection($db_config);
        // 监听事件
        $capsule->setEventDispatcher(new EloquentDispatcher($capsule->getContainer()));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

//        Registry::set('capsule', $capsule);
    }
}
