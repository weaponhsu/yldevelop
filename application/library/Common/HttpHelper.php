<?php


namespace Common;


use ErrorMsg\Admin\AccessErrMsg;
use ErrorMsg\Api\ErrorMsg;
use Yaf\Exception;
use Yaf\Registry;
use Yaf\Request_Abstract;
use Yaf\Response_Abstract;
use Yaf\Session;
use youliPhpLib\Common\Encrypt;
use youliPhpLib\Common\RsaOperation;
use youliPhpLib\Common\StringOperation;

class HttpHelper
{
    static public $instance = null;
    public $http = null;
    public $response = null;
    public $is_mobile = null;
    public $is_admin = null;
    public $is_api = null;
    public $rsa = null;
    public $module_name = null;
    public $controller_name = null;
    public $action_name = null;

    static public function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    private function __construct() {
        $this->http = $this->http instanceof Request_Abstract ? Registry::get('http') : $this->http;
        $this->rsa = RsaOperation::getInstance(Registry::get('config')['rsa']['public_pem'],
            Registry::get('config')['rsa']['private_pem']);
    }

    public function setHttp(Request_Abstract $request) {
        $this->http = $request;
    }

    public function setResponse(Response_Abstract $response) {
        $this->response = $response;
    }

    /**
     * 根据url判断是后台请求，还是接口请求
     */
    public function checkUrlQuery(){
        $url_arr = array_filter(explode('/', $this->http->getRequestUri()));

        if (count($url_arr) <= 0)
            exit("无效链接");

        // 后台接口
        if(strpos($this->http->getRequestUri(), '/admin/') !== false){
            $this->is_admin = true;
            $this->is_api = false;
        }
        // 接口 将版本号设置到parameters中
        else if(preg_match_all("/v[0-9]{1}+/Usi", $url_arr[1], $match_array)){
            if (! is_null(Registry::get('parameters'))) {
                Registry::set(
                    "parameters",
                    array_merge(Registry::get('parameters'), ['version' => $match_array[0][0]])
                );
            } else
                Registry::set("parameters", ['version' => $match_array[0][0]]);
            // 后台也提供api接口，根据版本号来区分后台与前端、客户端的接口
            // 基数为前端、客户端接口，偶数为后台接口。例:v1、v3为前端客户端接口，v2为后台接口
            $this->is_api = (int)str_replace('v', '', $match_array[0][0]) % 2 !== 0 ? true : false;
            $this->is_admin = (int)str_replace('v', '', $match_array[0][0]) % 2 === 0 ? true : false;
            Registry::get('db_log')->debug(json_encode([
                $match_array[0], $this->is_admin, $this->is_api
            ]));

            $this->is_api = true;
            $this->is_admin = false;
        }
        // 前台接口
        else if (strpos($this->http->getRequestUri(), '/api/') !== false) {
            $this->is_admin = false;
            $this->is_api = true;
        }

        if(in_array($this->http->getMethod(), ['PUT', 'DELETE']) || $this->http->getMethod() == 'GET' && count($url_arr) == 4){
            Registry::set(
                "parameters",
                ! is_null(Registry::get('parameters')) ? array_merge(Registry::get('parameters'), ['id' => $url_arr[3]]) : ['id' => $url_arr[3]]
            );
        }
    }

