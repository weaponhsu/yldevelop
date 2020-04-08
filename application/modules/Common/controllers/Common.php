<?php

use Yaf\Registry;
use youliPhpLib\Common\RsaOperation;
use youliPhpLib\Common\Upload;
use youliPhpLib\Common\DirFileOperation;
use models\Exception\AbstractException;
use youliPhpLib\Common\StringOperation;
use Common\PhpExcelImport;
use youliPhpLib\Common\RequestHelper;
use models\Business\SmsCode;
use models\Business\Location;


class CommonController extends ApiBaseController
{
    /**
     * @SWG\Get(
     *     path="/common/common/rsaEncrypt",
     *     tags={"Common"},
     *     summary="rsa加密",
     *     @SWG\Parameter(
     *          name="sign",
     *          description="要签名的字符串 例username=后台登录账户&password=后台登录密码",
     *          in="query",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="返回结果中包含error,message,result。result为参数公钥加密过后的字符串"
     *     )
     * )
     */
    public function rsaEncryptAction()
    {
        $rsa = RsaOperation::getInstance(
            Registry::get('config')['rsa']['public_pem'],
            Registry::get('config')['rsa']['private_pem']
        );

        // 签名 后台用的
        $data = $original_str = urldecode(Registry::get("parameters")['sign']);
        parse_str($original_str, $parameter_arr);

        $sign = $rsa->sign($parameter_arr);

        // 加密 给客户端跟前台用的
        $encrypt = $rsa->publicEncrypt($parameter_arr);

        return $this->_responseJson(
            [
                'error' => '000',
                'data' => $parameter_arr,
                'encrypt' => $encrypt,
                'decrypt' => $rsa->privateDecrypt($encrypt),
                'sign_str' => $original_str,
                'sign' => $sign,
                'verify' => $rsa->verify($sign, Registry::get("parameters")['sign'])
            ]
        );
    }

    /**
     * @SWG\Post(
     *     path="/common/common/upload",
     *     tags={"Common"},
     *     summary="上传图片",
     *     description="测试上传图片地址:http://192.168.x.x:xxx/index/test",
     *     consumes={"multipart/form-data", "application/x-www-form-urlencoded"},
     *     @SWG\Parameter(
     *          name="file",
     *          description="图片",
     *          in="formData",
     *          required=true,
     *          type="file"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="返回结果中包含error,message,result。result为参数公钥加密过后的字符串"
     *     )
     * )
     */
    public function UploadAction() {
        $response['file'] = 'error';
        $bucket = Registry::get('parameters')['type'];
        $table_name = Registry::get('parameters')['table_name'];
        $request_file = Registry::get('parameters')['file'];

        if ($request_file) {
            $target_dir = APP_PATH . Registry::get("config")['upload']['target_dir'] . '/' . $bucket . '/';
            $file_path = $target_dir . basename($request_file['name']);
            $dir_file_operation = new DirFileOperation($file_path);
            $make_dir_result = $dir_file_operation->chkFileDir();
            if ($make_dir_result !== true) {
                $e = new Exception(str_replace('%s', $request_file['name'], AbstractException::UPLOAD_MAKE_DIR_FAILED . '(' . $make_dir_result . ')'), '003');
                throw $e;
            }
            $upload = new Upload($request_file);
            $result = $upload->setAllowedTypes(Registry::get("config")["upload"]["file_extension"])
                ->setMaxWidth(Registry::get("config")['upload']['thumb']['max_width'])
                ->setMaxHeight(Registry::get("config")["upload"]['thumb']["max_height"])
                ->setMaxSize(Registry::get("config")["upload"]['thumb']["max_size"])
                ->setDestination($target_dir)
                ->upload();

            if (is_string($result)) {
                $res = str_replace(APP_PATH . '/' . 'public', '', $result);

                // 若上传的是证书
                if ($request_file['type'] == 'application/x-x509-ca-cert') {
                    $ip = isset(Registry::get('parameters')['ip']) ? Registry::get('parameters')['ip'] : '';
                    if (empty($ip))
                        throw new Exception('ip白名单不能为空', '400');

                    $new_file_path = substr($res, 0, strrpos($res, '/') + 1) . $ip . '.' . pathinfo(basename($request_file['name']), PATHINFO_EXTENSION);

                    if (! copy(APP_PATH . '/public' . $res, APP_PATH . '/public' . $new_file_path))
                        throw new Exception('证书复制失败', '400');
                    if (! unlink(APP_PATH . '/public' . $res))
                        throw new Exception('文件删除失败', '400');
                    $res = $new_file_path;
                }

                $response['file'] = Registry::get('config')['application']['host'] . $res;

                // 导入的excel 批量插入
                $file_type = pathinfo($res, PATHINFO_EXTENSION);
                if (!empty($table_name) && ($file_type == 'xlsx' || $file_type == 'xls') ) {
                    $table_name = 'products';
                    PhpExcelImport::getInstance($table_name)->setFileName(APP_PATH . '/public/' . $res)
                        ->import();
                }
            }
        }
        return $this->_responseJson(['data' => $response]);
    }

