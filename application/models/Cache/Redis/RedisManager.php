<?php

namespace models\Cache\Redis;


use models\Exception\Cache\CacheException;
use Yaf\Registry;

class RedisManager
{

    protected $_client;

    static public $_instance = null;

    public $_queue = [];

    /**
     * @return array
     */
    public function getQueue()
    {
        return $this->_queue;
    }

    /**
     * @param array $queue
     */
    public function setQueue($queue)
    {
        if (is_array($queue))
            $this->_queue = !empty($this->_queue) ? array_merge($this->_queue, $queue) : $this->_queue;
        else
            array_push($this->_queue, $queue);
    }


    static public function getInstance($options) {
        if (is_null(self::$_instance)){
            self::$_instance = new self($options);
        }

        return self::$_instance;
    }

    public function __construct($options = [])
    {
        if(!empty($options) && is_array($options))
            $this->_client = new \Redis();

        if ($this->_client->isConnected() === false) {
            try {
                $this->_client->connect(Registry::get('config')['redis']['master']['host'],
                    Registry::get('config')['redis']['master']['port']);

                $this->_client->auth(Registry::get('config')['redis']['master']['auth']);
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

    public function getClient(){
        return $this->_client;
    }

    public function genConditionQuery($groups = []){
        $cache_name = '';
        if(!empty($groups['groups']) && isset($groups['groupOp'])){
            foreach($groups['groups'] as $k => $groups_arr){
                $cache_name .= '(' . $this->genConditionQuery($groups_arr) . ')' . $groups['groupOp'];
//                    (! empty($cache_name) ? $groups['groupOp'] : '');
            }
        }
        if(!empty($groups['rules']) && isset($groups['groupOp'])){
//            if (empty($groups['groupOp'])){
//                exit(json_encode($groups));
//            }
            foreach($groups['rules'] as $index => $value_arr){
                if (in_array($value_arr['field'], ['created_at', 'updated_at', 'auction_time']))
                    $value_arr['data'] = date('Y-m-d_H_i_s', strtotime($value_arr['data']));
                if (strrpos($value_arr['data'], ' 00:00:00') !== false){
                    $cache_name .= $value_arr['field'] . $this->__getRealSymbol($value_arr['op']) .
                        substr($value_arr['data'], 0, strrpos($value_arr['data'], ' 00:00:00')) . $groups['groupOp'];
                }elseif (strrpos($value_arr['data'], ' 23:59:59') !== false){
                    $cache_name .= $value_arr['field'] . $this->__getRealSymbol($value_arr['op']) .
                        substr($value_arr['data'], 0, strrpos($value_arr['data'], ' 23:59:59')) . $groups['groupOp'];
                }else{
                    $str = $this->__getRealSymbol($value_arr['op']);
                    $str = strpos($str, '\'#str#\'') !== false ? str_replace('\'#str#\'', $value_arr['data'], $str) : $str . $value_arr['data'] ;
//                    $cache_name .= $value_arr['field'] . $this->__getRealSymbol($value_arr['op']) . $value_arr['data'] . $groups['groupOp'];
                    $cache_name .= $value_arr['field'] . $str . $groups['groupOp'];
                }
            }
            $cache_name = substr($cache_name, 0, strrpos($cache_name, $groups['groupOp']));
        }

        return empty($cache_name) ? '' : $cache_name;
    }

    private function __getRealSymbol($str = ''){
        switch($str){
            case 'eq':
                $real_symbol = '=';
                break;
            case 'ne':
                $real_symbol = '!=';
                break;
            case 'lt':
                $real_symbol = '<';
                break;
            case 'le':
                $real_symbol = '<=';
                break;
            case 'gt':
                $real_symbol = '>';
                break;
            case 'ge':
                $real_symbol = '>=';
                break;
            case 'cn':
                $real_symbol = "not like'#str#'";
                break;
            case 'nc':
                $real_symbol = "like'#str#'";
                break;
            case 'in':
                $real_symbol = "in('#str#')";
                break;
            case 'ni':
                $real_symbol = "notin('#str#')";
                break;
            default:
                $real_symbol = '';
                break;
        }
        return $real_symbol;
    }

    /*public function cleanModifiedCache($cache_name = ''){
        $cache_name = !empty($cache_name) ? trim($cache_name) : '';
        if(empty($cache_name)){
            return false;
        }

        $this->__client->del([$cache_name]);
        return true;
    }*/

    public function checkParam4Func($func_name = '', $args_array = []){
        $result = $exception_msg = $exception_code = false;
        $key = isset($args_array['key']) && !empty($args_array['key']) && is_string($args_array['key']) ?
            $args_array['key'] : '';
        $data = isset($args_array['data']) && !empty($args_array['data']) ? $args_array['data'] : '';
        switch ($func_name){
            case 'getHash':
                if(empty($key)){
                    $exception_msg = str_replace('%s', $key, CacheException::REDIS_HASH_KEY_IS_INVALID);
                    $exception_code = CacheException::REDIS_HASH_KEY_IS_INVALID_NO;
                }
//                $field = isset($args_array['field']) && !empty($args_array['field']) ? $args_array['field'] : '';
//                if(empty($field)){
//                    $exception_msg = str_replace('%s', $key, CacheException::REDIS_HASH_GET_FIELD_NOT_EXISTS);
//                    $exception_code = CacheException::REDIS_HASH_GET_FIELD_NOT_EXISTS_NO;
//                }
                break;
            case 'genHash':
                // redis hash key的类型与长度是否合法
                if(empty($key)){
                    $exception_msg = str_replace('%s', $key, CacheException::REDIS_HASH_KEY_IS_INVALID);
                    $exception_code = CacheException::REDIS_HASH_KEY_IS_INVALID_NO;
                }else if(strlen($key) > Registry::get('config')['redis']['limitation']['hash']['key']['len']){
                    $exception_msg = str_replace(
                        ['%s', '%d'],
                        [$key, Registry::get('config')['redis']['limitation']['hash']['key']['len']],
                        CacheException::REDIS_HASH_KEY_LEN_INVALID);
                    $exception_code = CacheException::REDIS_HASH_KEY_LEN_INVALID_NO;
                }
                // 判断array是否合法
                if(empty($data) || !is_array($data)){
                    $exception_msg = CacheException::REDIS_HASH_VALUE_MUST_BE_ARRAY;
                    $exception_code = CacheException::REDIS_HASH_VALUE_MUST_BY_ARRAY_NO;
                }
                break;
            case 'getString' || 'deleteString' || 'getKeysByPattern':
                // redis string key的类型是否合法
                if(empty($key)){
                    $exception_msg = str_replace('%s', $key, CacheException::REDIS_STRING_KEY_IS_INVALID);
                    $exception_code = CacheException::REDIS_STRING_KEY_IS_INVALID_NO;
                }
                break;
            case 'genString' || 'updateString':
                // redis string key的类型是否合法
                if(empty($key)){
                    $exception_msg = str_replace('%s', $key, CacheException::REDIS_STRING_KEY_IS_INVALID);
                    $exception_code = CacheException::REDIS_STRING_KEY_IS_INVALID_NO;
                }
                // 判断string是否合法
                if(empty($data) || ! is_string($data)){
                    $exception_msg = CacheException::REDIS_STRING_VALUE_IS_INVALID;
                    $exception_code = CacheException::REDIS_STRING_VALUE_IS_INVALID_NO;
                }
                break;
        }

        $result = $exception_msg === false && $exception_code === false ? $result : true;
        return [$result, $exception_msg, $exception_code];
    }
}
