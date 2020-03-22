<?php

namespace Common;


use ErrorMsg\Api\ErrorMsg;
use Yaf\Exception;
use Yaf\Registry;
use Yaf\Request_Abstract;
use Yaf\Response_Abstract;

class CheckParam4APi
{
    /**
     * 检查参数
     * @param Request_Abstract $request
     * @return bool
     * @throws Exception
     */
    static public function checkParam4Api(Request_Abstract $request){
        $parameters = Registry::get("config")[strtolower($request->getModuleName())][strtolower($request->getControllerName())][strtolower($request->getActionName())];
//exit(json_encode([$parameters, strtolower($request->getModuleName()), strtolower($request->getControllerName()), strtolower($request->getActionName()), $parameters]));
        if(strpos($parameters, '|') !== false){
            $parameters_arr = explode('|', $parameters);
            $require_parameters_arr = explode(',', $parameters_arr[0]);
            $parameters_array = array_merge($require_parameters_arr, explode(',', $parameters_arr[1]));
        }else{
            $parameters_array = $require_parameters_arr = explode(',', $parameters);
        }

        foreach (Registry::get("parameters") as $parameter => $value){
            //包含非法参数
            if(!in_array($parameter, $parameters_array))
                throw new Exception(ErrorMsg::PARAMETER_IS_INVALID . $parameter, ErrorMsg::REQUIRED_IS_INVALID_NO);

            //入参中包含了必须参数，则将该参数从必须参数数组中剔除
            if(!empty($require_parameters_arr) && in_array($parameter, $require_parameters_arr)){
                $key = array_search($parameter, $require_parameters_arr);
                unset($require_parameters_arr[$key]);
            }
        }
        //判断由前端/客户端发送过来的参数中，是否完全匹配必须参数列表，若否则提示缺少必须参数，并将完整必须参数列表返回
        if(!empty($require_parameters_arr) && strlen(implode('', $require_parameters_arr)) !== 0)
            throw new Exception(
                str_replace('%s',
                    '<必须参数列表:' . implode(',', $require_parameters_arr) . '>',
                    ErrorMsg::REQUIRED_PARAMETER_IS_MISSING),
                ErrorMsg::REQUIRED_IS_INVALID_NO
            );

        //前端/客户端发送了完整必须参数列表，并且没有发送非法参数
        return true;
    }

    /**
     * @param string $method
     * @param array $parameter_arr
     * @return bool|Exception
     */
    static public function checkParameter($method = '', $parameter_arr = []){
        $method = !empty($method) && is_string($method) ? strtolower(trim($method)) : '';
        $parameter_arr = !empty($parameter_arr) && is_array($parameter_arr) ?
            $parameter_arr : '';
        if(empty($method) || empty($parameter_arr))
            return new Exception("缺少必须参数1", "002");

        $method_name = substr($method, 0, strpos($method, 'controller'));
        $action_name = substr($method, strpos($method, '::') + 2, strpos($method, 'action') - strpos($method, '::') - 2);

        $valid_parameter_str = "," . Registry::get("config")["api"][$method_name][$action_name] . ",";
        $parameter_is_valid = true;
//        if(count($parameter_arr) < count(explode(",", Registry::get("config")["api"][$method_name][$action_name])))
//            return new Exception("缺少必须参数2", "002");

        foreach ($parameter_arr as $parameter => $value){
            if(strpos($valid_parameter_str, "," . $parameter . ",") === false){
                exit(json_encode($parameter));
                $parameter_is_valid = false;
            }
        }

        if($parameter_is_valid === false)
            return new Exception("缺少必须参数3", "002");

        return true;
    }

}
