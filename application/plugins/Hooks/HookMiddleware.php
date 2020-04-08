<?php


namespace Hooks;


use Common\HttpHelper;
use Yaf\Plugin_Abstract;
use Yaf\Registry;
use Yaf\Request_Abstract;
use Yaf\Response_Abstract;

class HookMiddlewarePlugin extends Plugin_Abstract
{
    public $middleware = null;

    public function routerStartup(Request_Abstract $request, Response_Abstract $response) {
        $this->middleware = HttpHelper::getInstance();
        $this->middleware->setHttp($request);
        $this->middleware->genUserInfo();
        $this->middleware->checkUrlQuery();
    }

    public function routerShutdown(Request_Abstract $request, Response_Abstract $response) {
        $this->middleware = is_null($this->middleware) ? HttpHelper::getInstance() : $this->middleware;
        $this->middleware->setHttp($request);
        $this->middleware->parseParam();
        $this->middleware->chkParam();
    }

    public function dispatchLoopStartup(Request_Abstract $request, Response_Abstract $response) {

    }

    public function dispatchLoopShutdown(Request_Abstract $request, Response_Abstract $response){
        $this->middleware = is_null($this->middleware) ? HttpHelper::getInstance() : $this->middleware;
        $this->middleware->setHttp($request);
        $this->middleware->setResponse($response);
        $this->middleware->setResponseHeader();

        // 关闭sql
//        if (Registry::get('read')->isConnected() === true)
//            Registry::get('read')->close();
//
//        if (Registry::get('write')->isConnected() === true)
//            Registry::get('write')->close();
    }

}
