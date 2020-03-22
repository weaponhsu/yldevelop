<?php

namespace models\Service;

use Yaf\Registry;
use models\DAO\RuleModel;
use models\Exception\DAO\ModelDriverException;;
use models\Exception\DAO\ModelException;;
use models\Exception\DAO\ModelReflectionException;;
use models\Exception\DAO\ModelSqlException;;
use models\Exception\Service\ServiceException;;
use models\Exception\Transformer\TransformerException;;
use models\Transformer\RuleTransformer;;


class RuleService {
    /** 
     * 列表缓存sortedSet
     */
    private $__list_sorted_set_cache_name_prefix = 'rule:list';

    /** 
     * 单条数据缓存string
     */
    private $__single_string_cache_name_prefix = 'admin:rule';

    /** 
     * 单例
     */
    static public $instance = null;

    /**
     * RuleService constructor.
     */
    static public function getInstance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * ruleService constructor.
     */
    public function __construct() {}

    /**
     * 传入查询条件，条件可以为array(参考getList的condition入参)亦可为integer(主键编号)获取单条数据
     *
     * getOne. 
     * @param array $condition 查询条件
     * @param bool $cache 是否删除缓存
     * @param string $cache_name 缓存名称
     * @param int $expire redis有效期
     * @return array|mixed|null
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws TransformerException
     */
    public function getOne($condition = [], $cache = false, $cache_name = "", $expire = 86400) {
        // 查询数据库，写入缓存变量 false表示不执行，true表示要执行
        $select_db = $is_into_redis = false;
        $cache_name = $cache_name === '' ? false : $cache_name;
        $redis_is_exists = false;

        // 使用缓存，且缓存名存在，检查缓存
        if($cache === true && ! is_string($cache_name)) {
            $cache_name = strpos($this->__single_string_cache_name_prefix, (string)$cache_name) === false ? 
            $this->__single_string_cache_name_prefix . ':' . $cache_name : $cache_name;
            $redis_is_exists = Registry::get('redis_string')->getString($cache_name);
        }

        if ($cache === true && empty($cache_name))
            throw new ServiceException(ServiceException::SERVICE_CACHE_NAME_IS_EMPTY, ServiceException::SERVICE_CACHE_NAME_IS_EMPTY_NO);

        // 缓存不存在 查询数据库为true
        if ($redis_is_exists === false) $select_db = true;
        // 缓存存在 直接json_decode缓存中的数据库
        else $redis_is_exists = json_decode($redis_is_exists, true);

        // 需要查询数据库
        if($select_db === true){
            // $condition是数组 多条件查询 反之 直接使用主键查询
            $data_from_db = is_array($condition) ? RuleModel::getInstance()->findOneBy($condition) : 
                RuleModel::getInstance()->find($condition);

            $is_into_redis = $cache;

            $rule_transformer = new RuleTransformer($data_from_db);
            $redis_is_exists = $rule_transformer->SingleData();
        }

        if($is_into_redis === true)
            Registry::get('redis_string')->genString($cache_name, json_encode($redis_is_exists), $expire);

        return $redis_is_exists;
    }

