<?php

namespace models\Cache\Redis;

use ErrorMsg\AbstractErrorMsg;
use models\Cache\SortedSetCacheImpl;
use models\Exception\Cache\RedisSortedSetException;
use Yaf\Exception;
use Yaf\Registry;


class RedisSortedSetManager /*extends RedisManager*/ implements SortedSetCacheImpl
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
     * @return RedisSortedSetManager|null
     */
    static public function getInstance(/*$options = []*/RedisManager $redisManager){
        if(is_null(self::$instance)){
            self::$instance = new self($redisManager);
        }
        return self::$instance;
    }

    public function __construct(/*$options = []*/RedisManager $redisManager){
//        parent::__construct();
//        parent::__construct($options);
//        var_dump($this);
//        $this->setClient($options);
        $this->redis_manager = $redisManager;
        $this->db = isset(Registry::get('config')['redis']['sortedSet']['db']) ? Registry::get('config')['redis']['sortedSet']['db'] : 1;
        $this->_client = $redisManager->getClient();
    }

    public function check() {
        try {
            $this->_client->ping();
        } catch (\Exception $e) {

        } finally {
            $this->_client->auth($this->_client->getAuth());
        }
    }

    /**
     * 生成SortedSet
     * @param string $key
     * @param array $value
     * @param int $expire
     * @return array|void
     * @throws RedisSortedSetException
     */
    public function genSortedSet($key = '', $value = [], $expire = 86400){
        if (empty($key))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY, RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY_NO);
        if (! is_array($value) && empty($value))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_SORTED_SET_INVALID_VALUE, RedisSortedSetException::REDIS_SORTED_SET_INVALID_VALUE_NO);

        $this->check();

        $this->_client->select($this->db);
//        $this->_client->watch($key);
        // 开启pipeline
//        $this->_client->multi();
        $this->_client->pipeline();

        foreach ($value as $k => $v){
            $this->_client->zAdd($key, [], $k+1, $v);
        }

