<?php

/**
 *
 *            ┏┓　　  ┏┓+ +
 *           ┏┛┻━━━━━┛┻┓ + +
 *           ┃         ┃ 　
 *           ┃   ━     ┃ ++ + + +
 *          ████━████  ┃+
 *           ┃　　　　　 ┃ +
 *           ┃　　　┻　　┃
 *           ┃　　　　　 ┃ + +
 *           ┗━┓　　　┏━┛
 *             ┃　　　┃　　　　
 *             ┃　　　┃ + + + +
 *             ┃　　　┃    Code is far away from bug with the alpaca protecting
 *             ┃　　　┃ + 　　　　        神兽保佑,代码无bug
 *             ┃　　　┃
 *             ┃　　　┃　　+
 *             ┃     ┗━━━┓ + +
 *             ┃         ┣┓
 *             ┃ 　　　　　┏┛
 *             ┗┓┓┏━━┳┓┏━┛ + + + +
 *              ┃┫┫  ┃┫┫
 *              ┗┻┛  ┗┻┛+ + + +
 * Created by PhpStorm.
 * User: weaponhsu
 * Date: 2017/1/18
 * Time: 下午1:34
 */
require_once __DIR__ . '/GeneratedCode.php';

class GeneratedTransformer extends GeneratedCode
{
    private $__column_arr;

    protected $_code_arr = [
        'start' => '<?php',
        'namespace' => 'models\\Transformer',
        'use' => [
            'Yaf\\Exception',
            'models\\DAO\\#table_name#'
        ],
        'class' => 'class #class_name# extends BaseTransformer {',
        'public_variable' => [
            '#table_name#model' => ['', 'object', 'model对象']
        ],
        'private_variable' => [
        ],

        'construct' => [
            'function' => '',
            'annotation' => '',
//            '#table_name#model' => ['', 'object', '模型对象']
            'arr' => [
                ['', 'object', '模型对象', '#table_name#model']
            ]
        ],
        'public_function' => [
//            '__construct' => [
//                'function' => '',
//                '#table_name#_model' => ['', 'object', '模型对象']
//            ],
            'BackEndData' => [
                'function' => '',
                'annotation' => '获取后台data的json',
            ],
            'SingleData' => [
                'function' => '',
                'annotation' => '获取后台单条记录的数据'
            ],
        ]
    ];

