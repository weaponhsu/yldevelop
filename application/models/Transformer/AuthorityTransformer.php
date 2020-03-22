<?php

namespace models\Transformer;

use Yaf\Exception;
use models\DAO\AuthorityModel;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\Transformer\TransformerException;


class AuthorityTransformer extends BaseTransformer {
    /** 
     * model对象
     */
    public $authority_model = null;

    /**
     * class constructor. 
     * @param AuthorityModel $authority_model 模型对象
     */
    public function __construct(AuthorityModel $authority_model){
        $this->authority_model = $authority_model;
        parent::__construct();
    }

    /**
     * 获取后台data的json
     * @return array
     * @throws TransformerException
     */
    public function BackEndData() {
        try {
            if(! $this->authority_model instanceof AuthorityModel)
                throw new TransformerException(TransformerException::INSTANCE_IS_INVALID, TransformerException::INSTANCE_IS_INVALID_NO);

            $return = [];
            if(is_array($this->authority_model->data)){
                foreach ($this->authority_model->data as $index => $authority_model){
                    $return[$index] = $authority_model;
                }
            }

            return [
                'data' => $return,
                'meta' => (array)$this->authority_model->meta
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
            return $this->_getData($this->authority_model);
        } catch (ModelException $e) {
            throw $e;
        } catch (TransformerException $e) {
        throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        }
    }

}