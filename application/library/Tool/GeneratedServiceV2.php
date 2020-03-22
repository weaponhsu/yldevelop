<?php

/**
 * Created by Unknown
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
 * User: MotherFucker
 * Date: 2016-07-08
 * Time: 上午 10:30
 */

require_once __DIR__ . '/GeneratedCode.php';

class GeneratedService extends GeneratedCode
{
    private $__column_arr = [];

    protected $_code_arr = [
        'start' => '<?php',
        'namespace' => 'models\\Service',
        'use' => [
            'ErrorMsg\\Admin\\ErrorMsg',
            'ErrorMsg\\Admin\\ErrorTips',
            'models\\DAO\\#table_name#',
            'Yaf\\Registry',
            'Yaf\\Session',
            'Yaf\\Exception'
        ],
        'class' => 'class #class_name# extends BaseService implements ServiceImpl {',
        'protected_variable' => [
            '#column#' => ['', 'string', '字段'],
        ],
        'public_variable' => [
            '#table_name#model_obj' => ['', 'object', 'model对象'],
            'instance' => ['null', 'static', '单例实例']
        ],
        'private_variable' => [
        ],
        'construct' => '$this->error = 0;#        parent::setDao(#table_name#::getInstance(str_replace(\'Service\', \'\', get_class($this))));',
//        'construct' => '$this->error = 0;#        parent::setDao(new #table_name#());',
        'public_function' => [
            'create' => [
                'function' => '',
                'annotation' => '创建#table_name#'
            ],
            'update' => [
                'function' => '',
                'annotation' => '编辑#table_name#'
            ],
            'delete' => [
                'function' => '',
                'annotation' => '删除#table_name#，需先指定主键'
            ],
            'getResult' => [
                'function' => '',
                'annotation' => '',
                'sql' => ['', 'string', 'sql语句']
            ],
            'batchDelete' => [
                'function' => '',
                'annotation' => '批量删除',
                'arr' => ['', 'array', '要插入表的数组，一条记录一个数组，每个数组里，column为键，value为值']
            ],
            'batchInsert' => [
                'function' => '',
                'annotation' => '批量插入',
                'arr' => ['', 'array', '传入的参数数组']
            ],
            'getList' => [
                'function' => '',
                'annotation' => '传入查询条件，当前页，每页显示条数，排序字段，排序方式，获取列表数据',
                'condition' => ['', 'array', '查询条件'],
                'page' => [1, 'integer', '当前页'],
                'page_size' => [10, 'integer', '每页显示条数'],
                'order' => ['order', 'string', '排序字段'],
                'sort' => ['sort', 'string', '排序方式'],
            ],
            'getOne' => [
                'function' => '',
                'annotation' => '传入查询条件，条件可以为array(参考getList的condition入参)亦可为integer(主键编号)获取单条数据',
                'condition' => [0, 'integer', '查询条件']
            ]
        ],
        'protected_function' => [],
        'private_function' => [
        ]
    ];

