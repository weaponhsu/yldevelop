<?php

namespace models\Transformer;


use models\DAO\BaseModel;
use models\Exception\DAO\ModelException;
use models\Exception\Transformer\TransformerException;
use ReflectionClass;
use ReflectionException;
use models\Exception\DAO\ModelReflectionException;
use Yaf\Exception;
use Yaf\Registry;

class BaseTransformer
{
    protected $_qiniu_keyword_arr = ['thumb', 'avatar', 'pic', 'img', 'thumb', 'album'];
    protected $qiniu_bucket_name = [];

    public function __construct(){

        $this->qiniu_bucket_name = isset(Registry::get("config")['qiniu']['bucket']['name']) ? Registry::get("config")['qiniu']['bucket']['name'] : [];
        $this->qiniu_bucket_url = isset(Registry::get("config")['qiniu']['bucket']['url']) ? Registry::get("config")['qiniu']['bucket']['url'] : [];
        return $this;
    }

    /**
     * @param BaseModel $model
     * @return array
     * @throws ModelReflectionException
     * @throws TransformerException
     * @throws ModelException
     */
    protected function _getData(BaseModel $model){
        try {
            $return = [];
            $table_name = strtolower(str_replace("Model", "", substr(get_class($model), strrpos(get_class($model), '\\') + 1)));
//            $table_prefix = substr($table_name, 0, 1);

            if (! $model instanceof BaseModel)
                throw new TransformerException(TransformerException::INSTANCE_IS_INVALID, TransformerException::INSTANCE_IS_INVALID_NO);

            $model_reflection_class = new ReflectionClass($model);
            if (!in_array($table_name, $this->qiniu_bucket_name)){
                $this->_qiniu_keyword_arr = [];
            }

            if ($model_reflection_class->hasMethod('__get') === false)
                throw new ModelReflectionException(ModelException::THERE_IS_NO_GET_METHOD, ModelException::THERE_IS_NO_GET_METHOD_NO);

            foreach ($model_reflection_class->getProperties() as $property) {
                $column = $property->getName();
                if ($property->isPublic() && !$property->isStatic() && !in_array($column, $model->none_column_name_arr)) {
                    $value = $model->__get($column);
//                    if (is_null($value))
//                        throw new ModelException(str_replace('%class_name%', get_class($model), ModelException::DATA_NOT_EXISTS), ModelException::DATA_NOT_EXISTS_NO);
                    if (!is_null($value) && $value !== '')
                        $return[$column] = $value;
                }
            }

            return $return;
        } catch (ModelException $e) {
            throw $e;
        } catch (TransformerException $e) {
            throw $e;
        } catch (ModelReflectionException $e) {
            Registry::get('transformer_log')->err(__METHOD__ . "报错{$e->getMessage()}");
            throw $e;
        } catch (ReflectionException $e) {
            $msg = str_replace(['%class_name%', '%msg%'], [__METHOD__, $e->getMessage()], ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG);
            Registry::get('transformer_log')->err($msg);
            throw new ModelReflectionException($msg, ModelReflectionException::MODEL_REFLECTION_EXCEPTION_MSG_NO);
        }
    }
    public function getQiNiuUrl($name,$thumb)
    {
        $is_serialized = $this->isSerialized($thumb);
        $thumb = $is_serialized ? unserialize($thumb) : $thumb;
        $qiniu_url = isset($this->qiniu_bucket_url[$name]) ? $this->qiniu_bucket_url[$name] : '';
        if (!empty($thumb) && stripos($thumb, 'http') === false) {
                $thumb = $qiniu_url . $thumb;
        }
        return $thumb;
    }

    public function isSerialized($data){
        $data = trim($data);
        if ('N;' == $data)
            return true;
        if (!preg_match('/^([adObis]):/', $data, $badions))
            return false;
        switch ($badions[1]) {
            case 'a' :
            case 'O' :
            case 's' :
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                    return true;
                break;
        }
        return false;
    }
    public function getChannel($url){
        $channel = '1';
        if(strpos($url,'taobao.com') !== false){
            $channel = '1';
        }else if(strpos($url,'tmall.com') !== false){
            $channel = '2';
        }else if(strpos($url,'jd.com') !== false){
            $channel = '3';
        }
        return $channel;
    }
}
