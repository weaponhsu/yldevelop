<?php

namespace models\DAO;

use models\Exception\DAO\ModelDriverException;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\DAO\ModelSqlException;


/**
 * @SWG\Swagger(
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleSingleData",
 *          required={"errno", "errmsg", "data"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", type="object", ref="#/definitions/roleSingleObj")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleSingleObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/roleSingle")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleListData",
 *          required={"errno", "errmsg", "result"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", ref="#/definitions/roleListObj"),
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleListObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/roleData"),
 *          @SWG\Property(property="meta", ref="#/definitions/meta")
 *     ),
 *     @SWG\Definition(
 *          type="array",
 *          definition="roleData",
 *          @SWG\Items(
 *              title="data", ref="#/definitions/roleSingle"
 *          )
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleSingle",
 *          @SWG\Property(property="id", type="integer", format="int32",  description="主键"),
 *          @SWG\Property(property="name", type="string", format="string",  description="角色"),
 *          @SWG\Property(property="created_at", type="string", format="string",  description="创建时间"),
 *          @SWG\Property(property="created_by", type="integer", format="int32",  description="创建人"),
 *          @SWG\Property(property="updated_at", type="string", format="string",  description="最后一次修改时间"),
 *          @SWG\Property(property="updated_by", type="integer", format="int32",  description="最后一次修改人"),
 *     )
 * )
 */
class RoleModel extends BaseModel{
    /** 
     * 主键
     */
    public $id = null;

    /** 
     * 角色
     */
    public $name = null;

    /** 
     * 创建时间
     */
    public $created_at = null;

    /** 
     * 创建人
     */
    public $created_by = null;

    /** 
     * 最后一次修改时间
     */
    public $updated_at = null;

    /** 
     * 最后一次修改人
     */
    public $updated_by = null;
    /** 
     * DAO对象
     */
    public $obj = '';

    /** 
     * DAO对象数组
     */
    public $data = [];

    /** 
     * 翻页对象
     */
    public $meta = null;

    /** 
     * 当前页
     */
    public $page = 1;

    /** 
     * 每页显示条数
     */
    public $page_size = 10;

    /** 
     * 主键数组
     */
    public $primary_key_arr = ["id"];

    /** 
     * 自增字段数组
     */
    public $auto_increment_key_arr = ["id"];

    /** 
     * 唯一字段
     */
    public $unique_key_arr = 'name';

    /** 
     * 单例实例
     */
    static public $instance = null;

    /**
     * @return RoleModel|null
     * @throws ModelSqlException
     */
    static public function getInstance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * RoleModel constructor.
     * @throws ModelSqlException
     */
    public function __construct() {
        parent::__construct(str_replace("Model", "", substr(get_class($this), strrpos(get_class($this), "\\")+1)));
        $this->meta = new \stdClass();
    }

    /**
     * @throws ModelException
     */
    public function __clone() {
        throw new ModelException(
            str_replace('%s', get_class($this), ModelException::INSTANCE_NOT_ALLOW_TO_CLONE), ModelException::INSTANCE_NOT_ALLOW_TO_CLONE_NO);
    }

    public function __destruct() {
        self::$instance = null;
    }

    /**
     * set属性
     *
     * __set. 
     * @param string $name 参数名
     * @param string $value 参数值
     * @return $this
     */
    public function __set($name = "", $value = "") {
        $this->$name = $value;
        return $this;
    }

    /**
     * get属性
     *
     * __get. 
     * @param string $name 参数名
     * @return mixed
     */
    public function __get($name = "") {
        return  $this->$name ;
    }

    /**
     * 创建roleModel
     * 
     * @return mixed
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ModelException
     */
    public function insert() {
        return $this->insertRecord();
    }

    /**
     * 编辑roleModel
     * 
     * @return mixed
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ModelException
     */
    public function update() {
        return $this->updateRecord();
    }

    /**
     * 删除roleModel，需先指定主键
     * 
     * @return mixed
     * @throws ModelDriverException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     * @throws ModelException
     */
    public function delete() {
        return $this->deleteRecord();
    }

    /**
     * 根据主键查询roleModel，获取单条记录
     *
     * find. 
     * @param int $primary_key 主键编号
     * @return $this
     * @throws ModelException
     * @throws ModelReflectionException
     */
    public function find($primary_key = 0) {
        $result = $this->findByPrimaryKey($primary_key);

        $this->setModelProperty($result);

        return $this;
    }

    /**
     * 根据条件数组查询roleModel，获取多条记录
     *
     * findOneBy. 
     * @param array $condition 查询条件
     * @return $this
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     */
    public function findOneBy($condition = []) {
        $result = $this->findRecordBy($condition);

        $this->setModelProperty($result);

        return $this;
    }

    /**
     * 根据条件数组查询roleModel，获取多条记录
     *
     * findBy. 
     * @param array $condition 查询条件
     * @return $this
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelReflectionException
     * @throws ModelSqlException
     */
    public function findBy($condition = []) {
        $count = $this->getCount($condition);
        $total = $count->fetchColumn();

        $this->data = [];
        $role_obj = $this->findRecordBy($condition, $this->page, $this->page_size);

        $this->genMeta($total);
        $this->setModelProperty($role_obj, true);

        return $this;
    }

    /**
     * 批量插入roleModel
     * 
     * @return mixed
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     */
    public function batchInsert() {
        return $this->batchInsertRecord();
    }

    /**
     * 批量删除roleModel
     * 
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     */
    public function batchDelete() {
        $this->batchDeleteRecord();
    }

    /**
     * 生成批量生成update的sql
     * 
     * @return bool|string
     * @throws ModelDriverException
     * @throws ModelException
     * @throws ModelSqlException
     */
    public function genBatchUpdateSql() {
        return $this->_genBatchUpdateSql();
    }

}