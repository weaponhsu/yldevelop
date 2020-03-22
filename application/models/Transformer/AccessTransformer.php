<?php

namespace models\Transformer;

use Yaf\Exception;
use models\DAO\AccessModel;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\Transformer\TransformerException;


class AccessTransformer extends BaseTransformer {
    /** 
     * model对象
     */
    public $access_model = null;

    /**
     * class constructor. 
     * @param AccessModel $access_model 模型对象
     */
    public function __construct(AccessModel $access_model){
        $this->access_model = $access_model;
        parent::__construct();
    }

    /**
     * 获取后台data的json
     * @return array
     * @throws TransformerException
     */
    public function BackEndData() {
        try {
            if(! $this->access_model instanceof AccessModel)
                throw new TransformerException(TransformerException::INSTANCE_IS_INVALID, TransformerException::INSTANCE_IS_INVALID_NO);

            $return = [];
            if(is_array($this->access_model->data)){
                foreach ($this->access_model->data as $index => $access_model){
                    $return[$index] = $access_model;
                }
            }

            return [
                'data' => $return,
                'meta' => (array)$this->access_model->meta
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
            return $this->_getData($this->access_model);
        } catch (ModelException $e) {
            throw $e;
        } catch (TransformerException $e) {
        throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        }
    }

}