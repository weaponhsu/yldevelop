<?php

namespace models\Cache\Redis;

use models\Cache\StringCacheImpl;
use models\Exception\Cache\CacheException;
use models\Exception\Cache\RedisStringException;
use Yaf\Registry;


class RedisStringManager /*extends RedisManager*/ implements StringCacheImpl
{
    /**
     * 单例实例
     */
    static public $instance = null;

    public $redis_manager = null;

    protected $_client = null;

    protected $db = null;

    /**
     * @param RedisManager $redisManager
     * @return null
     */
    static public function getInstance(RedisManager $redisManager){
        if(is_null(static::$instance)){
            self::$instance = new self($redisManager);
        }
        return self::$instance;
    }

    public function __construct(RedisManager $redisManager){
        $this->redis_manager = $redisManager;
        $this->db = isset(Registry::get('config')['redis']['string']['db']) ? Registry::get('config')['redis']['string']['db'] : 3;
        $this->_client = $redisManager->getClient();
    }

    public function getClient() {
        return $this->_client;
    }

    public function check() {
        try {
            $this->_client->ping();
        } catch (\Exception $e) {
            $this->_client->auth($this->_client->getAuth());
        }
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $expire
     * @return array|void|null
     * @throws RedisStringException
     */
    public function genString($key='', $value='', $expire = 86400){
        if(empty($key) || (!is_array($key) && !is_string($key)))
            throw new RedisStringException(RedisStringException::REDIS_KEY_IS_INVALID, RedisStringException::REDIS_KEY_IS_INVALID_NO);

        if(empty($value) || (!is_array($value) && !is_string($value)))
            throw new RedisStringException(RedisStringException::REDIS_STRING_VALUE_IS_INVALID, RedisStringException::REDIS_STRING_VALUE_IS_INVALID_NO);

        if(is_array($key) && is_array($value) && count($key) !== count($value))
            throw new RedisStringException(RedisStringException::REDIS_KEY_VALUE_BOTH_NO_ARRAY, RedisStringException::REDIS_KEY_VALUE_BOTH_NO_ARRAY_NO);

        $this->check();

        // redis.master.auth
        $this->_client->select($this->db);
        if(is_array($key) && is_array($value)){
            $this->_client->pipeline();
            foreach ($key as $idx => $real_key){
                if(isset($value[$idx])){
                    $this->_client->setnx($real_key, $value[$idx]);
                    $this->_client->expire($real_key, $expire);
                }
            }
            $res = $this->_client->exec();
        }
        else{
            $this->_client->setnx($key, $value);
            $this->_client->expire($key, $expire);
        }
    }

    /**
     * @param string $key
     * @return array|bool|mixed|string
     * @throws RedisStringException
     */
    public function getString($key = ''){
        if(empty($key) || (! is_string($key) && ! is_array($key)))
            throw new RedisStringException(RedisStringException::REDIS_KEY_IS_NOT_EMPTY, RedisStringException::REDIS_KEY_IS_NOT_EMPTY_NO);

        $this->check();

        $this->_client->select($this->db);
        if(is_array($key))
            return $this->_client->mget($key);
        else
            return $this->_client->get($key);
    }

    /**
     * 更新redis string
     * @param string $key
     * @param string $value
     * @param int $expire
     * @return array|void|null
     * @throws RedisStringException
     */
    public function updateString($key = '', $value = '', $expire = 86400){
        if(empty($key) || (!is_array($key) && !is_string($key)))
            throw new RedisStringException(RedisStringException::REDIS_KEY_IS_INVALID, RedisStringException::REDIS_KEY_IS_INVALID_NO);

        if(empty($value) || (!is_array($value) && !is_string($value)))
            throw new RedisStringException(RedisStringException::REDIS_STRING_VALUE_IS_INVALID, RedisStringException::REDIS_STRING_VALUE_IS_INVALID_NO);

        if(is_array($key) && is_array($value) && count($key) !== count($value))
            throw new RedisStringException(RedisStringException::REDIS_KEY_VALUE_BOTH_NO_ARRAY, RedisStringException::REDIS_KEY_VALUE_BOTH_NO_ARRAY_NO);

        $this->check();

        // key对应value的二维数组[[key1 => value1, key2 => value2, ...]]
        $updated = $updated_key = [];
        if(is_array($key) && is_array($value)){
            foreach ($key as $idx => $real_key){
                // key与value的值一一对应，且key存在，旧值不等于新值，则将key与value做成一个数组，push到updated数组中
                if(isset($value[$idx]) && /*$this->_client->exists($real_key) &&*/
                    $value[$idx] != $this->_client->get($real_key)){
                    $updated[$real_key] = $value[$idx];
                    array_push($updated_key, $real_key);
                }
            }
        }
        else{
            // key存在，旧值不等于新值，将key与value做成一个数组，push到updated数组中
            if($this->_client->exists($key)){
                $updated[$key] = $value;
                array_push($updated_key, $key);
            }
        }

        $res = null;
        if($updated && $updated_key){
            $this->_client->select($this->db);
            // 开启pipeline
            $this->_client->pipeline();
            foreach ($updated as $real_key => $val)
                $this->_client->set($real_key, $val, $expire);

            $res = $this->_client->exec();
        }

        return $res;
    }

    /**
     * 删除指定的key
     * @param string $key 删除单个时key为字符串，批量删除时key为数组
     * @return int 删除成功后，返回一个int。若key是个字符串，则返回1；若key是个数组，则将key数组下成功删除的元素的个数返回。
     * @throws RedisStringException
     */
    public function deleteString($key = ''){
        if(empty($key) || (! is_array($key) && ! is_string($key)))
            throw new RedisStringException(RedisStringException::REDIS_KEY_IS_NOT_EMPTY, RedisStringException::REDIS_KEY_IS_NOT_EMPTY_NO);

        $this->check();

        $this->_client->select($this->db);

        return $this->_client->del(is_array($key) ? $key : [$key]);
    }

    /**
     * @param string $key
     * @return array
     * @throws RedisStringException
     */
    public function getKeysByPattern($key = ''){
        if(empty($key) || ! is_string($key))
            throw new RedisStringException(RedisStringException::REDIS_KEY_IS_NOT_EMPTY, RedisStringException::REDIS_KEY_IS_NOT_EMPTY_NO);

        $this->check();

        $this->_client->select($this->db);

        return $this->_client->keys($key);

    }

    /**
     * 设置有效期
     * @param string|array $key 为字符串时；表示设置单个key的时间；为数组时，为批量设置key的有效期
     * @param int $expire
     * @return array|bool|int 单个key的时间返回int,批量有效期设置时返回数组(与key一一对应,0表示设置有效期失败,1表示设置有效期成功)
     */
    public function setExpire($key, $expire = 86400){
        // key为空，或key不存在
        if(empty($key) || (!is_string($key) && !is_array($key)))
            return false;

        $this->_client->select($this->db);
        if(is_array($key)){
            $return = [];
            foreach ($key as $real_key){
                $return[] = $this->_client->exists($real_key) ? $this->_client->expire($real_key, $expire) : 0;
            }
        }else{
            $return = $this->_client->expire($key, $expire);
        }
        return $return;
    }

    public function genConditionQuery($groups = []){
        return $this->redis_manager->genConditionQuery($groups);
    }

}
