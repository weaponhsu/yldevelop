<?php

namespace models\Transformer;

use Yaf\Exception;
use models\DAO\RuleModel;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\Transformer\TransformerException;


class RuleTransformer extends BaseTransformer {
    /** 
     * model对象
     */
    public $rule_model = null;

    /**
     * class constructor. 
     * @param RuleModel $rule_model 模型对象
     */
    public function __construct(RuleModel $rule_model){
        $this->rule_model = $rule_model;
        parent::__construct();
    }

    /**
     * 获取后台data的json
     * @return array
     * @throws TransformerException
     */
    public function BackEndData() {
        try {
            if(! $this->rule_model instanceof RuleModel)
                throw new TransformerException(TransformerException::INSTANCE_IS_INVALID, TransformerException::INSTANCE_IS_INVALID_NO);

            $return = [];
            if(is_array($this->rule_model->data)){
                foreach ($this->rule_model->data as $index => $rule_model){
                    $return[$index] = $rule_model;
                }
            }

            return [
                'data' => $return,
                'meta' => (array)$this->rule_model->meta
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
            return $this->_getData($this->rule_model);
        } catch (ModelException $e) {
            throw $e;
        } catch (TransformerException $e) {
        throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        }
    }

}