<?php

namespace models\DAO;

use Doctrine\DBAL\Cache\ArrayStatement;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\DBAL\Exception\DriverException;
use ErrorMsg\AbstractErrorMsg;
use models\Exception\DAO\ModelDriverException;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\DAO\ModelSqlException;
use Yaf\Registry;
use ReflectionException;
use Exception;

class BaseModel{

    private $__conn;
    private $__table_name;
    private $__sql;
    private $__order_by;
    private $__group_by;
    private $__having;
    private $__select;
    private $prepare_key;
    private $prepare_arr;

    public $reflection_class = null;

    public $none_column_name_arr = ['page', 'page_size', 'meta', 'data', 'primary_key_arr', 'obj',
        'instance', 'reflection_class', 'none_column_name_arr', 'auto_increment_key_arr', 'unique_key_arr'];


    /**
     * BaseModel constructor.
     * @param string $table_name
     * @throws ModelSqlException
     */
    protected function __construct($table_name = '')
    {
        $this->__table_name = !empty($table_name) ? strtolower(trim($table_name)) : '';
        if(empty($this->__table_name))
            throw new ModelSqlException(ModelSqlException::BASE_MODEL_EMPTY_TABLE_NAME, ModelSqlException::BASE_MODEL_EMPTY_TABLE_NAME_NO);
        $this->__conn = Registry::get("read");
        $this->__select = strtolower(substr($this->__table_name, 0, 1));
        $this->meta = new \stdClass();
    }

    public function getConn() {
        return $this->__conn;
    }

    /**
     * 设置表的简称
     * @param null $select
     * @return $this
     */
    public function select($select = null){
        $this->__select = $select ? $select : strtolower(substr($this->__table_name, 0, 1));
        return $this;
    }

