<?php

namespace Common;


use ErrorMsg\Api\ErrorMsg;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Yaf\Exception;
use Yaf\Registry;
use Firebase\JWT\JWT;

class AccessToken4Api
{
    /**
     * @param string $uuid
     * @param string $member_id
     * @param string $role_id
     * @param string $site_id
     * @param bool $is_expire
     * @return string
     */
    static public function generateJWT($uuid = '', $member_id = '', $role_id = '', $site_id = '', $is_expire = false)
    {
        $token = [
            'jti' => $uuid,
            'iss' => 'https://api.37egou.com/',
            'iat' => time(),
            'exp' => time() + 86400,
        ];
        if (!empty($member_id)) {
            $token['id'] = $member_id;
        }
        if (!empty($company_id)) {
            $token['company_id'] = $company_id;
        }
        if (!empty($role_id)) {
            $token['role_id'] = $role_id;
        }
        if (!empty($site_id)) {
            $token['site_id'] = $site_id;
        }

        // system接口token不设置过期时间
        if($is_expire){
            $token['exp'] = 0;
        }

        JWT::$leeway = 86400;

        return base64_encode(JWT::encode($token, Registry::get("config")["salt"]));
    }

    /**
     * 验证jwt
     * @param string $authorization
     * @return object
     * @throws Exception
     */
    static public function checkJWT($authorization = ''){
        $authorization = str_replace("Auth ", "", $authorization);
        try{
            return JWT::decode(base64_decode($authorization), Registry::get("config")["salt"], array('HS256'));
        } catch (\Exception $exception){
            throw new Exception($exception->getMessage(), '401');
        }
    }

    /**
     * 传入access_token与uuid，匹配判断access_token是否正确
     * @param string $access_token access_token
     * @param string $uuid uuid 用户uuid
     * @return bool
     * @throws Exception
     */
    static public function chkAccessToken($access_token = '', $uuid = '')
    {
        $access_token = !empty($access_token) && is_string($access_token) ? trim($access_token) : '';
        $uuid = !empty($uuid) && is_string($uuid) ? trim($uuid) : '';
        //access_token不存在于缓存中
        Registry::get("redis")->select(0);
        $member_info = json_decode(Registry::get("redis")->get($access_token), true);
        if (Registry::get("redis")->get($access_token) === null || empty($access_token))
            throw new Exception(ErrorMsg::LOGIN_FIRST, ErrorMsg::LOGIN_FIRST_NO);
//            return new Exception("请先登录", "004");
        //验证access_token与uuid是否一致
        if ($member_info['uuid'] != $uuid)
            throw new Exception("请先登录", "005");

        /*$match_uuid = str_replace("uuid=", "", Util::decrypt($access_token, Registry::get("config")["api"]["md5"]["access_key"]));
        if($match_uuid != $uuid){
            return new Exception("uuid与token不匹配", "005");
        }*/

        return true;
    }
}
