<?php

use Yaf\Registry;
use youliPhpLib\Common\RsaOperation;
use youliPhpLib\Common\Upload;
use youliPhpLib\Common\DirFileOperation;
use models\Exception\AbstractException;
use Common\PhpExcelImport;


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
}
