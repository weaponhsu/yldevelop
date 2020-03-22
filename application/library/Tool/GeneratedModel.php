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
 * Date: 2017/1/16
 * Time: 下午8:16
 */
class GeneratedModel extends GeneratedCode
{
//    private $__column_arr = [];

    public $obj;
    public $data;
    public $meta;
    public $page = 0;
    public $page_size = 0;
    public $primary_key_arr = ['id'];
    protected $_code_arr = [
        'start' => '<?php',
        'namespace' => 'models\\DAO',
        'use' => [
            'ErrorMsg\\Api\\#table_name#ErrorMsg',
            'Yaf\\Exception',
            'Doctrine\\DBAL\\Driver\\PDOStatement'
        ],
        'class' => 'class #class_name# extends BaseModel{',
        'protected_variable' => [
//            '#table_name#' => ['', 'string', '查询返回结果'],
            '#column#' => ['', 'string', '字段']
        ],
        'public_variable' => [
            'obj' => ['', 'string', 'DAO对象'],
            'data' => ['', 'array', 'DAO对象数组'],
            'meta' => ['', 'object', '翻页对象'],
            'page' => ['1', 'integer', '当前页'],
            'page_size' => ['10', 'integer', '每页显示条数'],
            'primary_key_arr' => ['', 'array', '主键数组'],
            'instance' => ['null', 'static', '单例实例']
        ],
        'private_variable' => [],
        'construct' => 'parent::__construct(str_replace("Model", "", substr(get_class($this), strrpos(get_class($this), "\\\\")+1)));#        $this->meta = new \\stdClass();',
//        'construct' => 'parent::__construct(#table_name#);#        $this->meta = new \\stdClass();',
        'public_function' => [
            'batchDelete' => [
                'function' => '',
                'annotation' => '批量删除#table_name#',
//                'array' => ['', 'array', '要删除的主键数组']
                'arr' => [
                    ['', 'array', '要删除的主键数组', 'array']
                ]
            ],
            '__set' => [
                'function' => '',
                'annotation' => 'set属性',
                'arr' => [
                    ['', 'string', '参数名', 'name'],
                    ['', 'string', '参数值', 'value'],
                ]
//                'name' => ['', 'string', '参数名'],
//                'value' => ['', 'string', '参数值']
            ],
            '__get' => [
                'function' => '',
                'annotation' => 'get属性',
                'arr' => [
                    ['', 'string', '参数名', 'name']
                ],
//                'name' => ['', 'string', '参数名']
            ],
            'insert' => [
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
            'batchInsert' => [
                'function' => '',
                'annotation' => '批量插入#table_name#',
//                'array' => ['', 'array', '要插入表的数组，一条记录一个数组，每个数组里，column为键，value为值']
                'arr' => [
                    ['', 'array', '要插入表的数组，一条记录一个数组，每个数组里，column为键，value为值', 'array']
                ]
            ],
            'find' => [
                'function' => '',
                'annotation' => '根据主键查询#table_name#，获取单条记录',
//                'id' => ['0', 'integer', '主键编号']
                'arr' => [
                    ['0', 'integer', '主键编号', 'id']
                ]
            ],
            'findBy' => [
                'function' => '',
                'annotation' => '根据条件数组查询#table_name#，获取多条记录',
//                'condition' => ['', 'array', '查询条件']
                'arr' => [
                    ['', 'array', '查询条件', 'condition']
                ]
            ],
            'findOneBy' => [
                'function' => '',
                'annotation' => '根据条件数组查询#table_name#，获取多条记录',
//                'condition' => ['', 'array', '查询条件']
                'arr' => [
                    ['', 'array', '查询条件', 'condition']
                ]
            ],
            'findAll' => [
                'function' => '',
                'annotation' => '查询#table_name#全表'
            ],
            'genBatchUpdateSql' => [
                'function' => '',
                'annotation' => '生成批量生成update的sql',
                'arr' => [
                    ['', 'array', '666', 'update_column']
                ]
            ],
        ],
        'protected_function' => [],
        'private_function' => [
            'setColumnValue' => [
                'function' => '',
                'annotation' => '根据方法名，调用__set方法，将service传入的属性名称，赋值给对应model的属性',
//                'method' => ['', 'string', 'model下的方法名']
                'arr' => [
                    ['', 'string', 'model下的方法名', 'method']
                ]
            ]
        ]
    ];

    public function generatedModelCode($file_path = ''){
        $code = '';
        $column_variable_type = 'private';
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
                                $table_name = ucfirst(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
                                $table_name = str_replace('Model', '', $table_name);
                                $element[$id] = str_replace('#table_name#', $table_name, $use_namespace);
                            }
                        }
                        $code .= $this->genUseCode($element);
                        break;
                    case 'class':
                        $table_name = substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, 'Model.php') - 1 - strrpos($file_path, '/')));
                        $code .= $this->genSwgAnnotation(strtolower($table_name));
                        $code .= $this->genClass($element, $file_path);
                        break;
                    case 'public_variable':
                    case 'protected_variable':
                    case 'private_variable':
                        foreach($element as $variable_name => $element_arr){
                            if($variable_name == '#column#'){
                                $code .= $this->genModelVariable('public', [], $file_path);
                            }else{
                                if($variable_name == '#table_name#'){
                                    $variable_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
                                }
                                $code .= $this->genVariable(substr($key, 0, stripos($key, '_')),[$variable_name => empty($element_arr) ? ['', 'string', ''] : $element_arr]);
                            }

                            if($variable_name == 'instance'){
                                //getInstance方法
                                $function_name = 'get' . ucfirst($variable_name);
                                $model_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
                                $function_main = '    if(is_null(self::$instance)){#        self::$instance = new self(\'' . str_replace('model', '', $model_name) . '\');'.
                                    '#    }#    return self::$instance;';
//                                $function_main = '#    if(is_null(self::$instance)){#        self::$instance = new self();#    }##    return self::$instance;';
                                $code .= $this->genFunction(
                                    substr($key, 0, stripos($key, '_')),
                                    $function_name,
                                    [[$variable_name => $element_arr]],
                                    $function_main
                                );

                                //clone方法
                                $function_name = '__clone';
                                $error_msg_file_name = ucfirst(str_replace('model', '', $table_name));
                                $function_main = '    throw new Exception(#        str_replace(\'%s\', get_class($this), ' . $error_msg_file_name
//                                $function_main = '    return new Exception(#        str_replace(\'%s\', get_class($this), ' . $error_msg_file_name
                                    . 'ErrorMsg::INSTANCE_NOT_ALLOW_TO_CLONE),'.
                                    '#        ' . $error_msg_file_name . 'ErrorMsg::INSTANCE_NOT_ALLOW_TO_CLONE_NO);';
                                $code .= $this->genFunction('public', $function_name, [], $function_main);

                                //__destruct方法
                                $function_name = '__destruct';
                                $function_main = '    self::$instance = null;';
                                $code .= $this->genFunction('public', $function_name, [], $function_main);
                            }
                        }
                        break;
                    case 'construct':
