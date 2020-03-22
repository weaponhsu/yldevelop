<?php

namespace models\Transformer;

use Yaf\Exception;
use models\DAO\MenuModel;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\Transformer\TransformerException;


class MenuTransformer extends BaseTransformer {
    /** 
     * model对象
     */
    public $menu_model = null;

    /**
     * class constructor. 
     * @param MenuModel $menu_model 模型对象
     */
    public function __construct(MenuModel $menu_model){
        $this->menu_model = $menu_model;
        parent::__construct();
    }

    /**
     * 获取后台data的json
     * @return array
     * @throws TransformerException
     */
    public function BackEndData() {
        try {
            if(! $this->menu_model instanceof MenuModel)
                throw new TransformerException(TransformerException::INSTANCE_IS_INVALID, TransformerException::INSTANCE_IS_INVALID_NO);

            $return = [];
            if(is_array($this->menu_model->data)){
                foreach ($this->menu_model->data as $index => $menu_model){
                    $return[$index] = $menu_model;
                }
            }

            return [
                'data' => $return,
                'meta' => (array)$this->menu_model->meta
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
            return $this->_getData($this->menu_model);
        } catch (ModelException $e) {
            throw $e;
        } catch (TransformerException $e) {
        throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        }
    }

}