    /**
     * 传入查询条件，当前页，每页显示条数，排序字段，排序方式，获取列表数据
     *
     * getList. 
     * @param int $page 查询条件
     * @param int $page_size 每页显示条数
     * @param string $sort 排序方式
     * @param string $order 排序字段
     * @param array $condition 查询条件
     * @param bool $cache 是否删除缓存
     * @param string $cache_name 缓存名称
     * @param int $expire redis有效期
     * @return array|mixed
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws TransformerException
     */
    public function getList($page = 1, $page_size = 20, $sort = "", $order = "", $condition = [], $cache = false, $cache_name = "", $expire = 86400) {
        $select_db = $is_into_redis = false;
        $cache_name = $cache_name === '' ? false : $cache_name;
        $redis_is_exists = $full_data = [];
        $result_from_db = false;

        // 需要使用缓存 但没有传入缓存名
        if ($cache === true && empty($cache_name))
            throw new ServiceException(ServiceException::SERVICE_CACHE_NAME_IS_EMPTY, ServiceException::SERVICE_CACHE_NAME_IS_EMPTY_NO);

        // 使用缓存，且缓存名存在，读取缓存
        if ($cache === true && is_string($cache_name)) {
            $redis_is_exists = Registry::get('redis_sorted_set')->getSortedSet($cache_name);
            $string_redis_key_arr = [];
            array_walk($redis_is_exists, function ($val, $idx) use (&$string_redis_key_arr) {
                array_push($string_redis_key_arr, $this->__single_string_cache_name_prefix . ':' . $val);
            });
            if (!empty($string_redis_key_arr)) {
                $full_data = [
                    'data' => Registry::get('redis_string')->getString($string_redis_key_arr),
                    'meta' => json_decode(Registry::get('redis_string')->getString($cache_name), true)
                ];

                // 缓存数据读取失败
                if ($full_data['data'] === false || $full_data['meta'] === false)
                    $redis_is_exists = [];
            }
        }
        // 不使用缓存或缓存不存在 select_db为true
        if (empty($redis_is_exists))
            $select_db = true;
        // 读取数据库数据
        if ($select_db === true)
            $result_from_db = RuleModel::getInstance()->__set('page', $page)->__set('page_size', $page_size)
                ->setOrderBy(['order' => $order, 'sort' => $sort])->findBy($condition);
        // 数据库查无结果 或 select_db === false
        // 从数据库中查询出结果了
        if ($result_from_db instanceof RuleModel) {
            $transformer = new ruleTransformer($result_from_db);
            // 根据是否使用缓存来获取数据
            $full_data = $transformer->BackEndData();
            if ($cache === true)
                $redis_is_exists = ['data' => array_column($full_data['data'], 'id')];
            $is_into_redis = $cache;
        }

        // 有正确数据，且需要写入redis的sortedSet
        if ($is_into_redis === true && $redis_is_exists && isset($full_data['meta'])) {
            Registry::get('redis_sorted_set')->genSortedSet($cache_name, $redis_is_exists['data'], $expire);
            Registry::get('redis_string')->genString($cache_name, json_encode($full_data['meta']), $expire);
        }

        // 读取缓存
        // 并按照sortedSet的顺序，将mget的结果一个一个写进redis_is_exists['data']里
        // 并删除掉多余无用的redis_is_exists的键
        if($cache){
            $batch_into_redis_key = $batch_into_redis_value = [];

            // 遍历单条数据 若单条数据缓存不存在 则调用getOne方法获取数据并复制给$detail_in_redis
            foreach ($full_data['data'] as $idx => $single_data) {
                // 单条数据不存在
                if ($single_data === false) {
                    if (! isset($redis_is_exists[$idx]))
                        throw new ServiceException(ServiceException::SERVICE_GET_LIST_WITH_REDIS_IDX_NOT_EXISTS, ServiceException::SERVICE_GET_LIST_WITH_REDIS_IDX_NOT_EXISTS_NO);
                    $redis_is_exists['data'][$idx] = $this->getOne($redis_is_exists[$idx], true, (int)$redis_is_exists[$idx]);
                } else if (is_array($single_data)) {
                    $redis_is_exists['data'][$idx] = $single_data;
                    array_push($batch_into_redis_key, strpos($this->__single_string_cache_name_prefix, $cache_name) === false ? 
                    $this->__single_string_cache_name_prefix . ':' . $single_data['id'] : $single_data['id']);
                    array_push($batch_into_redis_value, json_encode($single_data));
                } else { 
                    $redis_is_exists['data'][$idx] = json_decode($single_data, true);
                }
                unset($redis_is_exists[$idx]);
            }
            $redis_is_exists['meta'] = $full_data['meta'];
            // array_multisort(array_column($redis_is_exists['data'], 'index'), SORT_ASC, $redis_is_exists['data']);
            if (!empty($batch_into_redis_key) && !empty($batch_into_redis_value))
                Registry::get("redis_string")->genString($batch_into_redis_key, $batch_into_redis_value);
        } else
            $redis_is_exists = $full_data;

        return $redis_is_exists;
    }