//                        $method = 'gen' . ucfirst($key);
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
//                                    $parameter_arr[] = [$k => $v];
                                    $parameter_arr = $v;
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
                                $method_name = 'gen' . (stripos($function_name, '__') !== false ?
                                        ucfirst(substr($function_name, stripos($function_name, '__') + 2)) :
                                        ucfirst($function_name)) . 'FunctionMain';
                                $function_main = $this->$method_name(substr($key, 0, stripos($key, '_')), $parameter_arr, $file_path);
                            }
                            //合并备注，当函数存在参数且存在函数备注时，将两个备注合并起来
                            //当函数只有参数备注时，只显示参数备注
                            //当函数只有函数备注时，只显示函数备注
                            $code .= !empty($annotation) ?
                                (
                                !empty($parameter_arr) ?
                                    str_replace(
                                        '/**',
                                        str_replace(
                                            ["*/\r\n", "    /**"],
                                            ['*', '/**'],
                                            $annotation
                                        ),
                                        $this->genFunction(
                                            substr($key, 0, stripos($key, '_')),
                                            $function_name,
                                            [[$parameter_arr]],
                                            $function_main
                                        )
                                    ) :
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
     * 生成setColumnValue方法代码
     * @return string
     */
    public function genSetColumnValueFunctionMain(){
        $code = "    \$method = !empty(\$method) && is_string(\$method) && in_array(\$method, ['insert', 'update', 'delete']) ?
            \$method : '';";
        $code .= "#    \$array = [];";
        $code .= "#    if(!empty(\$method)){";
        $code .= "#        foreach (get_object_vars(\$this) as \$column => \$value){";
//        $code .= "#            if(\$method == 'delete'){";
//        $code .= "#                if(in_array(substr(\$column, stripos(\$column, '_') + 1), \$this->primary_key_arr))";
//        $code .= "#                    \$array[substr(\$column, stripos(\$column, '_') + 1)] = \$value;";
//        $code .= "#                }else if(\$method == 'update'){";
//        $code .= "#                    \$array[substr(\$column, stripos(\$column, '_') + 1)] = (strpos(\$column, '_access') !== false && is_array(\$value) ?";
//        $code .= "#                        serialize(\$value) : \$value);";
//        $code .= "#            }else{";
//        $code .= "#                \$array[substr(\$column, stripos(\$column, '_') + 1)] = \$value;";
//        $code .= "#            }";
        $code .= "#            if(stripos(\$column, '_') === 0 && \$value !== null){";
        $code .= "#                if(\$method == 'delete'){";
        $code .= "#                    if(in_array(substr(\$column, stripos(\$column, '_') + 1), \$this->primary_key_arr))";
        $code .= "#                        \$array[substr(\$column, stripos(\$column, '_') + 1)] = \$value;";
        $code .= "#                }else if(\$method == 'update'){";
        $code .= "#                    \$array[substr(\$column, stripos(\$column, '_') + 1)] = (strpos(\$column, '_access') !== false && is_array(\$value) ?";
        $code .= "#                        serialize(\$value) : \$value);";
        $code .= "#//                    echo json_encode(\$column);";
        $code .= "#                }else{";
        $code .= "#                    \$array[substr(\$column, stripos(\$column, '_') + 1)] = \$value;";
        $code .= "#                }";
        $code .= "#            }";
//        $code .= "#            if(stripos(\$column, '_') === 0 && !empty(\$value)){";
//        $code .= "#                if(\$method == 'delete' && in_array(substr(\$column, stripos(\$column, '_') + 1), \$this->primary_key_arr)){";
//        $code .= "#                    \$array[substr(\$column, stripos(\$column, '_') + 1)] = \$value;";
//        $code .= "#                }else if(\$method == 'update'){";
//        $code .= "#                    \$array[substr(\$column, stripos(\$column, '_') + 1)] = (strpos(\$column, '_access') !== false && is_array(\$value) ?";
//        $code .= "#                        serialize(\$value) : \$value);";
//        $code .= "#                }else{";
//        $code .= "#                    \$array[substr(\$column, stripos(\$column, '_') + 1)] = \$value;";
//        $code .= "#                }";
//        $code .= "#            }";
        $code .= "#        }";
        $code .= "#    }";
        $code .= "#    return \$array;";

        return $code;
    }

    /**
     * 生成插入方法代码
     * @return string
     */
    public function genInsertFunctionMain(){
        return $this->_genCrudMethod('insert');
    }

    /**
     * 生成更新方法代码
     * @return string
     */
    public function genUpdateFunctionMain(){
        return $this->_genCrudMethod('update');
    }

    /**
     * 生成删除方法代码
     * @return string
     */
    public function genDeleteFunctionMain(){
        return $this->_genCrudMethod('delete');
    }

    /**
     * @param string $type
     * @param array $parameters
     * @param string $file_path
     * @return string
     */
    public function genBatchDeleteFunctionMain($type = 'public', $parameters = [], $file_path = ''){
        $real_parameters_arr = [];
        if(!empty($parameters) && is_array($parameters)){
            $real_parameters_arr = [];
            foreach ($parameters as $index => $item){
//                foreach ($item as $parameter_name => $parameter_value_arr){
//                    $real_parameters_arr[] = strtolower($parameter_name);
//                }
                $real_parameters_arr[] = strtolower($item[3]);
            }
        }
        return $this->_genCrudMethod('batchDelete', implode(',', $real_parameters_arr));
    }

    /**
     * 生成批量插入代码
     * @param string $type
     * @param array $parameters
     * @param string $file_path
     * @return string
     */
    public function genBatchInsertFunctionMain($type = "public", $parameters = [], $file_path = ""){
        $code = "";
        if(!empty($parameters)){
            $real_parameters_arr = [];
            if(!empty($parameters) && is_array($parameters)){
                $real_parameters_arr = [];
                foreach ($parameters as $index => $item){
                    $real_parameters_arr[] = strtolower($item[3]);
//                    foreach ($item as $parameter_name => $parameter_value_arr){
//                        $real_parameters_arr[] = strtolower($parameter_name);
//                    }
                }
            }
            if(!empty($real_parameters_arr)){
                $real_parameter = implode(',', $real_parameters_arr);
                $code = "    foreach (\$" . $real_parameter . " as \$index => \$column_value_arr){".
                    "#        foreach (\$column_value_arr as \$column => \$value){".
                    "#            if(property_exists(\$this, '_' . \$column) !== true){".
                    "#                unset(\$array[\$index][\$column]);".
                    "#            }".
                    "#        }".
                    "#    }".
                    "#    return parent::batchInsert(\$" . $real_parameter . ");";
            }
        }
        return $code;
    }

    /**
     * 生成新增，删除，更新代码
     * @param string $method
     * @param string $parameters
     * @return string
     */
    protected function _genCrudMethod($method = '', $parameters = ''){
        $method = !empty($method) && in_array($method, ['insert', 'update', 'delete', 'batchDelete']) ?
            $method : '';
        $code = '';
        if(!empty($method)){
            if(strpos($method, 'batch') !== false){
                $code = "    return parent::" .
                    (strpos($method, 'batch') == 0 ?
                        strtolower(substr($method, strpos($method, 'batch') + 5)) :
                        strtolower(substr($method, 0, (strlen($method) - strpos($method, 'batch'))))
                    ) . "Record(\$" . $parameters . ");";
            }else{
                $code = "    return parent::" . strtolower($method) . "Record(\$this->__setColumnValue(strtolower(__FUNCTION__)));";
            }
        }
        return $code;
    }

    public function genFindOneByFunctionMain($type, $parameters = [], $file_path = ''){
        $real_parameters_arr = [];
        if(!empty($parameters) && is_array($parameters)){
            $real_parameters_arr = [];
            foreach ($parameters as $index => $item){
                $real_parameters_arr[] = strtolower($item[3]);
//                foreach ($item as $parameter_name => $parameter_value_arr){
//                    $real_parameters_arr[] = strtolower($parameter_name);
//                }
            }
        }
        return $this->genSelectSingleFunctionMain('findOneBy', implode(',', $real_parameters_arr), $file_path);

    }

    public function genFindFunctionMain($type, $parameters = [], $file_path = ''){
        $real_parameters_arr = [];
        if(!empty($parameters) && is_array($parameters)){
            $real_parameters_arr = [];
            foreach ($parameters as $index => $item){
                $real_parameters_arr[] = strtolower($item[3]);
//                foreach ($item as $parameter_name => $parameter_value_arr){
//                    $real_parameters_arr[] = strtolower($parameter_name);
//                }
            }
        }
        return $this->genSelectSingleFunctionMain('find', implode(',', $real_parameters_arr), $file_path);

    }

    public function genFindAllFunctionMain($type, $parameters = [], $file_path = ''){
        $real_parameters_arr = [];
        if(!empty($parameters) && is_array($parameters)){
            $real_parameters_arr = [];
            foreach ($parameters as $index => $item){
                $real_parameters_arr[] = strtolower($item[3]);
//                foreach ($item as $parameter_name => $parameter_value_arr){
//                    $real_parameters_arr[] = strtolower($parameter_name);
//                }
            }
        }
        return $this->genSelectFunctionMain('findAll', implode(',', $real_parameters_arr), $file_path);
    }

    public function genFindByFunctionMain($type, $parameters = [], $file_path = ''){
        $real_parameters_arr = [];
        if(!empty($parameters) && is_array($parameters)){
            $real_parameters_arr = [];
            foreach ($parameters as $index => $item){
                $real_parameters_arr[] = strtolower($item[3]);
//                foreach ($item as $parameter_name => $parameter_value_arr){
//                    $real_parameters_arr[] = strtolower($parameter_name);
//                }
            }
        }
        return $this->genSelectFunctionMain('findBy', implode(',', $real_parameters_arr), $file_path);
    }

    public function genSelectSingleFunctionMain($function_name = '', $parameters = '', $file_path = '')
    {
//        print_r(func_get_args());
//        exit();
        $function_name = !empty($function_name) && in_array($function_name, ["find", "findOneBy"]) ?
            $function_name : '';

        $code = '';
        if (!empty($function_name)) {
//            $code = "    \$result = parent::" . ($function_name == "find" ? "find(\$" . $parameters . ")" : "findBy(\$" . $parameters . ")") . ";";
            $code = "    \$result = parent::" . ($function_name == "find" ? "find(\$" . $parameters . ")" : "findRecordBy(\$" . $parameters . ")") . ";";
//            $code .= "#    if(\$result instanceof Exception" . ($function_name == "find" ? "" : " || !\$result instanceof PDOStatement") . ") return \$result;";
//            $code .= "#    if(\$result instanceof Exception" . ") throw \$result;";
            $code .= "##    \$this->setModelProperty(\$result);";
            $code .= "#    return \$this;";
        }
        return $code;
    }

    public function genSelectFunctionMain($function_name = '', $parameters = '', $file_path = ''){
        $table_name = ucfirst(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, 'Model'))));
        $object_name = strtolower($table_name) . '_obj';
        $function_name = !empty($function_name) && in_array($function_name, ["findAll", "findBy"]) ?
            $function_name : '';

        $code = $code_suffix = $code_prefix = '';
        if(!empty($function_name)){
            if($function_name == 'findBy'){
//                $code = "    \$count = parent::getCount(\$condition);#    if(\$count instanceof Exception) return \$count;#    \$total = \$count->fetchColumn();##";
                $code = "    \$count = parent::getCount(\$condition);#    \$total = \$count->fetchColumn();##";
                $code .= "    \$" . $object_name . " = parent::findRecordBy(\$". $parameters . ", \$this->page, \$this->page_size);";
                /*$code = "    \$count = parent::getCount(\$". $parameters .");";
                $code = "    \$count = parent::getCount(\$". $parameters .");";
                $code .= "#    \$total = \$count->fetchObject()->total;";
                $code .= "#    if(\$total > 0){";
                $code .= "#        \$" . $object_name . " = parent::findBy(\$" . $parameters . ", \$this->page, \$this->page_size);";
                $code_suffix = "}";
                $code_prefix = "    ";*/
            }else{
//                $code = "    \$count = parent::getCount();#    if(\$count instanceof Exception) return \$count;#    \$total = \$count->fetchColumn();##";
                $code = "    \$count = parent::getCount();#    \$total = \$count->fetchColumn();##";

//                $code .= "    \$" . $object_name . " = parent::findAll('', '', \$this->page, \$this->page_size);";
                $code .= "    \$" . $object_name . " = parent::findAllRecord('', '', \$this->page, \$this->page_size);";
            }
//            $code .= "#    " . $code_prefix . "if(\$" . $object_name . " instanceof Exception) return \$" . $object_name . ";";
//            $code .= "##    " . $code_prefix . "\$this->genMeta(" . (/*$function_name == 'findBy' ? "\$total" : */"\$" . $object_name . "->columnCount()"/*"->rowCount()"*/) . ");";
            $code .= "##    " . $code_prefix . "\$this->genMeta(\$total);";
            $code .= "#    " . $code_prefix . "\$this->setModelProperty(\$" . $object_name . ", true);";
            $code .= "#    " . $code_suffix;
            $code .= "#    return \$this;";
        }
        return $code;
    }

    public function genGenBatchUpdateSqlFunctionMain($function_name = '', $parameters = '', $file_path = ''){
        $code = '';
        if(! empty($file_path)){
//            $table_name = ucfirst(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, 'Model'))));
            $table_name = ucfirst(str_replace('Model.php', '', substr($file_path, strrpos($file_path, '/')+1)));
            $code .= "    if(empty(\$update_column))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_UPDATE_EMPTY_CONDITION,";
            $code .= "#            " . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_UPDATE_EMPTY_CONDITION_NO);";
            $code .= "##    \$sql = \$this->_genBatchUpdateSql(\$update_column);";
            $code .= "#    if(\$sql === false)";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_UPDATE_RETURN_FALSE,";
            $code .= "#            " . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_UPDATE_RETURN_FALSE_NO);";
            $code .= "##    \$batch_update_res = \$this->query(\$sql);";
            $code .= "#    return \$batch_update_res->rowCount();";
//            $code .= "##    if(\$batch_update_res instanceof Exception) throw \$batch_update_res;";
//            $code .= "##    if(\$batch_update_res instanceof PDOStatement) return \$batch_update_res->rowCount();";
//            $code .= "##    return false;";
        }
        return $code;
    }
}
