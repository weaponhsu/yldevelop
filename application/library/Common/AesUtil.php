<?php
namespace Common;


use Exception;

class AesUtil
{
    /**
     * var string $secret_key 加解密的密钥
     */
    protected $secret_key;

    /**
     * var string $iv 加解密的向量，有些方法需要设置比如CBC
     */
    protected $iv;

    /**
     * @var null 单例
     */
    static public $instance = null;

    /**
     * 单例
     * @param string $key 密钥
     * @param string $iv iv向量
     * @param string $cipher
     * @return AesUtil|null
     * @throws Exception
     */
    static public function getInstance($key, $iv = '', $cipher = 'AES-128-CBC') {
        if (is_null(self::$instance))
            self::$instance = new self($key, $iv, $cipher);

        return self::$instance;
    }

    public function setKey($key) {
        $this->secret_key = $key;
        return $this;
    }

    public function setIV($iv) {
        $this->iv = $iv;
        return $this;
    }

    /**
     * AesUtil constructor.
     * @param $key 密钥
     * @param string $iv vi向量
     * @param string $cipher
     * @throws Exception
     */
    public function __construct($key, $iv = '', $cipher = 'AES-128-CBC')
    {
        // key是必须要设置的
        $this->secret_key = isset($key) ? $key : '123';

        $this->cipher = $cipher ? $cipher : 'AES-128-CBC';
        $iv_length = openssl_cipher_iv_length($cipher);
        if ($iv_length === false)
            throw new Exception('无效cipher');

        $this->iv = empty($iv) ? openssl_random_pseudo_bytes($iv_length) : $iv;
    }

    /**
     * 加密
     * @param string $original_str
     * @param int $options
     * @return string
     * @throws Exception
     */
    public function encrypt($original_str = '', $options = 0) {
        try {
            if (empty($original_str))
                throw new Exception(AbstractErrorMsg::ENCRYPT_STRING_IS_EMPTY, AbstractErrorMsg::ENCRYPT_STRING_IS_EMPTY_NO);

            $encrypt = openssl_encrypt($original_str, $this->cipher, $this->secret_key, $options, $this->iv);
            return $encrypt;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * 解密
     * @param string $encrypt_str
     * @param int $options
     * @return string
     * @throws Exception
     */
    public function decrypt($encrypt_str = '', $options = 0) {
        try {
            if (empty($encrypt_str))
                throw new Exception(AbstractErrorMsg::DECRYPT_STRING_IS_EMPTY, AbstractErrorMsg::DECRYPT_STRING_IS_EMPTY_NO);

            $decrypted = openssl_decrypt($encrypt_str, $this->cipher, $this->secret_key, $options, $this->iv);

//            exit(json_encode([$encrypt_str, $decrypted, $this->secret_key, $this->iv]));
            return trim($decrypted);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
