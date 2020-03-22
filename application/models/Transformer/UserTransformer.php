<?php

namespace models\Transformer;

use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\DAO\UserModel;
use models\Exception\Transformer\TransformerException;


class UserTransformer extends BaseTransformer {
    /**
     * model对象
     */
    public $user_model = null;

    /**
     * class constructor.
     * @param UserModel $user_model 模型对象
     */
    public function __construct(UserModel $user_model){
        $this->user_model = $user_model;
        parent::__construct();
    }

    /**
     * 获取后台data的json
     * @return array
     * @throws TransformerException
     */
    public function BackEndData(){
        try {
            if(! $this->user_model instanceof UserModel)
                throw new TransformerException(TransformerException::INSTANCE_IS_INVALID, TransformerException::INSTANCE_IS_INVALID_NO);

            $return = [];
            if(is_array($this->user_model->data)){
                foreach ($this->user_model->data as $index => $user_model){
                    $return[$index] = $user_model;
                }
            }

            return [
                'data' => $return,
                'meta' => (array)$this->user_model->meta
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
    public function SingleData(){
        try {
            return $this->_getData($this->user_model);
        } catch (ModelException $e) {
            throw $e;
        } catch (TransformerException $e) {
            throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        }
    }

}
