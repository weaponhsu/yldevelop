<?php

namespace models\Transformer;

use Yaf\Exception;
use models\DAO\RoleModel;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\Transformer\TransformerException;


class RoleTransformer extends BaseTransformer {
    /** 
     * model对象
     */
    public $role_model = null;

    /**
     * class constructor. 
     * @param RoleModel $role_model 模型对象
     */
    public function __construct(RoleModel $role_model){
        $this->role_model = $role_model;
        parent::__construct();
    }

    /**
     * 获取后台data的json
     * @return array
     * @throws TransformerException
     */
    public function BackEndData() {
        try {
            if(! $this->role_model instanceof RoleModel)
                throw new TransformerException(TransformerException::INSTANCE_IS_INVALID, TransformerException::INSTANCE_IS_INVALID_NO);

            $return = [];
            if(is_array($this->role_model->data)){
                foreach ($this->role_model->data as $index => $role_model){
                    $return[$index] = $role_model;
                }
            }

            return [
                'data' => $return,
                'meta' => (array)$this->role_model->meta
            ];
        } catch (TransformerException $e) {
            throw $e;
        }
    }

    /**
     * 获取后台单条记录的数据
     * @return array
     * @throws ModelReflectionException
     * @throws TransformerException
     * @throws ModelException
     */
    public function SingleData() {
        try {
            return $this->_getData($this->role_model);
        } catch (ModelException $e) {
            throw $e;
        } catch (TransformerException $e) {
        throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        }
    }

}