    /**
     * 根据主键查找数据库
     * @param int $primary_key 主键
     * @return ArrayStatement
     * @throws ModelReflectionException
     * @throws ModelException
     */
    public function findByPrimaryKey($primary_key){
        try {
            if (is_null($this->reflection_class))
                $this->reflection_class = new \ReflectionClass($this);

            if (! $this->reflection_class->hasProperty('primary_key_arr'))
                throw new ModelException(ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR, ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR_NO);

            $this->__sql = "SELECT " . $this->__genSelect() . " FROM " .
                $this->__conn->quoteIdentifier($this->__table_name) . " AS " . $this->__select;
            $this->__sql .= " WHERE " . $this->__select . "." . $this->__conn->quoteIdentifier($this->primary_key_arr[0]) . " = :" . $this->__select . '_' .$this->primary_key_arr[0];
            $this->prepare_arr = [$this->__select . '_' .$this->primary_key_arr[0] => $primary_key];

            Registry::get("db_log")->info(json_encode(['sql' => $this->__sql, 'prepare_arr' => $this->prepare_arr]));

            $cache_name = $this->getCacheName();
            if(!empty($cache_name) && isset(Registry::get("config")['db']['master']['cache'])
                && Registry::get("config")['db']['master']['cache'] === '1'){
                $pdo_statement_obj = $this->__conn->executeCacheQuery($this->__sql, $this->prepare_arr, [], new QueryCacheProfile(3600, $cache_name));

                if(! $pdo_statement_obj instanceof ArrayStatement){
                    $data = $pdo_statement_obj->fetchAll();
                    $pdo_statement_obj->closeCursor();
                    return new ArrayStatement($data);
                }
            }else
                $pdo_statement_obj = $this->__conn->executeQuery($this->__sql, $this->prepare_arr, []);

            return $pdo_statement_obj;
        } catch (ModelReflectionException $e) {
            throw $e;
        } catch (ReflectionException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()],
                ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG);
            throw new ModelReflectionException($msg, ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG_NO);
        }
    }

    /**
     * 生成缓存名称
     * @param array $condition
     * @param int $page
     * @param int $page_size
     * @return string
     */
    public function getCacheName($condition = [], $page = 1, $page_size = 10){
        $cache_name = '';
        if(isset(Registry::get("config")['db']['master']['cache'])
            && Registry::get("config")['db']['master']['cache'] === '1'){
            foreach (debug_backtrace() as $item){
                if(strpos($item['class'], 'Service') !== false && isset($item['file'])){
                    $this->__conn->getConfiguration()->getResultCacheImpl()->setNamespace($item['class']);
                    $cache_name = $item['class'] . '_' . md5(json_encode($condition)) . '_' . $page . '_' . $page_size .
                        ($this->__order_by !== null ? ('_' . $this->__order_by) : '');
                }
                /*if(strpos($item['class'], 'BaseModel') !== false){
                    Registry::get("db_log")->addInfo(json_encode([$item['class'], $item['args'], $item['function']]));
                    $cache_name = $item['class'] . '_' . md5(json_encode([$item['args'], $item['function']]));
                }*/
            }
        }
        if(!empty($cache_name))
            Registry::get("db_log")->addInfo(json_encode(['cache_name' => $cache_name]));
//        header('Content-type', 'application/json');
//        exit(json_encode([$this->__conn->getConfiguration()->getResultCacheImpl()->getNamespace(), $cache_name]));
        return $cache_name;
    }

    /**
     * 根据条件返回符合条件的若干条(小于等于10)查询结果
     * @param array $condition
     * [
     *  'groupOp' => 'AND/OR',
     *  'rules' => [
     *      ['field' => '字段', 'op' => '等/不等/...', 'data' => '值'],
     *      ...
     *  ],
     * 'groups' =>
     *  [
     *      'groupOp' => 'AND/OR',
     *      'rules' => [
     *          ['field' => '字段', 'op' => '等/不等/...', 'data' => '值'],
     *          ...
     *      ],
     *      'groups'
     *  ]
     * ]
     * @param int $page
     * @param int $page_size
     * @return ArrayStatement
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws Exception
     */
    public function findRecordBy($condition = [], $page = 0, $page_size = 0){
        try {
            $this->__genSql('', $condition);

            $this->__sql .= ($page === 0 &&  $page_size === 0 ? " LIMIT 1" : " LIMIT " . (($page - 1) * $page_size) . ', ' . $page_size);
            Registry::get("db_log")->info(json_encode(['sql' => $this->__sql, 'prepare_arr' => $this->prepare_arr]));

            //获取缓存名称
            $cache_name = $this->getCacheName($condition, $page, $page_size);
//            $cache_name = '';
            //若配置文件中需要使用缓存且缓存名存在时
            if(isset(Registry::get("config")['db']['master']['cache']) && !empty($cache_name)
                && Registry::get("config")['db']['master']['cache'] === '1'){
                $pdo_statement_obj = $this->__conn->executeCacheQuery($this->__sql, $this->prepare_arr, [], new QueryCacheProfile(3600, $cache_name));
                //缓存不存在，实例化一个ArrayStatement并把data初始化进去，返回
                if(! $pdo_statement_obj instanceof ArrayStatement){
                    $data = $pdo_statement_obj->fetchAll();
                    $pdo_statement_obj->closeCursor();
                    $pdo_statement_obj = new ArrayStatement($data);
                }
            } else
                $pdo_statement_obj = $this->__conn->executeQuery($this->__sql, $this->prepare_arr);

            //缓存存在，直接返回缓存
            return $pdo_statement_obj;

        } catch (ReflectionException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()],
                ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG);
            throw new ModelReflectionException($msg, ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG_NO);
        } catch (DriverException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()], ModelDriverException::DRIVER_EXCEPTION_MSG);
            throw new ModelDriverException($msg, ModelDriverException::DRIVER_EXCEPTION_MSG_NO);
        } catch (ModelSqlException $e) {
            Registry::get('db_log')->err(__METHOD__ . "SqlException报错{$e->getMessage()}");
            throw $e;
        } catch (Exception $e) {
            Registry::get('db_log')->err(__METHOD__ . "报错{$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * 获取符合查询条件的总记录数 20170407版本启用
     * @param array $condition
     * @param string $sql
     * @return ArrayStatement
     * @throws ModelSqlException
     * @throws ModelReflectionException
     */
    public function getCount($condition = [], $sql = ''){
        try {
            $this->prepare_key = 1;
            $this->__genSql('count', $condition, $sql);

            Registry::get('db_log')->debug('sql: ' . $this->__sql);
            Registry::get('db_log')->debug('prepare_arr: ' . json_encode($this->prepare_arr));

            $cache_name = $this->getCacheName();
            if(!empty($cache_name) && isset(Registry::get("config")['db']['master']['cache'])
                && Registry::get("config")['db']['master']['cache'] === '1'){
                $pdo_statement_obj = $this->__conn->executeCacheQuery($this->__sql, $this->prepare_arr, [], new QueryCacheProfile(3600, $cache_name));

                if(! $pdo_statement_obj instanceof ArrayStatement){
                    $data = $pdo_statement_obj->fetchAll();
                    $pdo_statement_obj->closeCursor();
                    return new ArrayStatement($data);
                }

                return $pdo_statement_obj;
            }else
                $pdo_statement_obj = $this->__conn->executeQuery($this->__sql, $this->prepare_arr);

            return $pdo_statement_obj;
        } catch (ReflectionException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()],
                ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG);
            throw new ModelReflectionException($msg, ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG_NO);
        }
    }

    /**
     * @param $_order_by array order数组['order' => '要排序的字段1,要排序的字段2,...', 'sort' => '排序的字段1的排序方式,排序字段2的排序方式,...']
     * @return $this
     */
    public function setOrderBy($_order_by = ['order' => "id", 'sort' => 'DESC'])
    {
        $table_prefix = $this->__select;
        if(strpos($_order_by['order'], '.`') !== false){
            $table_prefix = strstr($_order_by['order'], ".", true);
            $_order_by['order'] = explode("`",$_order_by['order'])[1];
        }

        if(!is_array($_order_by) || !isset($_order_by['order']) || !isset($_order_by['sort'])){
            $this->__order_by = null;
        }else{
            if(strpos($_order_by['order'], ',') !== false){
                $order_by_arr = explode(',', $_order_by['order']);
                $sort_by_arr = explode(',', $_order_by['sort']);
                foreach($order_by_arr as $index => $column){
                    $order_by_arr[$index]= $table_prefix . "." . $this->__conn->quoteIdentifier(trim($column)) . " " .
                        (count($sort_by_arr) > 1 ? trim($sort_by_arr[$index]) : trim($sort_by_arr[0]));
                }
                $this->__order_by = implode(",", $order_by_arr);
            }else{

                $this->__order_by = $table_prefix  . "." . $this->__conn->quoteIdentifier(trim($_order_by['order'])) . " " . strtoupper($_order_by['sort']);
            }
        }
        return $this;
    }

    /**
     * @param $_group_by string group by的字段
     * @return $this
     */
    public function setGroupBy($_group_by = null)
    {
        $this->__group_by = $this->__select . "." . $this->__conn->quoteIdentifier($_group_by);
        return $this;
    }

    /**
     * @param $_having string having的值
     * @return $this
     */
    public function setHaving($_having = null)
    {
        $this->__having = $this->__select . $this->__conn->quoteIdentifier($_having);
        return $this;
    }

    /**
     * 插入数据(防注入)
     * @return mixed
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ModelException
     */
    public function insertRecord(){
        try {
            $this->__sql = $cache_name = '';
            $this->prepare_arr = $where_arr = $update_arr = [];

            if (is_null($this->reflection_class))
                $this->reflection_class = new \ReflectionClass($this);

            if (! $this->reflection_class->hasProperty('primary_key_arr'))
                throw new ModelException(ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR, ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR_NO);

            $column_arr = $value_arr = $prepare = [];
            foreach ($this->reflection_class->getProperties() as $property_name) {
                if (! $property_name->isStatic() && ! $property_name->isProtected() && ! $property_name->isPrivate()) {
                    $column_name = $property_name->getName();
                    $value = $this->__get($column_name);
                    if (! in_array($property_name->getName(), $this->none_column_name_arr) && ! is_null($value)) {
                        array_push($column_arr, $this->__conn->quoteIdentifier($column_name));
                        array_push($prepare, ':' . $column_name);
                        $this->prepare_arr[':' . $column_name] = $value;
                    }
                }
            }

            if (!empty($column_arr) && !empty($prepare) && count($prepare) == count($column_arr)) {
                $this->__sql = "INSERT INTO " .
                    $this->__conn->quoteIdentifier($this->__table_name) .
                    " (" . implode(',', $column_arr) . ") VALUES (". implode(',', $prepare) .")";
            }

            return $this->__transaction();
        } catch (ModelException $e) {
            throw $e;
        } catch (ReflectionException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()],
                ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG);
            throw new ModelReflectionException($msg, ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG_NO);
        }
    }

    /**
     * 更新数据(防注入)
     * @return bool
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ModelException
     */
    public function updateRecord(){
        try {
            $this->__sql = $cache_name = '';
            $this->prepare_arr = $where_arr = $update_arr = [];

            if (is_null($this->reflection_class))
                $this->reflection_class = new \ReflectionClass($this);

            if (! $this->reflection_class->hasProperty('primary_key_arr'))
                throw new ModelException(ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR, ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR_NO);

            foreach ($this->reflection_class->getProperties() as $property_name) {
                if (! in_array($property_name->getName(), $this->none_column_name_arr) && ! is_null($this->__get($property_name->getName()))) {
                    if (in_array($property_name->getName(), $this->primary_key_arr)) {
                        array_push($where_arr, $this->__conn->quoteIdentifier($property_name->getName()) . ' = :w_' . $property_name->getName());
                        $cache_name = $this->getCacheName($this->__get($property_name->getName()));
                        $this->prepare_arr['w_' . $property_name->getName()] = $this->__get($property_name->getName());
                    } else {
                        array_push($update_arr, $this->__conn->quoteIdentifier($property_name->getName()) . ' = :u_' . $property_name->getName());
                        $this->prepare_arr['u_' . $property_name->getName()] = $this->__get($property_name->getName());
                    }
                }
            }


            if(!empty($update_arr) && !empty($where_arr)){
                $this->__sql = " UPDATE " . $this->__conn->quoteIdentifier($this->__table_name)
                    . " SET " . implode(',', $update_arr) . ' WHERE ' . implode(' AND ', $where_arr);
            }

            //删除缓存
            if(!empty($cache_name)){
                $this->__conn->getConfiguration()->getResultCacheImpl()->deleteAll($cache_name);
            }

            $this->__transaction();

            return true;
        } catch (ModelException $e) {
            throw $e;
        } catch (ReflectionException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()],
                ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG);
            throw new ModelReflectionException($msg, ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG_NO);
        }
    }

    /**
     * 删除数据(防注入)
     * @return bool
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ModelException
     */
    public function deleteRecord(){
        try {
            $this->__sql = $cache_name = '';
            $this->prepare_arr = $where_arr = $update_arr = [];

            if (is_null($this->reflection_class))
                $this->reflection_class = new \ReflectionClass($this);

            if (! $this->reflection_class->hasProperty('primary_key_arr'))
                throw new ModelException(ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR, ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR_NO);

            foreach ($this->reflection_class->getProperties() as $property_name) {
                $column_name = $property_name->getName();
                if (! $property_name->isStatic() && $property_name->isPublic()) {
                    $value = $this->__get($column_name);
                    if (! in_array($column_name, $this->none_column_name_arr) && ! is_null($value) && in_array($column_name, $this->primary_key_arr)) {
                        $where_arr[] = $this->__conn->quoteIdentifier($column_name) . ' = :' . $this->__select . '_' . $column_name;
                        $this->prepare_arr[$this->__select . '_' . $column_name] = $value;
                    }
                }
            }

            if (!empty($where_arr) && !empty($this->prepare_arr) && count($where_arr) == count($this->prepare_arr)) {
                $this->__sql = "DELETE FROM " . $this->__conn->quoteIdentifier($this->__table_name) .
                    " WHERE " . (count($where_arr) > 1 ? implode(" AND ", $where_arr) : implode("", $where_arr));
            }

            $this->__transaction();

            return true;
        } catch (ModelException $e) {
            throw $e;
        } catch (ReflectionException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()],
                ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG);
            throw new ModelReflectionException($msg, ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG_NO);
        }
    }

    /**
     *
     * 批量插入
     * 每条记录为一个数组，每个数组下以字段为键，存入值为值组成二维数组
     * [
     *  [
     *      column_1 => value_1_1,
     *      column_2 => value_2_1,
     *      ...
     *  ],
     *  [
     *      column_1 => value_2_1,
     *      column_2 => value_2_2,
     *      ...
     *  ],
     *  ...
     * ]
     * @return mixed
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     */
    public function batchInsertRecord(){
        try {
            $this->__sql = $column_name_4_sql = "";
            $this->prepare_arr = $column_sql_arr = $real_value_sql_arr = [];

            if (! property_exists($this, 'data'))
                throw new ModelException(ModelException::THERE_IS_NOT_DATA_VAR, ModelException::THERE_IS_NOT_DATA_VAR_NO);
            if (! is_array($this->data) || empty($this->data))
                throw new ModelException(ModelException::INVALID_DATA_VAR, ModelException::INVALID_DATA_VAR_NO);

            $this->__sql = "INSERT INTO " . $this->__conn->quoteIdentifier($this->__table_name);

            foreach ($this->data as $idx => $column_value_arr) {
                $prepare = [];
                foreach ($column_value_arr as $column_name => $value) {
                    if (! property_exists($this, $column_name))
                        throw new ModelException(str_replace('%property%', $column_name, ModelException::THERE_IS_NO_PROPERTY), ModelException::THERE_IS_NO_PROPERTY_NO);
                    $column_name_4_sql = $this->__conn->quoteIdentifier($column_name);
                    if (! in_array($column_name_4_sql, $column_sql_arr))
                        array_push($column_sql_arr, $column_name_4_sql);
                    $prepare_column_name = ':' . $column_name . '_' . $idx;
                    array_push($prepare, $prepare_column_name);
                    $this->prepare_arr[$prepare_column_name] = $value;
                }


                if (!empty($prepare))
                    array_push($real_value_sql_arr, "(" . implode(",", $prepare) . ")");
            }

            $this->__sql .= ' (' . implode(',', $column_sql_arr) . ') VALUES ' . implode(', ', $real_value_sql_arr);

            return $this->__transaction();
        } catch (ModelException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        }
    }

    /**
     * 生成翻页对象
     * @param int $total_result
     * @throws ModelException
     */
    public function genMeta($total_result = 0){
        try {
            if (! property_exists($this, 'meta'))
                throw new ModelException(ModelException::THERE_IS_NOT_META_VAR, ModelException::THERE_IS_NOT_META_VAR_NO);

            $this->meta->total = intval($total_result);

            $this->meta->links = new \stdClass();
            $this->meta->total_pages = 0;
            $this->meta->per_page = 0;
            $this->meta->current_page = $this->page;
            $this->meta->count = 0;

            if (! property_exists($this, 'page'))
                throw new ModelException(ModelException::THERE_IS_NO_PAGE_VAR, ModelException::THERE_IS_NO_PAGE_VAR_NO);
            if (! property_exists($this, 'page_size'))
                throw new ModelException(ModelException::THERE_IS_NO_PAGE_SIZE_VAR, ModelException::THERE_IS_NO_PAGE_SIZE_VAR_NO);

            if($this->page !== 0 && $this->page_size !== 0){
                $this->meta->per_page = intval($this->page_size);
                $this->meta->total_pages = intval(ceil($total_result/$this->page_size));
                $this->meta->current_page = $this->page;
                $this->meta->count = $this->meta->total_pages <= 1 ? $this->meta->total :
                    ($this->meta->total_pages != $this->meta->current_page ?
                        $this->meta->per_page :
                        $this->meta->total - (($this->meta->current_page - 1) * $this->meta->per_page));
            }

            if($this->meta->total_pages !== 0)
                if($this->meta->total_pages > $this->meta->current_page + 1)
                    $this->meta->links->next_page = $this->meta->current_page + 1;
            if($this->meta->current_page > 1 && $this->meta->total_pages > 1)
                $this->meta->links->last_page = $this->meta->current_page - 1;

        } catch (ModelException $e) {
            throw $e;
        }
    }

    /**
     * 重置model对象下的所有有关字段的属性
     * @throws ModelException
     * @throws ReflectionException
     */
    public function resetObjVar() {
        if (is_null($this->reflection_class))
            $this->reflection_class = new \ReflectionClass($this);

        if (! $this->reflection_class->hasProperty('primary_key_arr'))
            throw new ModelException(ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR, ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_VAR_NO);

        foreach ($this->reflection_class->getProperties() as $property_name) {
            $column_name = $property_name->getName();
            if (! $property_name->isStatic() && $property_name->isPublic()) {
                if (! in_array($column_name, $this->none_column_name_arr)) {
                    $this->__set($column_name, null);
                }
            }
        }
    }

    /**
     * 根据查询结果，将各个字段的值或结果集set到对应属性
     * @param $pdo_statement
     * @param bool $is_array
     * @return $this
     * @throws ModelException
     * @throws ModelReflectionException
     */
    public function setModelProperty($pdo_statement, $is_array = false){
        try {
            $record_arr = null;
            if ($pdo_statement instanceof PDOStatement)
                $record_arr = $is_array === false ? $pdo_statement->fetchObject() : $pdo_statement->fetchAll(\PDO::FETCH_ASSOC);
            else if ($pdo_statement instanceof ArrayStatement)
                $record_arr = $is_array === false ? $pdo_statement->fetch() : $pdo_statement->fetchAll(\PDO::FETCH_ASSOC);
            else if (is_array($pdo_statement))
                $record_arr = $pdo_statement;

            $this->resetObjVar();

            if (is_null($record_arr)) {
                $msg = str_replace('%class_name%', __METHOD__, ModelException::DATA_NOT_EXISTS);
                throw new ModelException($msg, ModelException::DATA_NOT_EXISTS_NO);
            }

            if ($record_arr) {
                if ($is_array === true) {
//                    if (! $this->reflection_class->hasProperty('data'))
                    if (! property_exists($this, 'data'))
                        throw new ModelException(ModelException::THERE_IS_NOT_DATA_VAR, ModelException::THERE_IS_NOT_DATA_VAR_NO);

                    // 清空data
                    $this->data = [];

                    foreach ($record_arr as $record)
                        array_push($this->data, $record);
                } else {

                    if (is_object($record_arr))
                        $record_arr = (array)$record_arr;

                    foreach ($record_arr as $column => $value) {
                        if (! property_exists($this, $column)) {
                            $msg = str_replace('%property%', $column, ModelException::THERE_IS_NO_PROPERTY);
                            throw new ModelException($msg, ModelException::THERE_IS_NO_PROPERTY_NO);
                        } else
                            $this->__set($column, $value);
                    }
                }
            }

            return $this;

        } catch (ModelException $e) {
            throw $e;
        } catch (ReflectionException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()],
                ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG);
            throw new ModelReflectionException($msg, ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG_NO);
        }
    }

    /**
     * 批量删除
     *
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     */
    public function batchDeleteRecord() {
        try {
            $this->__sql = '';
            if (! property_exists($this, 'data'))
                throw new ModelException(ModelException::THERE_IS_NOT_DATA_VAR, ModelException::THERE_IS_NOT_DATA_VAR_NO);
            if (! is_array($this->data) || empty($this->data))
                throw new ModelException(ModelException::INVALID_DATA_VAR, ModelException::INVALID_DATA_VAR_NO);
            if (! property_exists($this, 'primary_key_arr'))
                throw new ModelException(ModelException::THERE_IS_NO_PRIMARY_KEY_ARR, ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_NO);

            if (empty($this->primary_key_arr))
                throw new ModelException(ModelException::INVALID_BATCH_UPDATE_PRIMARY_KEY_ARR, ModelException::INVALID_BATCH_UPDATE_PRIMARY_KEY_ARR_NO);

            $this->__sql = "DELETE FROM `" . $this->__table_name . "` WHERE " . $this->primary_key_arr[0] . ' in (' . implode(',', $this->data) . ')';

            $this->__transaction();

        } catch (ModelException $e) {
            throw $e;
        } catch (ModelDriverException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        }

    }

    /**
     * @param string $sql
     * @return mixed
     * @throws ModelSqlException
     */
    public function query($sql = ''){
        try {

            $this->__sql = is_string($sql) && !empty($sql) ? trim($sql) : '';
            if(empty($this->__sql))
                throw new ModelSqlException(ModelSqlException::BASE_MODEL_EMPTY_SQL, ModelSqlException::BASE_MODEL_EMPTY_SQL_NO);

            $pdo_statement_obj = $this->__conn->executeQuery($this->__sql);

            return $pdo_statement_obj->fetchAll();
        } catch (ModelSqlException $e) {
            throw $e;
        }
    }

    /**
     * 生成批量修改的sql语句
     * 二维数组里的键的长度必须一致
     * [
     *  {
     *      'id' => '主键必须存在且必须在第一个位置',
     *      'column1' => 'new_value_1',
     *      'column2' => 'old_value_2',
     *      ...
     *  },
     *  {},
     *  ...
     * ]
     * @return bool|string
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     */
    protected function _genBatchUpdateSql(){
        try {
            if (! property_exists($this, 'data'))
                throw new ModelException(ModelException::THERE_IS_NOT_DATA_VAR, ModelException::THERE_IS_NOT_DATA_VAR_NO);
            if (! is_array($this->data) || empty($this->data))
                throw new ModelException(ModelException::INVALID_DATA_VAR, ModelException::INVALID_DATA_VAR_NO);
            if (! property_exists($this, 'primary_key_arr'))
                throw new ModelException(ModelException::THERE_IS_NO_PRIMARY_KEY_ARR, ModelException::THERE_IS_NO_PRIMARY_KEY_ARR_NO);

            $primary_key_arr = array_column($this->data, $this->primary_key_arr[0]);

            if (empty($primary_key_arr))
                throw new ModelException(ModelException::INVALID_BATCH_UPDATE_PRIMARY_KEY_ARR, ModelException::INVALID_BATCH_UPDATE_PRIMARY_KEY_ARR_NO);

            $this->__sql = "UPDATE " . $this->__conn->quoteIdentifier($this->__table_name) . ' SET ';
            $update_column_arr = $where_id = [];
            foreach ($this->data as $idx => $column_value_arr) {
                foreach ($column_value_arr as $column_name => $value) {
                    if ($column_name != $this->primary_key_arr[0])
                        $update_column_arr[$column_name][] = ' WHEN ' . $column_value_arr[$this->primary_key_arr[0]] . ' THEN ' . $value;
                }
            }

            $modify_column_is_equal = true;
            foreach ($update_column_arr as $column_name => $sub_sql_arr) {
                $modify_column_is_equal = $modify_column_is_equal === true ? count($sub_sql_arr) : $modify_column_is_equal === count($sub_sql_arr);
                $this->__sql .=  $this->__conn->quoteIdentifier($column_name) . ' = CASE ' .
                    $this->__conn->quoteIdentifier($this->primary_key_arr[0]) . implode('', $sub_sql_arr) .
                    ' END, ';
            }

            if ($modify_column_is_equal === false)
                throw new ModelSqlException(ModelSqlException::BASE_MODEL_BATCH_UPDATE_INVALID, ModelSqlException::BASE_MODEL_BATCH_UPDATE_INVALID_NO);

            $this->__sql = substr($this->__sql, 0, strrpos($this->__sql, ','));
            $this->__sql .= ' WHERE ' . $this->__conn->quoteIdentifier($this->primary_key_arr[0]) . ' in (' . implode(',', $primary_key_arr) . ')';

            return $this->__transaction();

        } catch (ModelException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (ModelDriverException $e) {
            throw $e;
        }
    }

    /**
     * 事务
     * @return mixed
     * @throws ModelSqlException
     * @throws ModelDriverException
     */
    private function __transaction(){
        try{
            if (empty($this->__sql))
                throw new ModelSqlException(ModelSqlException::BASE_MODEL_EMPTY_SQL, ModelSqlException::BASE_MODEL_EMPTY_SQL);

            Registry::get("db_log")->addInfo(json_encode(['sql' => $this->__sql, 'prepare_arr' => $this->prepare_arr]));

            $this->__conn->beginTransaction();

            if (!empty($this->prepare_arr)){
                $this->__conn->executeQuery($this->__sql, $this->prepare_arr);
            }else{
                $this->__conn->executeQuery($this->__sql);
            }
            $return = $this->__conn->lastInsertId();

            $this->__conn->commit();

            return $return;
        } catch (ModelSqlException $e) {
            $this->__conn->rollBack();
            throw $e;
        } catch (Exception $e){
            $this->__conn->rollBack();
            throw new ModelDriverException(str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()], ModelDriverException::DRIVER_EXCEPTION_MSG),
                ModelDriverException::DRIVER_EXCEPTION_MSG_NO);
        }
    }

    /**
     * 生成查询字段
     * @return string
     * @throws ModelReflectionException
     */
    private function __genSelect() {
        try {

            $select_arr = [];
            if (is_null($this->reflection_class))
                $this->reflection_class = new \ReflectionClass($this);

            foreach ($this->reflection_class->getProperties() as $property_name) {
                // 字段属性
                if (! in_array($property_name->getName(), $this->none_column_name_arr))
                    array_push($select_arr, implode('.', [$this->__select,$this->__conn->quoteIdentifier($property_name->getName())]));
            }

            return !empty($select_arr) ? implode(', ', $select_arr) : '*';
        } catch (ReflectionException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()],
                ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG);
            throw new ModelReflectionException($msg, ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG_NO);
        }
    }

    /**
     * 生成sql
     * @param string $type
     * @param array $condition
     * @param string $sql
     * @throws ModelSqlException
     * @throws ReflectionException
     */
    private function __genSql($type = 'count', $condition = [], $sql = ''){
        if (empty($sql)) {
            $this->__sql = "SELECT ";
            $this->__sql .= $type !== 'count' ? $this->__genSelect() :
                "count(" . $this->__select . "." . ($this->__table_name == 'orders' ? $this->__conn->quoteIdentifier('order_sn') : $this->__conn->quoteIdentifier('id')) . ") AS total";
            $this->__sql .= " FROM " . $this->__conn->quoteIdentifier($this->__table_name) . " AS " . $this->__select;
        } else {
            $this->__sql = $sql;
        }
        $this->prepare_key = 1;
        $this->prepare_arr = [];
        $where_sql = $this->__genConditionQuery($condition);
        $this->__sql .= !empty($where_sql) ? ' WHERE ' . $where_sql : '';

        if($this->__order_by !== null){
            $this->__sql  .= " ORDER BY " . ($this->__table_name == 'orders' ? str_replace(substr($this->__order_by, 0, strrpos($this->__order_by, '`') + 1), $this->__conn->quoteIdentifier('created_at'), $this->__order_by) : $this->__order_by);
        }
        if($this->__group_by !== null){
            $this->__sql  .= " GROUP BY " . $this->__conn->quoteIdentifier($this->__group_by);
        }
        if($this->__having !== null){
            $this->__sql  .= " HAVING BY " . $this->__having;
        }
    }

    /**
     * 字符串转sql语句
     * @param string $str
     * @return string
     */
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
                $real_symbol = "not like '#str#'";
                break;
            case 'nc':
                $real_symbol = "like '#str#'";
                break;
            case 'in':
                $real_symbol = "in ('#str#')";
                break;
            case 'ni':
                $real_symbol = "not in ('#str#')";
                break;
            default:
                $real_symbol = '';
                break;
        }
        return $real_symbol;
    }

    /**
     * 传入查询条件数组，生成查询语句
     * @param array $groups
     * [
     *  'groupOp' => 'AND/OR',
     *  'rules' => [
     *      ['field' => '字段', 'op' => '等/不等/...', 'data' => '值'],
     *      ...
     *  ],
     *  'groups' => [
     *      'groupOp' => 'AND/OR',
     *      'rules' => [
     *          ['field' => '字段', 'op' => '等/不等/...', 'data' => '值'],
     *          ...
     *      ],
     *      'groups'
     *  ]
     * ]
     * @param string $sql
     * @return string
     * @throws ModelSqlException
     */
    private function __genConditionQuery($groups = [], $sql = ""){
        if(!empty($groups['groups']) && isset($groups['groupOp'])){
            foreach($groups['groups'] as $k => $groups_arr){
                $sql .= empty($sql) ? $this->__genConditionQuery($groups_arr) :
                    ' ' . $groups['groupOp'] . ' ' . $this->__genConditionQuery($groups_arr);
            }
        }
        if(!empty($groups['rules']) && isset($groups['groupOp'])){
            foreach($groups['rules'] as $index => $value_arr){
                $value_arr['data'] = str_replace(['；', '，', ',', ';', '`'], ',',
                    strpos($value_arr['field'], '_at') !== false ? ($value_arr['data']) : $value_arr['data']);
                $table_prefix_arr = [];

                $column = $value_arr['field'];
                $value_arr['field'] = $this->__select . "." . $this->__conn->quoteIdentifier($column);

                // 防注入
                if ($value_arr['op'] == 'in' || $value_arr['op'] == 'ni') {
                    $value_arr['data'] = $val_arr = explode(',', $value_arr['data']);
                    $keys = [];
                    foreach ($val_arr as $key => $value){
                        $keys[] = ':' . $value_arr['op'] . '_' . $column . '_' . $key;
                        $this->prepare_arr[':' . $value_arr['op'] . '_' . $column.'_' . $key] = $value;
                    }
                    $field = implode(',', $keys);
                }else{
                    $field = ':' . $value_arr['op'] . '_' . $column;
                    $this->prepare_arr[':' . $value_arr['op'] . '_' . $column] = $value_arr['data'];
                }

                if (empty($sql)) {
                    $sql .= $value_arr['field'];
                } else {
                    $sql .= ' ' . $groups['groupOp'] . ' ' . $value_arr['field'];
                }
                $sql .=  ' ' . (
                strpos($this->__getRealSymbol($value_arr['op']), '#str#') ?
                    str_replace("'#str#'", $field, $this->__getRealSymbol($value_arr['op'])) :
                    $this->__getRealSymbol($value_arr['op']) . $field);
            }
        }

//        if (empty($sql))
//            throw new ModelSqlException(__METHOD__ . "报错: {" . ModelSqlException::BASE_MODEL_EMPTY_SQL . "}", ModelSqlException::BASE_MODEL_EMPTY_SQL_NO);

        return !empty($sql) ? '(' . $sql . ')' : '';

//        return !empty($sql) ? ['sql' => '(' . $sql . ')','prepare_arr' => $this->prepare_arr] : '';
    }
}