//        $this->_client->unwatch();
        return $this->_client->exec();
    }

    /**
     * 获取SortedSet
     * @param string $key
     * @param int $start_pos
     * @param int $end_pos
     * @param string $order
     * @return array
     * @throws RedisSortedSetException
     */
    public function getSortedSet($key = '', $start_pos = 0, $end_pos = -1, $order='asc'){
        if (empty($key))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY, RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY_NO);

        if (! in_array($order, ['desc', 'asc']))
            throw new RedisSortedSetException(RedisSortedSetException::INVALID_ORDER_PARAM, RedisSortedSetException::INVALID_ORDER_PARAM_NO);

        $this->check();

        $this->_client->select($this->db);
        if ($order == 'asc')
            $res = $this->_client->zrange($key, $start_pos, $end_pos);
        else
            $res =$this->_client->zRevRange($key, $start_pos, $end_pos);

        return $res;
    }

    /**
     * 返回指定redis key下的member个数
     * @param string $key
     * @return int
     * @throws RedisSortedSetException
     */
    public function getSortedSetLength($key = ''){
        if(empty($key))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY, RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY_NO);

        $this->check();

        $this->_client->select($this->db);

        return $this->_client->zcard($key);
    }

    /**
     * 获取指定list中指定元素的score
     * @param string $key
     * @param string $member
     * @return bool|float
     * @throws RedisSortedSetException
     */
    public function getScoreByMember($key = '', $member = ''){
        if (empty($key))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY, RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY_NO);
        if (empty($member))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_MEMBER_IS_EMPTY, RedisSortedSetException::REDIS_MEMBER_IS_EMPTY_NO);

        if (! $this->getSortedSetLength($key)) {
            $msg = str_replace('%key%', $key, RedisSortedSetException::REDIS_SORTED_SET_NOT_EXISTS);
            throw new RedisSortedSetException($msg, RedisSortedSetException::REDIS_SORTED_SET_NOT_EXISTS_NO);
        }

        return $this->_client->zScore($key, $member);
    }

    /**
     * 修改指定list中指定元素的score
     * @param string $key
     * @param string $member
     * @param int $score
     * @return int
     * @throws RedisSortedSetException
     */
    public function modifyScoreByMember($key = '', $member = '', $score = 0){
        if (empty($key))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY, RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY_NO);
        if (empty($member))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_MEMBER_IS_EMPTY, RedisSortedSetException::REDIS_MEMBER_IS_EMPTY_NO);

        if (! $this->getSortedSetLength($key)) {
            $msg = str_replace('%key%', $key, RedisSortedSetException::REDIS_SORTED_SET_NOT_EXISTS);
            throw new RedisSortedSetException($msg, RedisSortedSetException::REDIS_SORTED_SET_NOT_EXISTS_NO);
        }

        return $this->_client->zAdd($key, [], $score, $member);
    }

    /**
     * 设置有效期
     * @param $key
     * @param int $expire
     * @return bool
     * @throws RedisSortedSetException
     */
    public function setExpire($key, $expire = 86400){
        if (empty($key))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY, RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY_NO);

        if (! $this->getSortedSetLength($key)) {
            $msg = str_replace('%key%', $key, RedisSortedSetException::REDIS_SORTED_SET_NOT_EXISTS);
            throw new RedisSortedSetException($msg, RedisSortedSetException::REDIS_SORTED_SET_NOT_EXISTS_NO);
        }

        return $this->_client->expire($key, $expire);
    }

    /**
     * 批量获取sortedSet的key
     * @param string $key
     * @return array
     * @throws RedisSortedSetException
     */
    public function getKeysByPattern($key = ''){
        if(empty($key) || ! is_string($key))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY, RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY_NO);

        $this->check();

        $this->_client->select($this->db);

        return $this->_client->keys($key);
    }

    /**
     * 删除指定redis key下的指定member
     * @param string $key
     * @param string $member
     * @return array|bool|null
     * @throws Exception
     */
    public function deleteSortedSetItem($key = '', $member = ''){
//        exit(json_encode(func_get_args()));
        if(empty($key) || empty($member))
            return false;

        // key的pattern存在
        $keys_array = $this->_client->keys($key);
        if(empty($keys_array)) return null;

        $this->_client->select($this->db);
        $this->_client->watch($keys_array);
        // 开启pipeline
        $this->_client->multi();
        $this->_client->pipeline();
        foreach ($keys_array as $redis_keys){
            $this->_client->zrem($redis_keys, $member);
        }
        $del_res = $this->_client->exec();
        $this->_client->unwatch();

        // 删除成功时，返回与redis_keys长度一致的一维数组，数组里的值为1表示删除成功，为0时表示删除失败
        // 现阶段不管删除成功与否，都返回true，若加入watch方法后，需根据成功与否，给调用者一个做后续逻辑的判断的依据
        $return_arr = [];
        if(count($del_res) === count($keys_array)){
            foreach ($del_res as $idx => $delete_res){
                $return_arr[$keys_array[$idx]] = $delete_res;
            }
        }

        if(empty($return_arr))
            throw new Exception(AbstractErrorMsg::REDIS_KEY_DELETE_FAILURE, AbstractErrorMsg::REDIS_KEY_DELETE_FAILURE_NO);
        else
            return $return_arr;
    }

    /**
     * 根据list的redis key，删除与其相关的所有保存list的sortedSet
     * @param string $key 传入一个表的list的key(格式: 表名:list:查询条件的url string:页面:每页显示条数:排序字段:排序方式)
     * @return array|void
     * @throws RedisSortedSetException
     */
    public function deleteSortedSet($key = ''){
        if(empty($key))
            throw new RedisSortedSetException(RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY, RedisSortedSetException::REDIS_KEY_IS_NOT_EMPTY_NO);

        $this->check();

        $this->_client->select($this->db);
        // 截取表的list的key，获得pattern，如：表名:list:查询条件的url string:*
        if(strpos($key, ':') !== false){
            $key_arr = explode(':', $key);
            $pattern_keys_arr = array_splice($key_arr, 0, 2);
            $pattern_keys_arr = array_merge($pattern_keys_arr, ['*']);
            // key的pattern存在
            $keys_array = $this->_client->keys(implode(':', $pattern_keys_arr));
        }
        // 传入的如果是不带:的key，则直接在尾部拼接*
        else{
            $keys_array = $this->_client->keys($key . '*');
        }

        $del_res = null;
        // 缓存存在
        if (! empty($keys_array)) {
            $this->_client->pipeline();
            foreach ($keys_array as $redis_keys){
                $this->_client->del($redis_keys);
            }
            $del_res = $this->_client->exec();
        }

        return $del_res;
    }
}
