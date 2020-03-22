<?php

namespace models\Service;

use ErrorMsg\Admin\ErrorTips;
use Yaf\Exception;
use Yaf\Registry;

class BaseService
{
    static private $_instance = null;

    static public function getInstance() {
        if (is_null(self::$_instance))
            self::$_instance = new self();

        return self::$_instance;
    }

    public function __construct()
    {

    }

    protected function _deletePagination(){
        $reflection_class = new \ReflectionClass($this);
        $method_name = '';
        foreach ($reflection_class->getProperties() as $property){
            if ('__list_sorted_set_cache_name_prefix' === $var_name = $property->getName()) {
                $method_name = 'get';
                $method_name .= array_reduce(explode('_', $var_name), function ($carry, $item) {
                    return $carry . (! empty($item) ? ucfirst($item) : ''); });

            }
        }

        $list_sorted_set_cache_name = $this->$method_name() . ':*';
        $res = Registry::get('redis_sorted_set')
            ->deleteSortedSet($list_sorted_set_cache_name);

        $res = Registry::get('redis_string')->getKeysByPattern($list_sorted_set_cache_name);
        if(is_array($res) && !empty($res))
            Registry::get('redis_string')->deleteString($res);

        return true;

        /*
        // 删除缓存中的列表SortedSet数据
        Registry::get('redis_sorted_set')
            ->deleteSortedSet($this->__list_sorted_set_cache_name_prefix . ':*');

        // 删除缓存中的列表meta数据
        $res = Registry::get('redis_string')->getKeysByPattern($this->__list_sorted_set_cache_name_prefix . ':*');
        if(is_array($res) && !empty($res)){
            Registry::get('redis_string')->deleteString($res);
        }
        */
    }

}