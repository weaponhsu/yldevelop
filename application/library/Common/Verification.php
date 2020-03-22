<?php

namespace Common;


use Gregwar\Captcha\CaptchaBuilder;
use Yaf\Exception;
use Yaf\Registry;
use youliPhpLib\Common\Encrypt;
use youliPhpLib\Common\StringOperation;

class Verification
{
    /**
     * 生成验证码
     * @param string|mixed $mobile 生成验证码的电话号码
     * @param string $action 验证码类型(注册: register, 忘记密码: resetpassword)
     * @param string $type 验证码类型(纯数字: num, 纯英文: str, 英文数字混合: mix)
     * @param int $length 验证码长度
     * @param bool $is_captcha 是否是图片验证码
     * @return string|Exception
     * @throws \Exception
     */
    static public function genVerification($mobile = false, $action = 'register', $type = 'num', $length = 6, $is_captcha = false){
        $mobile = !empty($mobile) && is_string($mobile) ? trim($mobile) : '';
        $action = !empty($action) && strpos(Registry::get("config")["sms"]["type"], $action) !== false ?
            trim($action)  : '';
        $type = !empty($type) && is_string($type) ? trim($type) : '';
        $length = !empty($length) && is_numeric($length) ? intval($length) : '';

        if(/*(*/empty($mobile) /*&& $mobile !== false)*/ || empty($action) || empty($type) || empty($length))
            return new Exception("生成验证码参数错误", "003");

        try {
            Registry::get("redis")->select(0);
            //生成图片验证码
            if($is_captcha === true){
                $cache_name = Encrypt::encrypt(
                    urldecode(http_build_query(['mobile' => $mobile, 'action' => $action, 'is_captcha' => false])));
                $verification_str = Registry::get("redis")->get($cache_name);
                //如果图片验证码已经存在，则先删除
                if($verification_str){
                    Registry::get("redis")->del($cache_name);
                }
                //创建图形验证码
                $phrase = StringOperation::getRandStr($type, $length);
                Registry::get("redis")->setex($cache_name, Registry::get("config")["sms"]["expire"], json_encode(['verification' => $phrase]));

                $builder = new CaptchaBuilder();
                $builder->setPhrase($phrase);
                $builder->build();
                $builder->save("captcha.jpg");
                $verification_arr['verification'] = Registry::get('config')['application']['host'] . '/captcha.jpg';
            }
            //生成短信验证码
            else{
                $verification_name = $mobile . $action;
                //验证码存在，原样返回
                $verification_str = Registry::get("redis")->get($verification_name);
                if($verification_str){
                    $verification = json_decode($verification_str, true);
                    return $verification['verification'];
                }else{
                    $verification_arr = [
                        'mobile' => $mobile,
                        'verification' => StringOperation::getRandStr($type, $length),
                        'expire' => time() + Registry::get("config")["sms"]["expire"]
                    ];

                    Registry::get("redis")->setex($verification_name, Registry::get("config")["sms"]["expire"], json_encode($verification_arr));

                }
            }
            return $verification_arr['verification'];
        } catch (\Exception $e) {
            throw $e;
        }

    }

    /**
     * 验证验证码
     * @param bool $mobile
     * @param string $action
     * @param string $verification
     * @param bool $is_captcha
     * @return bool
     * @throws \Exception
     */
    static public function checkVerification($mobile = false, $action = 'register', $verification = '', $is_captcha = false){
        try {
            $mobile = !empty($mobile) && is_string($mobile) ? trim($mobile) : '';
            $action = !empty($action) && strpos(Registry::get("config")["sms"]["type"], $action) !== false ?
                trim($action)  : '';
            $verification = !empty($verification) && is_string($verification) ? trim($verification) : '';

            if(empty($mobile) || empty($action))
                throw new Exception("生成验证码参数错误", "001");

            //验证验证码
            $cache_name = $is_captcha === true ? Encrypt::encrypt(
                urldecode(http_build_query(['mobile' => $mobile, 'action' => $action, 'is_captcha' => false])),
                Registry::get("config")["api"]["md5"]["access_key"]
            ) : $mobile . $action;
            Registry::get("redis")->select(0);
            $verification_str = Registry::get("redis")->get($cache_name);
            if(!$verification_str)
//            return new Exception(Registry::get("redis")->DbSize(), "004");
                throw new Exception('验证码失效，请重新获取', "003");

            $verification_arr = json_decode($verification_str, true);
            if(!isset($verification_arr['verification']) || $verification_arr['verification'] != $verification)
                throw new Exception("验证码错误", "002");

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