    /**
     * 插入记录
     *
     * create. 
     * @param string $name 权限名称
     * @param int $stats 状态(0为否,1为是,默认1)
     * @param int $created_by 创建者
     * @param string $created_at 创建时间
     * @param int $updated_by 更新者
     * @param string $updated_at 更新时间
     * @param bool $cache 是否删除缓存
     * @param string $cache_name 缓存名称
     * @param int $expire redis有效期
     * @return array
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ModelException
     * @throws TransformerException
     */
    public function create($name = "", $stats = 0, $created_by = 0, $created_at = "", $updated_by = 0, $updated_at = "", $cache = false, $cache_name = "", $expire = 86400) {
        $is_into_redis = $delete_list_sorted_set = false;

        $rule_model = RuleModel::getInstance();
        if (! method_exists($rule_model, '__set'))
            throw new ModelReflectionException(ModelException::THERE_IS_NO_SET_METHOD, ModelException::THERE_IS_NO_SET_METHOD_NO);
        if (! property_exists($rule_model, 'primary_key_arr'))
            throw new ModelReflectionException(ModelException::THERE_IS_NO_PRIMARY_KEY_ARR, ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_NO);
        // 若primary_key是自增字段，则清空model的primary_key属性的值
        $primary_key = null;
        foreach ($rule_model->primary_key_arr as $primary_key) {
            if (property_exists($rule_model, 'auto_increment_key_arr') && in_array($primary_key, $rule_model->auto_increment_key_arr))
                $rule_model->__set($primary_key, null);
        }

        // 插入数据库
        $new_rule_primary_key = $rule_model
            ->__set('name', $name)
            ->__set('stats', $stats)
            ->__set('created_by', $created_by)
            ->__set('updated_by', $updated_by)
            ->insert();

        if (! is_null($primary_key))
            $rule_model->__set($primary_key, $new_rule_primary_key);

        // 插入成功，生成创建时间，更新时间，登录次数 生成返回用数据
        $datetime_now = date('Y-m-d H:i:s', time());
        $rule_model->__set('created_at', $datetime_now);
        $rule_model->__set('updated_at', $datetime_now);
        $transformer = new RuleTransformer(RuleModel::getInstance());
        $data_from_storage = $transformer->SingleData();

        // 需要使用缓存 is_into_redis为true delete_list_sorted_set为true
        if($cache === true){
            $cache_name = $this->__single_string_cache_name_prefix . ':' . $new_rule_primary_key;
            $is_into_redis = $delete_list_sorted_set = true;
        }

        // is_into_redis为true 新增的会员数据写入redis
        if($is_into_redis === true)
            Registry::get('redis_string')->genString($cache_name, json_encode($data_from_storage), $expire);
        // 需要删除列表的sortedSet的相关数据
        if($delete_list_sorted_set === true) {
            // 删除缓存中的列表SortedSet数据
            Registry::get('redis_sorted_set')->deleteSortedSet($this->__list_sorted_set_cache_name_prefix . ':*');

            // 删除缓存中的列表meta数据
            $res = Registry::get('redis_string')->getKeysByPattern($this->__list_sorted_set_cache_name_prefix . ':*');
            if(is_array($res) && !empty($res))
                Registry::get('redis_string')->deleteString($res);
        }

        return $data_from_storage;
    }