    /**
     * @SWG\Get(
     *     path="/v3/common/verification",
     *     tags={"Common"},
     *     summary="获取短信验证码",
     *     description="
     * mobile 必须参数 手机号码
     * type 必须参数 类型 可选值: login=登陆,register=注册
     * captcha=图片验证码 非必须参数",
     *     @SWG\Parameter(
     *          name="secret",
     *          description="所有参数使用&连接的rsa加密结果",
     *          in="query",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="返回结果中包含error,message,result。result为参数公钥加密过后的字符串"
     *     )
     * )
     */
    public function verificationAction() {
        $verification_result = true;

        //校验图片验证码
        if (isset(Registry::get("parameters")["captcha"])) {
            $verification_result = \Common\Verification::checkVerification(
                Registry::get("parameters")["mobile"],
                Registry::get("parameters")["type"],
                Registry::get("parameters")["captcha"],
                true
            );
        }

        if ($verification_result !== true) throw new Exception("图片验证码校验失败");

        //验证手机号码有效性
        try {
            StringOperation::mobileIsValid(Registry::get("parameters")["mobile"]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 400);
        }

        //获取短信验证码
        $verification_arr = SmsCode::genSmsCode(
            Registry::get('parameters')['mobile'],
            Registry::get('parameters')['type']
        );

        //生成发送短信验证码的参数，调用接口，发送短信验证码
        $content = str_replace("#verification#", $verification_arr['verification'], SmsCode::LOGIN_SMS_TEMPLATE);

        // 蓝创发送短信
        $arr = [
            'account'  => Registry::get('config')['sms']['username'],
            'password' => Registry::get('config')['sms']['password'],
            'msg' => urlencode($content),
            'phone' => Registry::get("parameters")['mobile'],
            'report' => true
        ];
        list($header, $msg) = RequestHelper::curlRequest(
            Registry::get('config')['sms']['url'], json_encode($arr), 'POST',
            ['Content-Type: application/json; charset=utf-8']);
        $sms_res = json_decode(substr($msg, $header), true);

        if ($sms_res['code'] != '0')
            Registry::get('user_log')->err('短信下发失败:' . json_encode([$arr, $sms_res]) . '.reason: ' . $sms_res['errorMsg']);
//        else
//            Registry::get('user_log')->info('短信下发成功:' . json_encode([$arr, $sms_res]));

        return $this->_responseJson(['data' => [Registry::get('parameters')['mobile'], $verification_arr['verification']]]);
    }

    /**
     * @SWG\Get(
     *     path="/v3/common/location",
     *     tags={"Common"},
     *     summary="获取省市区县街道接口",
     *     description="
     * type 必须参数 类型 可选值: 1为省份，2为城市，3为区县，4为街道
     * parent_id 非必须参数 上级行政单位编号 获取市、区县、街道时必须，需要发送上级行政单位编号",
     *     @SWG\Parameter(
     *          name="secret",
     *          description="所有参数使用&连接的rsa加密结果",
     *          in="query",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="返回结果中包含error,message,result。result为参数公钥加密过后的字符串"
     *     )
     * )
     */
    public function locationAction() {
        $parameters = Registry::get('parameters');

        $data = Location::getLocation(
            isset($parameters['parent_id']) ? $parameters['parent_id'] : '', $parameters['type']);

        return $this->_responseJson(['data' => $data]);
    }
}
