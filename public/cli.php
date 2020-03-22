<?php
/**
 *
 *            ┏┓　　  ┏┓+ +
 *           ┏┛┻━━━━━┛┻┓ + +
 *           ┃         ┃ 　
 *           ┃   ━     ┃ ++ + + +
 *          ████━████  ┃+
 *           ┃　　　　　 ┃ +
 *           ┃　　　┻　　┃
 *           ┃　　　　　 ┃ + +
 *           ┗━┓　　　┏━┛
 *             ┃　　　┃　　　　
 *             ┃　　　┃ + + + +
 *             ┃　　　┃    Code is far away from bug with the alpaca protecting
 *             ┃　　　┃ + 　　　　        神兽保佑,代码无bug
 *             ┃　　　┃
 *             ┃　　　┃　　+
 *             ┃     ┗━━━┓ + +
 *             ┃         ┣┓
 *             ┃ 　　　　　┏┛
 *             ┗┓┓┏━━┳┓┏━┛ + + + +
 *              ┃┫┫  ┃┫┫
 *              ┗┻┛  ┗┻┛+ + + +
 * Created by PhpStorm.
 * User: weaponhsu
 * Date: 2018/6/12
 * Time: 下午1:49
 */

date_default_timezone_set("PRC");

define("APP_PATH",  realpath(dirname(__FILE__) . '/../'));

$config_file_name = APP_PATH."/conf/hsu.ini";

$app = new Yaf\Application($config_file_name/*APP_PATH."/conf/application.ini"*/);

define('ENVIRONMENT', 'development');

switch (ENVIRONMENT)
{
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>='))
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        }
        else
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

// 拆分request_uri
global $argv;
$uri = $argv[1];
$request_uri = '';
if (stripos($uri, 'request_uri=') !== 0)
    exit('非法参数');

$uri_info = parse_url($uri);
if (! isset($uri_info['path']))
    exit('参数不包含path部分');

$parameters_arr = [];
$module = $controller = $action = 'Index';
// 若cli的第二个参数包含'='，则从'='开始获取uri
$path = stripos($uri_info['path'], '=') !== false ? substr($uri_info['path'], stripos($uri_info['path'], '=') + 1) :
    $uri_info['path'];
// 若cli是以'/'开头，则去掉第一个'/'
$path = stripos($path, '/') === 0 ? substr($path, 1) : $path;
// 若cli是以'/'结尾，则在去掉最后一个'/'
$path = strrpos($path, '/') + 1 === strlen($path) ? substr($path, 0, strrpos($path, '/')) : $path;

if (strpos($path, '/') === false)
    exit('不是一个有效的url');
list($module, $controller, $action) = explode('/', $path . '/');

// uri中只有一个'/'，表示没有module
if (empty($action)){
    $action = $controller;
    $controller = $module;
    $module = 'Index';
}
// 有url参数
if (isset($uri_info['query']))
    parse_str($uri_info['query'], $parameters_arr);

$request_simple = new Yaf\Request\Simple('Cli', $module, $controller, $action, $parameters_arr);

$app->bootstrap()
    ->getDispatcher()
//    ->catchException(true)
    ->throwException(true)
    ->dispatch($request_simple);
//    ->dispatch(new Yaf\Request\Simple());