    public function generatedServiceCode($file_path = ''){
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
                                $table_name = ucfirst(str_replace("Service", "Model", substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
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
                                $code .= $this->genServiceVariable('public', [], $file_path);
                            }else{
                                $function_name = $function_main = '';
                                $function_name_arr = [];
                                if(strpos($variable_name, '#table_name#') !== false){
                                    $table_name = strtolower(str_replace('Service', '', substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
                                    $variable_name = str_replace("#table_name#", $table_name . '_', $variable_name);
                                    foreach (explode('_', $variable_name) as $index => $value){
                                        $function_name_arr[] = ucfirst($value);
                                    }
                                    if(!empty($function_name_arr)){
                                        $function_name = 'get' . implode('', $function_name_arr);
                                        $function_main = "    return \$this->exception instanceof Exception ? \$this->exception : #        (\$this->error === 0 ? \$this->" . $variable_name . " : \$this->getResult('error'));";
                                    }
                                }
                                if($variable_name == 'instance'){
                                    $function_name = 'get' . ucfirst($variable_name);
                                    $function_main = '#    if(is_null(self::$instance)){#        self::$instance = new self();#    }##    return self::$instance;';
                                }

                                $code .= $this->genVariable(substr($key, 0, stripos($key, '_')), [$variable_name => $element_arr], false);
                                if(!empty($function_name) && !empty($function_main)){
                                    $code .= $this->genFunction(
                                        substr($key, 0, stripos($key, '_')),
                                        $function_name,
                                        strpos($variable_name, $table_name) !== false ? [] : [[$variable_name => $element_arr]],
                                        $function_main
                                    );
                                }
                            }
                        }
                        break;
                    case 'construct':
//                        $method = 'gen' . ucfirst($key);
//                        $function_main = $this->__genConstruct($file_path);
//                        $code .= $this->genConstruct($function_main);
                        if(strpos($element, '#table_name#') !== false){
                            $table_name = ucfirst(str_replace("Service", "Model", substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
                            $element = str_replace("#table_name#", $table_name, $element);
                        }
                        $code .= $this->genConstruct($element);
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

    public function genGetInstanceFunctionMain($file_path = '', $column_variable_type, $parameter_arr){
        var_dump(func_get_args());
    }

    /**
     * @param string $file_path
     * @param string $operation
     * @return $this
     */
    public function setColumnArr($file_path = '', $operation = '')
    {
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
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

    public function genGetResultFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path)){
            $code = "    return \$this->dao->query(\$sql);";
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
     * 生成insert方法的代码
     * @param string $file_path 要生成service的文件名，既表名
     * @param string $type 字段属性的类型，默认值是public
     * @return mixed
     */
    public function genCreateFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(str_replace('Service', '', substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $code = "    \$this->genColumn(strtolower(__FUNCTION__));";
            $code .= "#    \$result = \$this->dao->insert();";
            $code .= "#    if(\$result instanceof Exception)";
            $code .= "#        \$this->exception = \$result;";
            $code .= "#    else";
            $code .= "#        \$this->dao->__set(\"_id\", \$result);";
            $code .= "#        \$this->" . $table_name . "_model_obj = \$this->dao;";
            $code .= "##    return \$this;";
        }
        return $code;
    }

    /**
     * 生成update方法的代码
     * @param string $file_path 要生成service的文件名，既表名
     * @param string $type 字段属性的类型，默认值是public
     * @return mixed
     */
    public function genUpdateFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(str_replace('Service', '', substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));

            $code = "    \$this->genColumn(strtolower(__FUNCTION__));";
            $code .= "#    \$result = \$this->dao->update();";
            $code .= "#    if(\$result instanceof Exception)";
            $code .= "#        \$this->exception = \$result;";
            $code .= "#    else";
            $code .= "#        \$this->" . $table_name . "_model_obj = \$this->dao;";
            $code .= "##    return \$this;";
        }
        return $code;
    }

    /**
     * 生成delete方法
     * @param string $file_path 要生成service的文件名，既表名
     * @param string $type 字段属性的类型，默认值是public
     * @return mixed
     */
    public function genDeleteFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path)){
            $table = strtolower(str_replace("Service", "", substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $code = "    \$this->genColumn(strtolower(__FUNCTION__));";
            $code .= "#    \$result = \$this->dao->delete();";
            $code .= "#    if(\$result instanceof Exception)";
            $code .= "#       \$this->exception = \$result;";
            $code .= "#    else";
            $code .= "#       \$this->" . $table . "_model_obj = \$this->dao;";
            $code .= "##    return \$this;";
        }
        return $code;
    }

    /**
     * 生成batchDelete方法
     * @param string $file_path 要生成service的文件名，即表明
     * @param string $type 函数属性类型，默认值public
     * @param array $parameters_arr 参数列表，将generatedService定义的方法的参数完整传入
     * @return string
     */
    public function genBatchDeleteFunctionMain($file_path = '', $type = 'public', $parameters_arr = []){
        $code = "";
        if(!empty($file_path) && !empty($parameters_arr)){
            $parameter_name_arr = [];
            foreach ($parameters_arr as $item){
                foreach ($item as $parameter_name => $parameter_value){
                    $parameter_name_arr[] = $parameter_name;
                }
            }
            if(!empty($parameter_name_arr)){
                $code = "    \$array = !empty(\$" . $parameter_name_arr[0] . ") && is_array(\$"  . $parameter_name_arr[0] .  ") ? \$" . $parameter_name_arr[0] . " : '';";
                $code .= "#    if(empty(\$array)) return new Exception('参数类型不合法');";
                $code .= "##    foreach (\$array as \$column => \$value){";
                $code .= "#        if(is_string(\$value) && strpos(\$value, ','))";
                $code .= "#            \$array[\$column] = explode(',', \$value);";
                $code .= "#    }";
                $code .= "##    return \$this->dao->batchDelete(\$array);";
            }
        }
        return $code;
    }

    public function genBatchInsertFunctionMain($file_path = '', $type = 'public', $parameters_arr = []){
        $code = "";
        if(!empty($file_path) && !empty($parameters_arr)){
            $parameter_name_arr = [];
            foreach ($parameters_arr as $item){
                foreach ($item as $parameter_name => $parameter_value){
                    $parameter_name_arr[] = $parameter_name;
                }
            }
            if(!empty($parameter_name_arr)){
                $code = "    \$array = !empty(\$" . $parameter_name_arr[0] . ") && is_array(\$"  . $parameter_name_arr[0] .  ") ? \$" . $parameter_name_arr[0] . " : '';";
                $code .= "#    if(empty(\$array)) return new Exception('参数类型不合法');";
                $code .= "##    return \$this->dao->batchInsert(\$array);";
            }
        }
        return $code;
    }

    /**
     * @param string $file_path
     * @param array $parameter_arr
     * @param string $one_or_all
     * @return mixed
     */
    public function genSelectFunctionMain($file_path = '', $parameter_arr = [], $one_or_all = 'all'){
        $code = $code_prefix = $code_suffix = $code_parameter = '';
        if(!empty($file_path)){
            $table_name = strtolower(str_replace("Service", "", substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $real_parameter_arr = $condition_arr = [];
            foreach ($parameter_arr as $index => $item){
                foreach ($item as $column => $parameter_value_arr){
                    $real_parameter_arr[] = $column;
                    if(strpos($column, 'size') !== false){
                        $code_parameter .= "#    \$" . $column . " = !empty(\$" . $column . ") ? " . ($parameter_value_arr[1] == 'integer' ? "intval(\$" . $column . ")" : "\$" . $column) . " : " . $parameter_value_arr[0] . ";";
                        $code .= "#        ->__set('" . $column . "', \$". $column .")";
                    }else if(strpos($column, 'page') !== false){
                        $code_parameter .= "#    \$" . $column . " = !empty(\$" . $column . ") ? " . ($parameter_value_arr[1] == 'integer' ? "intval(\$" . $column . ")" : "\$" . $column) . " : " . $parameter_value_arr[0] . ";";
                        $code .= "#        ->__set('" . $column . "', \$" . $column . ")";
                    }else if(strpos($column, 'order') !== false){
                        $code .= "#        ->setOrderBy(['" . $column . "' => \$" . $parameter_value_arr[0] . ",";
                    }else if(strpos($column, 'sort') !== false){
                        $code .= " '" . $column . "' => \$" . $parameter_value_arr[0] . "])";
                    }else if(strpos($column, 'condition') !== false){
                        $condition_arr = ['condition' => $column, 'parameters' => $parameter_value_arr];
                    }
                }
            }
            if(!empty($condition_arr)){

                if($one_or_all == 'all'){
                    $code_prefix = $code_parameter . "#    \$result = \$this->dao";
                    $code .= "#        ->findBy(\$" . $condition_arr['condition'] . ");";
                    $code_suffix = "##    return \$result;";
                    $code .='#      //生成处理序列化代码';
                    $code .='#    if($result instanceof '.ucfirst($table_name).'Model){';
                    $code .= "#        \$this->serializeImage();";
                    $code .= "#    }";
//                    $code .='#    if($result instanceof '.ucfirst($table_name).'Model){
//            foreach ($result->data as $key=> $value){
//                foreach(get_object_vars($value) as $var => $val){
//                    if(strpos($var, \'thumb\') !== false || ($var === \'_album\' && ($var != \'_album_id\'))
//                        || strpos($var, \'avatar\') !== false){
//                            $getName=\'get\'.ucfirst(substr($var,1));
//                            $result->data[$key]->__set($var,$this->$getName($val)->$var);
//                        }
//                }
//            }
//        }';
                }else{
                    $code_prefix = "    if(is_array(\$" . $condition_arr['condition'] . ")){";
                    $code_prefix .= "#        \$this->" . $table_name . "_model_obj = \$this->dao->findOneBy(\$" . $condition_arr['condition'] . ");";
//                    $code_prefix .= "#       foreach (get_object_vars(\$this->".$table_name."_model_obj) as \$var=> \$value){
//                if(strpos(\$var, 'thumb') !== false || (\$var === '_album' && (\$var != '_album_id'))
//                        || strpos(\$var, 'avatar') !== false){
//                        \$getName='get'.ucfirst(substr(\$var,1));
//                    \$this->".$table_name."_model_obj->__set(\$var,\$this->\$getName(\$value)->\$var);
//                }
//            }";
                    $code_prefix .= "#    }else{";
                    $code_prefix .= "#        \$this->" . $table_name . "_model_obj = \$this->dao->find(\$" . $condition_arr['condition'] . ");";
                    $code_prefix .= "#    }";
                    $code_prefix .= "#    if(! \$this->" . $table_name . "_model_obj instanceof Exception)  \$this->serializeImage();";
//                    $code_prefix .= "#       foreach (get_object_vars(\$this->".$table_name."_model_obj) as \$var=> \$value){
//                if(strpos(\$var, 'thumb') !== false || (\$var === '_album' && (\$var != '_album_id'))
//                        || strpos(\$var, 'avatar') !== false){
//                        \$getName='get'.ucfirst(substr(\$var,1));
//                    \$this->".$table_name."_model_obj->__set(\$var,\$this->\$getName(\$value)->\$var);
//                }
//            }";
                    $code_suffix = "#    return \$this;";
                }

            }
        }

        return $code_prefix . $code . $code_suffix;
    }
}