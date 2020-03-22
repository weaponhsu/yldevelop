<?php


namespace Hooks;


use ErrorMsg\Api\ErrorMsg;
use Yaf\Exception;
use Yaf\Plugin_Abstract;
use Yaf\Registry;
use Yaf\Request_Abstract;
use Yaf\Response_Abstract;
use youliPhpLib\Common\StringOperation;

class IpFilterMiddlewarePlugin extends Plugin_Abstract
{
    public function dispatchLoopStartup(Request_Abstract $request, Response_Abstract $response){
        // 获取有效ip字符串,并关闭redis
        $redis_client = Registry::get('redis');
        $redis_client->select(1);
        $white_ip_string = $redis_client->get('ipWhite');
        $redis_client->close();
        $white_ip_string .= ',' . Registry::get('config')['ip']['notify']['white'];

        // 获取当前客户端ip
        $client_ip = StringOperation::getIP();

        // 判断请求admin模块或api模块的ip是否合法
        if (($request->getModuleName() === 'Api' && strpos($white_ip_string, $client_ip) === false) /*||
            ($request->getModuleName() === 'Admin' && $client_ip !== Registry::get('config')['ip']['admin']['white'])*/) {
            throw new Exception(ErrorMsg::INVALID_IP, ErrorMsg::SIGN_INVALID_NO);
        }

        // 判断请求notify模块的ip是否合法
        if ($request->getModuleName() === 'Notify' &&  strpos($white_ip_string, $client_ip) === false) {
            throw new Exception(ErrorMsg::INVALID_IP, ErrorMsg::SIGN_INVALID_NO);
        } else {
//            Registry::get('ip_log')->debug('判断远程服务端的ip是否合法. 远程服务端ip: ' . StringOperation::getIP());
        }
    }

}