    /**
     * 校验参数合法性
     * @return bool
     * @throws Exception
     */
    public function isInvalidParam() {
        $parameters = Registry::get("config")[$this->module_name][$this->controller_name][$this->action_name];
//exit(json_encode([Registry::get('parameters'), $parameters, $this->module_name, $this->controller_name, $this->action_name, $parameters]));
        if(strpos($parameters, '|') !== false){
            $parameters_arr = explode('|', $parameters);
            $require_parameters_arr = explode(',', $parameters_arr[0]);
            $parameters_array = array_merge($require_parameters_arr, explode(',', $parameters_arr[1]));
        }else{
            $parameters_array = $require_parameters_arr = explode(',', $parameters);
        }

        foreach (Registry::get("parameters") as $parameter => $value){
            //包含非法参数
            if(!in_array($parameter, $parameters_array) && $parameter != 'from_api')
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
     * 验证是否有权限访问 jwt是否有效
     * @throws Exception
     */
    public function isInvalidAccess() {
        // 验证权限
        if(!in_array($this->action_name, ['rsaencrypt', 'login', 'signin', 'upload', 'location', 'authenticator'])) {
            // 验证当前登录账号是否有权限访问当前url
            try {
                $this->chkAdminAccess();
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * 验证当前登陆用户是否有权限访问当前url
     * @return bool
     * @throws Exception
     */
    public function chkAdminAccess() {
        //验证session
        if(empty(Session::getInstance()->get('admin_id')) || empty(Session::getInstance()->get('role_id')) ||
            empty(Session::getInstance()->get("access_list"))){
            throw new Exception(AccessErrMsg::USER_LOGIN_FIRST, AccessErrMsg::USER_LOGIN_FIRST_NO);
        }

        //验证权限
        $access_list = json_decode(Session::getInstance()->get("access_list"), true);

        $current_url_is_valid = false;
        if (! in_array($this->http->getRequestUri(),
            ['/admin/access/data', '/admin/user/home', '/admin/user/launch', '/admin/user/logout', '/common/common/error', '/admin/user/login',
                '/admin/user/modify', '/admin/user/authenticator'])) {
            if (strpos($this->http->getRequestUri(), 'admin/user') !== false && strpos($this->http->getRequestUri(), '/info') !== false) {
                $current_url_is_valid = true;
            } else {
                $access_list = array_unique(array_filter($access_list));
                foreach ($access_list as $valid_url){
                    if (count(array_filter(explode('/', $valid_url))) >= 3 || $valid_url . '/index' == $this->http->getRequestUri()) {
                        if(!empty($valid_url)){
                            $request_uri = strtolower(preg_replace('/\/[0-9]+/', '', $this->http->getRequestUri()));
                            $valid_url = strtolower(preg_replace('/\/[0-9]+/', '', $valid_url));
                            if(strpos($request_uri, $valid_url) !== false){
                                $current_url_is_valid = true;
                            }
                        }
                    }
                }
            }
        } else
            $current_url_is_valid = true;

        if($current_url_is_valid === false)
            throw new Exception(AccessErrMsg::PERMISSION_DENIED, AccessErrMsg::PERMISSION_DENIED_NO);

        return $current_url_is_valid;
    }

    /**
     * rsa 私钥解密
     * @throws Exception
     */
    public function decryptParam() {
        $this->module_name = strtolower($this->http->getModuleName());
        $this->controller_name = strtolower($this->http->getControllerName());
        $this->action_name = strtolower($this->http->getActionName());

        //私钥解密
        $callback = [];
        if(isset(Registry::get("parameters")['callback']))
            $callback['callback'] = Registry::get("parameters")['callback'];

        $rsa = RsaOperation::getInstance(Registry::get('config')['rsa']['public_pem'],
            Registry::get('config')['rsa']['private_pem']);
        $parameter_array = [];
        $parameter_str = isset(Registry::get("parameters")['secret']) ?
            $rsa->privateDecrypt(Registry::get("parameters")['secret']) :
            '';

        $files_arr = $this->http->getFiles();
        if($files_arr)
            $parameter_array = array_merge($parameter_array, $files_arr);

        if(Registry::get("method") !== 'DELETE' && (empty($parameter_str))) {
            // 测试接口如果接受到无法解密的字符串，则将接受到的参数加密后返回
            if (strpos($this->http->getServer('HTTP_REFERER'), '/swagger/') !== false)
                exit($rsa->publicEncrypt(Registry::get("parameters")['secret']));
            else
                throw new Exception('无效加密字符串', '001');
        }

        foreach (explode('&', $parameter_str) as $val){
            $parameter_value_arr = explode('=', $val);
            if(!empty($parameter_value_arr[0])){
                $parameter_array[$parameter_value_arr[0]] = urldecode($parameter_value_arr[1]);
            }
        }

        $path_parameters = $this->http->getParams();
        $old_parameters = null;
        foreach ($path_parameters as $key => $val){
            if(!isset($old_parameters[$key])){
                $old_parameters[$key] = urldecode($val);
            }
        }
        if (!is_null($old_parameters)) {
            unset($old_parameters['secret']);
            $parameter_array = array_merge($parameter_array, $old_parameters);
        }
        $parameter_array['from_api'] = true;

        Registry::set("parameters", empty($callback) ? $parameter_array : array_merge($callback, $parameter_array));

        try {
            $this->isInvalidParam();
        } catch (Exception $e) {
            throw $e;
        }

    }

    /**
     * rsa验签
     * @return bool
     * @throws Exception
     */
    public function verify() {
        // 签证签名
        $param_arr = Registry::get('parameters');
        if (in_array($this->http->getMethod(), ['PUT', 'DELETE']) ||
            ($this->http->getActionName() !== 'list' && $this->http->getMethod() == 'GET' && isset($param_arr['id'])))
            unset($param_arr['id']);
        $this->module_name = strtolower($this->http->getModuleName());
        $this->controller_name = strtolower($this->http->getControllerName());
        $this->action_name = strtolower($this->http->getActionName());
        // 根据module controller action 读取不需要加密的参数
        $un_sign_param_str = Registry::get('config')['unsign'][$this->module_name][$this->controller_name][$this->action_name];

        unset($param_arr['sign']);
        foreach ($param_arr as $idx => $param) {
            if (in_array($idx, explode(',', $un_sign_param_str)))
                unset($param_arr[$idx]);
        }
        ksort($param_arr);
//                exit(json_encode($param_arr));
        $original_str = urldecode(http_build_query($param_arr));
//                echo $original_str;exit();
//exit(json_encode([$original_str, $this->rsa->verify(Registry::get('parameters')['sign'], $original_str)]));
        if (! in_array($this->action_name, ['info', 'logout', 'delete']) && $this->rsa->verify(Registry::get('parameters')['sign'], $original_str) === false) {
            if (strpos($this->http->getServer('HTTP_REFERER'), '/swagger/') !== false)
                exit($this->rsa->sign($original_str));
            throw new Exception(ErrorMsg::SIGN_VERIFY_FAILURE, ErrorMsg::SIGN_INVALID_NO);
        }

        if($this->controller_name !== 'error' && strtolower($this->action_name !== 'rsaencrypt')){
            //接口参数验证
            try {
                $this->isInvalidParam();
            } catch (Exception $e) {
                throw $e;
            }
        }

        return true;
    }

    /**
     * 前端接口 验证jwt
     * @throws Exception
     */
    public function chkJwt4Api() {
        // 是否rsa加密接口，是否校验jwt
        $is_rsa_encrypt = $is_jwt_action = false;
        if (strtolower($this->http->getActionName() !== 'rsaencrypt'))
            $is_rsa_encrypt = true;

        // 是否需要校验jwt
        if ($is_rsa_encrypt === true)
            // /vN/xxxx/login,/vN/xxxx/info,/vN/xxxx/verify,/vN/xxxx/oauthlogin接口不需要检验jwt
            $is_jwt_action = !in_array(strtolower($this->http->getActionName()),
                ['login', 'info', 'verify', 'oauthlogin', 'register', 'verification', 'location']);

        // 校验jwt
        if ($is_jwt_action === true) {
            $jwt_info = AccessToken4Api::checkJWT($this->http->getServer("HTTP_AUTHORIZATION"));
            Registry::set('jwt_info', $jwt_info);
        }
    }

    /**
     * 验证jwt
     * @throws Exception
     */
    public function isInvalidJwt() {
        if ($this->action_name !== 'login' && $this->action_name !== 'aaa') {
            try {
                // 验证jwt
                $jwt = is_null($this->http->getServer('HTTP_AUTHORIZATION')) && isset($_SERVER['HTTP_AUTHORIZATION']) ?
                    $_SERVER['HTTP_AUTHORIZATION'] : $this->http->getServer('HTTP_AUTHORIZATION');
                $jwt_info = AccessToken4Api::checkJWT($jwt);
                Registry::set('jwt_info', $jwt_info);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * 检查参数
     * @throws Exception
     */
    public function chkParam() {
        if ($this->is_admin === true) {
            $this->verify();
            $this->isInvalidJwt();
            $this->isInvalidAccess();
        } else if ($this->is_api === true) {
            $this->chkJwt4Api();
            $this->decryptParam();
        }
    }

    /**
     * 设置response header
     */
    public function setResponseHeader() {
        // 接口
        if($this->is_api === true || $this->is_admin) {
            $this->response->setHeader("Content-type", "application/json");
            $this->response->setHeader("charset", "UTF-8");
        }
    }

    /**
     * 获取参数
     */
    public function parseParam(){
        //设置参数
        if($this->http->getFiles()){
            $parameters_arr = array_merge($_POST, $this->http->getFiles());
            Registry::set("parameters", $parameters_arr);
        }

        Registry::set("method", $this->http->getMethod());

        $old_parameters = Registry::get("parameters");

        if ($this->http->isGet() === true) {
//            $request_parameters = array_filter($this->http->getQuery());
            $request_params = $this->http->getQuery();
            $request_parameters = [];

            foreach ($request_params as $request_key => $request_param) {
                if (strpos($this->http->getRequestUri(), $request_key) === false) {
                    $request_parameters[$request_key] = $request_param;
                }
            }
        } else {
            $parameters = file_get_contents("php://input");
            parse_str($parameters, $request_parameters);
        }
        $parameters = $old_parameters && $request_parameters ? array_merge($old_parameters, $request_parameters) :
            ($old_parameters && ! $request_parameters ? $old_parameters :
                ($request_parameters && ! $old_parameters ? $request_parameters : [])
            );
        Registry::set("parameters", $parameters);
    }

    /**
     * 获取访问者信息
     */
    public function genUserInfo(){
        $user_agent = $this->http->getServer("HTTP_USER_AGENT") ? $this->http->getServer("HTTP_USER_AGENT") : null;
        $user_agent_comments_block = preg_match('|(.*?)|', $user_agent, $matches) > 0 ? $matches[0] : '';

        $mobile_os_list = ['Google Wireless Transcoder', 'Windows CE', 'WindowsCE', 'Symbian', 'Android', 'armv6l', 'armv5', 'Mobile', 'CentOS', 'mowser', 'AvantGo', 'Opera Mobi', 'J2ME/MIDP', 'Smartphone', 'Go.Web', 'Palm', 'iPAQ'];
        $mobile_token_list = ['Profile/MIDP', 'Configuration/CLDC-', '160×160', '176×220', '240×240', '240×320', '320×240', 'UP.Browser', 'Android', 'UP.Link', 'SymbianOS', 'PalmOS', 'PocketPC', 'SonyEricsson', 'Nokia', 'BlackBerry', 'Vodafone', 'BenQ', 'Novarra-Vision', 'Iris', 'NetFront', 'HTC_', 'Xda_', 'SAMSUNG-SGH', 'Wapaka', 'DoCoMo', 'iPhone', 'iPod'];

        $is_mobile = false;
        foreach ($mobile_token_list as $value) {
            if (strpos($user_agent, $value) !== false) {
                $is_mobile = true;
                break;
            }
        }

        if ($is_mobile === false) {
            foreach ($mobile_os_list as $value) {
                if (strpos($user_agent_comments_block, $value) !== false) {
                    $is_mobile = true;
                    break;
                }
            }
        }

        $data = [
            'ip' => StringOperation::getIP(),
            'url' => $_SERVER['PHP_SELF'],
            'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'is_mobile' => $is_mobile,
            'result' => ''
        ];

        Registry::set('user_log_info', $data);
    }

}