    /**
     * 更新记录
     *
     * update. 
     * @param array $update_column ['column1' => 'new_value1', 'column2' => 'new_value2', ...]
     * @param string $primary_key primary_key
     * @param bool $cache 是否删除缓存
     * @param string $cache_name 缓存名称
     * @param int $expire redis有效期
     * @return array|mixed|null
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws TransformerException
     */
    public function update($update_column = [], $primary_key = "", $cache = false, $cache_name = "", $expire = 86400) {
        if(empty($primary_key))
            throw new ServiceException(ServiceException::SERVICE_UPDATE_ID_EMPTY, ServiceException::SERVICE_UPDATE_ID_EMPTY_NO);
        if(empty($update_column) || ! is_array($update_column))
            throw new ServiceException(ServiceException::SERVICE_UPDATE_INVALID_COLUMN_ARR, ServiceException::SERVICE_UPDATE_INVALID_COLUMN_ARR_NO);

        // is_into_redis 写入redis 需要使用redis但redis不存在时会为true，反之为false
        // update_redis 更新redis 需要使用redis且redis存在时为true，反之为false
        // delete_list_sorted_set 删除列表sortedSet与列表meta的string 需要使用redis且redis存在时为true，反之为false
        // select_db 查询数据库
        $is_into_redis = $update_redis = $select_db = $delete_list_sorted_set = false;
        $redis_is_exists = null;

        // 需要使用缓存 但没有传入缓存名
        if($cache === true && empty($cache_name))
             throw new ServiceException(ServiceException::SERVICE_CACHE_NAME_IS_EMPTY, ServiceException::SERVICE_CACHE_NAME_IS_EMPTY_NO);

         // 需要使用缓存
        if ($cache === true && $cache_name) {
            $cache_name = $this->__single_string_cache_name_prefix . ':' . $cache_name;
            $redis_is_exists = Registry::get('redis_string')->getString($cache_name);
        }
        // 不使用缓存
        else $select_db = true;

        // 缓存不存在 查询数据库为true 写入redis为true
        if ($redis_is_exists === null)
            $select_db = $is_into_redis = true;
        // 缓存存在 直接json_decode缓存中的数据库 更新redis为true
        else {
            $redis_is_exists = json_decode($redis_is_exists, true);
            $update_redis = $delete_list_sorted_set = true;
        }

        // 实例化 rule_model
        $rule_model = RuleModel::getInstance();
        foreach ($update_column as $column_name => $value) {
            $rule_model->__set($column_name, $value);
            if ($update_redis === true)
                $redis_is_exists[$column_name] = $value;
        }
        // 修改数据库
        $rule_model->__set(implode('', $rule_model->primary_key_arr), $primary_key)->update();

        // 不需要使用缓存 或缓存不存在时 读取数据库
        // 之所以再从数据库中获取一边，是为了返回给调用者一个rule
        if ($select_db === true) {
            // 直接使用主键查询
            $data_from_db = $rule_model->find($primary_key);

            $is_into_redis = $cache;

            $rule_transformer = new RuleTransformer($data_from_db);
            $redis_is_exists = $rule_transformer->SingleData();
        }
        // 需要删除列表的sortedSet的相关数据
        if($delete_list_sorted_set === true) {
            // 删除缓存中的列表SortedSet数据
            Registry::get('redis_sorted_set')->deleteSortedSet($this->__list_sorted_set_cache_name_prefix . ':*');

            // 删除缓存中的列表meta数据
            $res = Registry::get('redis_string')->getKeysByPattern($this->__list_sorted_set_cache_name_prefix . ':*');
            if(is_array($res) && !empty($res))
                Registry::get('redis_string')->deleteString($res);
        }

        if ($is_into_redis === true)
            Registry::get('redis_string')->genString($cache_name, json_encode($redis_is_exists), $expire);

        if ($update_redis === true)
            Registry::get('redis_string')->updateString($cache_name, json_encode($redis_is_exists), $expire);

        if ($update_redis === true || $is_into_redis === true)
            $redis_is_exists = Registry::get('redis_string')->getString($cache_name);

        return $redis_is_exists;
    }