    public function generatedTransformerCode($file_path = ''){
        $code = '';
        $column_variable_type = 'private';
        $this->setColumnArr($file_path);
        if(!empty($this->_code_arr) && !empty($file_path)){
            foreach($this->_code_arr as $key => $element){
                switch ($key){
                    case 'start':
                        $code .= $this->genStartCode($element);
                        break;
                    case 'namespace':
                        $code .= $this->genNamespaceCode($element);
                        break;
                    case 'use':
                        foreach($element as $id => $use_namespace){
                            if(strpos($use_namespace, '#table_name#') !== false){
                                $table_name = ucfirst(str_replace("Transformer", "Model", substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
                                $element[$id] = str_replace('#table_name#', $table_name, $use_namespace);
                            }
                        }
                        $code .= $this->genUseCode($element);
                        break;
                    case 'class':
                        $code .= $this->genClass($element, $file_path);
                        break;
                    case 'public_variable':
                    case 'protected_variable':
                    case 'private_variable':
                        foreach($element as $variable_name => $element_arr){
                            if($variable_name == '#column#'){
                                $column_variable_type = substr($key, 0, stripos($key, '_'));
                                $code .= $this->genServiceVariable($column_variable_type, [], $file_path);
                            }else{
                                /*$function_name =*/ $function_main = '';
                                $function_name_arr = [];
                                if(strpos($variable_name, '#table_name#') !== false){
                                    $table_name = strtolower(str_replace('Transformer', '', substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
                                    $variable_name = str_replace("#table_name#", $table_name . '_', $variable_name);
                                    foreach (explode('_', $variable_name) as $index => $value){
                                        $function_name_arr[] = ucfirst($value);
                                    }
                                    if(!empty($function_name_arr)){
//                                        $function_name = 'get' . implode('', $function_name_arr);
                                        $function_main = "    return \$this->exception instanceof Exception ? \$this->exception : #        (\$this->error === 0 ? \$this->" . $variable_name . " : \$this->getResult('error'));";
                                    }
                                }
                                $code .= $this->genVariable(substr($key, 0, stripos($key, '_')), [$variable_name => $element_arr], false);
//                                if(!empty($function_name) && !empty($function_main)){
//                                    $code .= $this->genFunction(substr($key, 0, stripos($key, '_')), $function_name, [[$variable_name => $element_arr]], $function_main);
//                                }
                            }
                        }
                        break;
                    case 'construct':
                        unset($element['function']);
                        unset($element['annotation']);
                        $code .= $this->__genConstruct($file_path, $element);
                        break;
                    case 'public_function':
                    case 'protected_function':
                    case 'private_function':
                        foreach($element as $function_name => $parameter_function_arr){
                            $parameter_arr = [];
                            $function = $annotation = '';
                            foreach($parameter_function_arr as $k => $v){
                                if($k != 'function' && $k != 'annotation'){
                                    $parameter_arr[] = [$k => $v];
                                }else{
                                    if($k == 'function'){
                                        $function = $v;
                                    }
                                    //获取函数备注内容 替换相关参数 生成对应函数备注
                                    else if($k == 'annotation'){
                                        $annotation = $this->_setFunctionAnnotation($v, $file_path);
                                    }
                                }
                            }
                            //生成函数主体
                            if(empty($function)){
                                $method_name = 'gen' . ucfirst($function_name) . 'FunctionMain';
                                $function_main = ($function_name == 'getList' || $function_name == 'getOne') ?
                                    ($function_name == 'getList' ?
                                        $this->genSelectFunctionMain($file_path, $parameter_arr) :
                                        $this->genSelectFunctionMain($file_path, $parameter_arr, 'one')
                                    ) : $this->$method_name($file_path, $column_variable_type, $parameter_arr);
                            }
                            //合并备注，当函数存在参数且存在函数备注时，将两个备注合并起来
                            //当函数只有参数备注时，只显示参数备注
                            //当函数只有函数备注时，只显示函数备注
                            $code .= !empty($annotation) ?
                                (
                                !empty($parameter_arr) ?
                                    str_replace('/**', str_replace(["*/\r\n", "    /**"], ['*', '/**'], $annotation), $this->genFunction(substr($key, 0, stripos($key, '_')), $function_name, $parameter_arr, $function_main)) :
                                    $annotation . $this->genFunction(substr($key, 0, stripos($key, '_')), $function_name, $parameter_arr, $function_main)) :
                                $this->genFunction(substr($key, 0, stripos($key, '_')), $function_name, $parameter_arr, $function_main);
                        }
                        break;
                }
            }
        }
        return str_replace("#", "\r\n", $code) . '}';
    }

    /**
     * 生成构造参数
     * @param string $file_path
     * @param array $parameters
     * @return string
     */
    private function __genConstruct($file_path = '', $parameters = []){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(str_replace("Transformer", "", substr($file_path, strrpos($file_path, '/')+1, strrpos($file_path, '.') - strrpos($file_path, '/') - 1)));
            $real_parameter = '';
            foreach ($parameters['arr'] as $index => $item){
//                if(strpos($index, '#table_name#') !== false){
//                    $real_parameter = str_replace("#table_name#", $table_name . "_", $index);
//                    $parameter_arr = [[str_replace("#table_name#", $table_name . "_", $index) => $item]];
//                }
                if(strpos($item[3], '#table_name#') !== false){
                    $real_parameter = $item[3] = str_replace("#table_name#", $table_name . "_", $item[3]);
                    $parameter_arr[] = $item;
                }
            }
            $function_main = "\$this->" . $table_name . "_model = \$" . $real_parameter . ";#        parent::__construct();";
            $code .= $this->genConstruct($function_main, [$parameter_arr]);
        }
        return $code;
    }

    public function genSingleDataFunctionMain($file_path, $parameters = []){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(str_replace("Transformer", "", substr($file_path, strrpos($file_path, '/')+1, strrpos($file_path, '.') - strrpos($file_path, '/') - 1)));
            $code ="    if(\$this->". $table_name ."_model instanceof Exception)";
//            $code .= "#        return json_encode(['errno' => \$this->". $table_name ."_model->getCode(), 'errmsg' => \$this->". $table_name ."_model->getMessage(), 'result' => new \\stdClass()]);";
            $code .= "#        throw \$this->" . $table_name . "_model;";
            $code .= "#    return \$this->_getData(\$this->". $table_name ."_model);";
        }
        return $code;
    }

    public function genBackEndDataFunctionMain($file_path, $parameters = []){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(str_replace("Transformer", "", substr($file_path, strrpos($file_path, '/')+1, strrpos($file_path, '.') - strrpos($file_path, '/') - 1)));
            $code ="    if(\$this->" . $table_name . "_model instanceof Exception)";
//            $code .= "#        return json_encode(['errno' => \$this->" . $table_name . "_model->getCode(), 'errmsg' => \$this->" . $table_name . "_model->getMessage(), 'result' => new \\stdClass()]);";
            $code .= "#          throw \$this->" . $table_name . "_model;";
            $code .= "##    \$return = [];";
            $code .= "#    if(is_array(\$this->" . $table_name . "_model->data)){";
            $code .= "#        foreach (\$this->" . $table_name . "_model->data as \$index => \$" . $table_name . "_model){";
            $code .= "#            \$return[\$index] = \$this->_getData(\$" . $table_name . "_model, true);";
            $code .= "#            if(\$for_sorted_set_use === true){";
            $code .= "#                \$return[\$index] = \$return[\$index]['id'];";
            $code .= "#            }";
            $code .= "#        }";
            $code .= "#    }";
            $code .= "##    return [";
            $code .= "#        'data' => \$return,";
            $code .= "#        'meta' => json_decode(json_encode(\$this->" . $table_name . "_model->meta, true), true)";
            $code .= "#    ];";
        }
        return $code;
    }


    /**
     * 生成函数注释
     * @param string $annotation 注释内容
     * @param string $file_path 表名
     * @return mixed|string
     */
    protected function _setFunctionAnnotation($annotation = '', $file_path = ''){
        $return = '';
        if(!empty($annotation) && !empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $return = $this->genAnnotation(str_replace(['#', 'table_name'], ['', $table_name], $annotation));
        }
        return $return;
    }

    /**
     * @param string $file_path
     * @param string $operation
     * @return $this
     */
    public function setColumnArr($file_path = '', $operation = '')
    {
        if(!empty($file_path)){
            $table_name = strtolower(str_replace('Transformer', '', substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $this->__column_arr = $this->_getTableConstruct($table_name);
            if(/*$operation !== 'delete'*/$operation === 'create'){
                foreach($this->__column_arr as $index => $value_arr){
                    if($value_arr['Key'] == 'PRI' && $value_arr['Extra'] == 'auto_increment'){
                        unset($this->__column_arr[$index]);
                    }
                }
            }
        }
        return $this;
    }

}