    /**
     * 删除记录
     *
     * delete. 
     * @param string $primary_key primary_key
     * @param bool $cache 是否删除缓存
     * @param string $cache_name 缓存名称
     * @param int $expire redis有效期
     * @return bool
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ServiceException
     * @throws ModelException
     */
    public function delete($primary_key = "", $cache = false, $cache_name = "", $expire = 86400) {
        if(empty($primary_key))
            throw new ServiceException(ServiceException::SERVICE_DELETE_ID_EMPTY, ServiceException::SERVICE_DELETE_ID_EMPTY_NO);

        // 删除缓存的结果 缓存不存在或不删除缓存为null 缓存删除成功为1 缓存删除失败为0
        $delete_from_db = null;
        // 需要使用缓存 但没有传入缓存名
        if ($cache === true && empty($cache_name))
            throw new ServiceException(ServiceException::SERVICE_CACHE_NAME_IS_EMPTY, ServiceException::SERVICE_CACHE_NAME_IS_EMPTY_NO);
        // 需要使用缓存
        if ($cache === true && $cache_name) {
            $cache_name = $this->__single_string_cache_name_prefix . ':' . $cache_name;

            // 从缓存中读取要删除的单条数据
            Registry::get('redis_string')->deleteString($cache_name);

            // 删除缓存中的列表SortedSet数据
            Registry::get('redis_sorted_set')->deleteSortedSet($this->__list_sorted_set_cache_name_prefix . ':*');

            // 删除缓存中的列表meta数据
            $res = Registry::get('redis_string')->getKeysByPattern($this->__list_sorted_set_cache_name_prefix . ':*');
            if (is_array($res) && !empty($res))
                Registry::get('redis_string')->deleteString($res);

            $delete_from_db = true;
        } else
            $delete_from_db = true;

        // 缓存删除成功 或不使用缓存 或缓存不存在
        if ($delete_from_db === true)
            // 删除数据库
            RuleModel::getInstance()->__set(RuleModel::getInstance()->primary_key_arr[0], $primary_key)->delete();

        return true;
    }

    /**
     * 批量插入
     *
     * batchInsert. 
     * @param array $arr 传入的参数数组
     * @return array|mixed
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     * @throws ServiceException
     */
    public function batchInsert($arr = []) {
        $array = !empty($arr) && is_array($arr) ? $arr : '';
        if(empty($array))
            throw new ServiceException(ServiceException::SERVICE_BATCH_INSERT_RETURN_FALSE,
                ServiceException::SERVICE_BATCH_INSERT_RETURN_FALSE_NO);

        $rule_model = RuleModel::getInstance();

        $rule_model->__set('data', $arr)->batchInsert();
        // 获取列表缓存名
        $list_cache_name = $this->__list_sorted_set_cache_name_prefix . ':*';
        $list_cache_name_arr = Registry::get('redis_sorted_set')->getKeysByPattern($list_cache_name);

        // 删除列表缓存
        if (! empty($list_cache_name_arr)) {
            Registry::get('redis_sorted_set')->deleteSortedSet($list_cache_name);
            Registry::get('redis_string')->deleteString($list_cache_name_arr);
        }
        return true;
    }

    /**
     * 批量删除
     *
     * batchUpdate. 
     * @param array $update_column 666
     * @param bool $cache 是否删除缓存
     * @param int $expire redis有效期
     * @return bool|string
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     * @throws ModelReflectionException
     * @throws ServiceException
     * @throws TransformerException
     */
    public function batchUpdate($update_column = [], $cache = false, $expire = 86400) {
        if (empty($update_column) || ! is_array($update_column))
            throw new ServiceException(ServiceException::SERVICE_BATCH_UPDATE_DATA_EMPTY, ServiceException::SERVICE_BATCH_UPDATE_DATA_EMPTY_NO);
        $cache_name_arr = $redis_is_exists = $update_redis_data = [];
        $into_redis = false;

        $rule_model = RuleModel::getInstance();
        // 更新数据库
        $rule_model->__set('data', $update_column)->genBatchUpdateSql();

        // 需要缓存
        if ($cache === true) {
            $cache_name = $this->__single_string_cache_name_prefix . ':*';
            $cache_name_arr = Registry::get('redis_string')->getKeysByPattern($cache_name);
        }

        // 缓存名读取成功
        if (! empty($cache_name_arr)) {
            $redis_is_exists = Registry::get('redis_string')->getString($cache_name_arr);
            if(is_array($redis_is_exists))
            array_walk($redis_is_exists, function ($json_encode_string, $idx) use(&$redis_is_exists){
                $redis_is_exists[$idx] = json_decode($json_encode_string, true);
            });
        }
        // 缓存不存在 或不需要读取缓存
        else { 
            $redis_is_exists = $this->getList(1, count($update_column), 'desc', $rule_model->primary_key_arr[0], [
                'groupOp' => 'AND', 'rules' => [
                    ['field' => $rule_model->primary_key_arr[0], 'op' => 'in', 'data' => implode(',', array_column($update_column, $rule_model->primary_key_arr[0]))]]
            ]);
            $into_redis = $cache;
            $redis_is_exists = $redis_is_exists['data'];
        }

        // 缓存读取成功，修改对应的值
        if ($redis_is_exists && $cache === true) {
            $match_update_column = array_column($update_column, $rule_model->primary_key_arr[0]);
            foreach ($redis_is_exists as $idx => $record) {
                if (false !== $key = array_search($record[$rule_model->primary_key_arr[0]], $match_update_column)) {
                    foreach ($update_column[$key] as $column => $new_value)
                        $redis_is_exists[$idx][$column] = $new_value;
                        $update_redis_data[$idx] = json_encode($redis_is_exists[$idx]);

                        if ($into_redis === true)
                            array_push($cache_name_arr, $this->__single_string_cache_name_prefix . ':' . $record[$rule_model->primary_key_arr[0]]);
                }
            }
        }

        // 更新缓存
        if (! empty($update_redis_data) && ! empty($cache_name_arr))
            Registry::get('redis_string')->updateString($cache_name_arr, $update_redis_data, $expire);

        return $redis_is_exists;
    }

    /**
     * 批量删除
     *
     * batchDelete. 
     * @param array $arr 要插入表的数组，一条记录一个数组，每个数组里，column为键，value为值
     * @param bool $cache 是否删除缓存
     * @return bool
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     * @throws ServiceException
     */
    public function batchDelete($arr = [], $cache = false) {
        $array = !empty($arr) && is_array($arr) ? $arr : '';
        if(empty($array))
            throw new ServiceException(ServiceException::SERVICE_BATCH_DELETE_DATA_EMPTY, ServiceException::SERVICE_BATCH_DELETE_DATA_EMPTY_NO);

        $rule_model = RuleModel::getInstance();
        $rule_model->__set("data", $array)->batchDelete();

        $list_cache_name_arr = $cache_name_arr = [];
        $list_cache_name = [];
        // 需要缓存
        if ($cache === true) {
            $cache_name = $this->__single_string_cache_name_prefix . ':*';
            $cache_name_arr = Registry::get('redis_string')->getKeysByPattern($cache_name);
            $list_cache_name = $this->__list_sorted_set_cache_name_prefix . ':*';
            $list_cache_name_arr = Registry::get('redis_sorted_set')->getKeysByPattern($list_cache_name);
        }

        // 删除列表缓存
        if (! empty($list_cache_name_arr)) {
            Registry::get('redis_sorted_set')->deleteSortedSet($list_cache_name);
            Registry::get('redis_string')->deleteString($list_cache_name_arr);
        }

        if (! empty($cache_name_arr)) {
            Registry::get('redis_string')->deleteString($cache_name_arr);
        }
        return true;
    }

}