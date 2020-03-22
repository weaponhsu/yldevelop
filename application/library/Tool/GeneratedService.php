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
            'ErrorMsg\\Api\\#table_name#ErrorMsg',
            'models\\DAO\\#table_name#Model',
            'models\\Transformer\\#table_name#Transformer',
            'Yaf\\Registry',
            'Yaf\\Exception'
        ],
        'class' => 'class #class_name# {',
        'private_variable' => [
            'primary_index' => ['#primary_index#', '', ''],
            'unique_index' => ['#unique_index#', '', ''],
            'list_sorted_set_cache_name_prefix' => ['#table_name#:list', 'string', '列表缓存sortedSet'],
            'single_string_cache_name_prefix' => ['admin:#table_name#', 'string', '单条数据缓存string'],
        ],
        'public_variable' => [
            'instance' => ['null', 'static', '单例']
        ],
//        'construct' => '$this->error = 0;#        parent::setDao(#table_name#::getInstance(str_replace(\'Service\', \'\', get_class($this))));',
//        'construct' => '$this->error = 0;#        parent::setDao(new #table_name#());',
        'construct' => '$this->error = 0;',
        'public_function' => [
            'create' => [
                'function' => '',
                'annotation' => "插入记录",
                'arr' => [
                    ['#column#'],
                    ['false', 'boolean', '是否删除缓存', 'cache'],
                    ['', 'string', '缓存名称', 'cache_name'],
                    ['86400', 'integer', 'redis有效期', 'expire'],
                ]
            ],
            'delete' => [
                'function' => '',
                'annotation' => "删除记录",
                'arr' => [
                    ['#column#'],
                    ['false', 'boolean', '是否删除缓存', 'cache'],
                    ['', 'string', '缓存名称', 'cache_name'],
                    ['86400', 'integer', 'redis有效期', 'expire'],
                ]
            ],
            'update' => [
                'function' => '',
                'annotation' => '更新记录',
                'arr' => [
                    ['', 'array', '[\'column1\' => \'new_value1\', \'column2\' => \'new_value2\', ...]', 'update_column'],
                    ['#column#'],
                    ['false', 'boolean', '是否删除缓存', 'cache'],
                    ['', 'string', '缓存名称', 'cache_name'],
                    ['86400', 'integer', 'redis有效期', 'expire'],
                ]
            ],
//            'getResult' => [
//                'function' => '',
//                'annotation' => '',
//                'sql' => ['', 'string', 'sql语句']
//            ],
//            'batchDelete' => [
//                'function' => '',
//                'annotation' => '批量删除',
//                'arr' => ['', 'array', '要插入表的数组，一条记录一个数组，每个数组里，column为键，value为值']
//            ],
//            'batchInsert' => [
//                'function' => '',
//                'annotation' => '批量插入',
//                'arr' => ['', 'array', '传入的参数数组']
//            ],
            'getList' => [
                'function' => '',
                'annotation' => '传入查询条件，当前页，每页显示条数，排序字段，排序方式，获取列表数据',
                'arr' => [
                    [1, 'integer', '查询条件', 'page'],
                    [20, 'integer', '每页显示条数', 'page_size'],
                    ['desc', 'string', '排序方式', 'sort'],
                    ['id', 'string', '排序字段', 'order'],
                    ['', 'array', '查询条件', 'condition'],
                    ['false', 'boolean', '是否删除缓存', 'cache'],
                    ['', 'string', '缓存名称', 'cache_name'],
                    ['86400', 'integer', 'redis有效期', 'expire'],
                ]
            ],
            'getOne' => [
                'function' => '',
                'annotation' => '传入查询条件，条件可以为array(参考getList的condition入参)亦可为integer(主键编号)获取单条数据',
                'arr' => [
//                    ['#column#'],
                    ['', 'array', '查询条件', 'condition'],
                    ['false', 'boolean', '是否删除缓存', 'cache'],
                    ['', 'string', '缓存名称', 'cache_name'],
                    ['86400', 'integer', 'redis有效期', 'expire'],
                ]
            ],
            'batchUpdate' => [
                'function' => '',
                'annotation' => '批量删除',
                'arr' => [
                    ['', 'array', '666', 'update_column'],
                    ['', 'array', 'id', 'id'],
                    ['false', 'boolean', '是否删除缓存', 'cache'],
                    ['', 'string', '缓存名称', 'cache_name'],
                    ['86400', 'integer', 'redis有效期', 'expire'],
                ]
            ],
            'batchInsert' => [
                'function' => '',
                'annotation' => '批量插入',
                'arr' => [
                    ['', 'array', '传入的参数数组', 'arr'],
                    ['false', 'boolean', '是否删除缓存', 'cache'],
                    ['86400', 'integer', 'redis有效期', 'expire'],
                ]
            ],
            'batchDelete' => [
                'function' => '',
                'annotation' => '批量删除',
                'arr' => [
                    ['', 'array', '要插入表的数组，一条记录一个数组，每个数组里，column为键，value为值', 'arr'],
                    ['false', 'boolean', '是否删除缓存', 'cache'],
                    ['86400', 'integer', 'redis有效期', 'expire'],
                ]
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
                                $table_name = ucfirst(str_replace("Service", "", substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
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
                            }elseif($variable_name == 'unique_index'){
                                foreach ($this->__column_arr as $column_info){
                                    if($column_info['Key'] == 'UNI'){
                                        $type = str_replace('_variable', '', $key);
                                        $code .= $this->genVariable($type, [$variable_name => [$column_info['Field'], 'string', $column_info['Comment']]], false);
                                        break;
                                    }
                                }
                            }
                            elseif($variable_name == 'primary_index'){
                                foreach ($this->__column_arr as $column_info){
                                    if($column_info['Key'] == 'PRI'){
                                        $type = str_replace('_variable', '', $key);
                                        $code .= $this->genVariable($type, [$variable_name => [$column_info['Field'], 'string', $column_info['Comment']]], false);
                                        break;
                                    }
                                }
                            }
//                            elseif($variable_name == 'list_sorted_set_cache_name_prefix'){
                            elseif(in_array($variable_name, ['list_sorted_set_cache_name_prefix', 'single_string_cache_name_prefix'])){
                                $type = str_replace('_variable', '', $key);
                                $table_name = strtolower(str_replace('Service', '', substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
                                $element_arr[0] = str_replace('#table_name#', $table_name, $element_arr[0]);
                                $code .= $this->genVariable($type, [$variable_name => $element_arr], false);
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
//                                    ($function_name == 'getList' ?
//                                        $this->genSelectFunctionMain($file_path, $parameter_arr) :
//                                        $this->genSelectFunctionMain($file_path, $parameter_arr, 'one')
//                                    ) :
                                    $this->genSelectFunctionMain($file_path, $parameter_arr, $function_name == 'getList' ? false : true) :
                                    $this->$method_name($file_path, $column_variable_type, $parameter_arr);
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
                                                $parameter_arr,
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
//        exit();
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

    public function getColumnArr(){
        return $this->__column_arr;
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
        $code = $unique_index = '';
        $code_supplement = [];
        if(!empty($file_path)){
            $table_name = strtolower(str_replace('Service', '', substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $code = "    \$is_into_redis = \$delete_list_sorted_set = false;";
            $code .= "#    // 需要使用缓存 但没有传入缓存名";
            $code .= "#//    if(\$cache === true && empty(\$cache_name))";
            $code .= "#//        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY, " . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY_NO);";
            $code .= "#    // 插入数据库";
            $code .= "#    // 清空之前查询的member_model的id属性的值";
            $code .= "#    " . ucfirst($table_name) . "Model::getInstance()->__set('_id', null);";
            $code .= "#    \$new_" . $table_name . "_id = " . ucfirst($table_name) . "Model::getInstance()";
            foreach ($this->getColumnArr() as $column_arr) {
                if ($column_arr['Key'] != 'PRI'){
                    if($column_arr['Default'] == 'CURRENT_TIMESTAMP' || $column_arr['Extra'] == ' on update CURRENT_TIMESTAMP')
                        $code_supplement[] = "#        ->__set('_". $column_arr['Field'] ."', \$datetime_now)";
                    else
                        $code .= "#        ->__set('_" . strtolower($column_arr['Field']) . "', \$" . strtolower($column_arr['Field']) . ")";

                    if($column_arr['Key'] == 'UNI' && empty($unique_index))
                        $unique_index = $column_arr['Field'];
                }
            }
            $code .= "#        ->insert();";
//            $code .= "#    if(\$new_" . $table_name . "_id instanceof Exception) throw \$new_" . $table_name . "_id;";
            $code .= !empty($code_supplement) ? "##    // 插入成功，生成创建时间，更新时间，登录次数 生成返回用数据#    \$datetime_now = date('Y-m-d H:i:s', time());" : '';
            $code .= "##    " . ucfirst($table_name) . "Model::getInstance()->__set('_id', \$new_" . $table_name . "_id)";
            $code .= !empty($code_supplement) ? implode('', $code_supplement) . ';' : ';';
            $code .= "##    \$transformer = new " . ucfirst($table_name) . "Transformer(" . ucfirst($table_name) . "Model::getInstance());";
            $code .= "#    \$data_from_storage = \$transformer->SingleData();";
            $code .= "##    // 需要使用缓存 is_into_redis为true delete_list_sorted_set为true";
            $code .= "#    if(\$cache === true /*&& \$cache_name*/){";
//            $code .= "#        \$cache_name = \$this->__single_string_cache_name_prefix . ':' . \$cache_name;";
            $code .= "#        \$cache_name = \$this->__single_string_cache_name_prefix . ':' . \$new_" . strtolower($table_name) . "_id;";
            $code .= "#        \$is_into_redis = \$delete_list_sorted_set = true;";
            $code .= "#    }";

            $code .= "#    // is_into_redis为true 新增的会员数据写入redis";
            $code .= "#    if(\$is_into_redis === true){";
            $code .= "#        Registry::get('redis_string')->genString(\$cache_name, json_encode(\$data_from_storage), \$expire);";
            $code .= "#    }";
            $code .= "##    // 需要删除列表的sortedSet的相关数据";
            $code .= "#    if(\$delete_list_sorted_set === true){";
            $code .= "#        // 删除缓存中的列表SortedSet数据";
            $code .= "#        Registry::get('redis_sorted_set')";
            $code .= "#            ->deleteSortedSet(\$this->__list_sorted_set_cache_name_prefix . ':*');";
            $code .= "##        // 删除缓存中的列表meta数据";
            $code .= "#        \$res = Registry::get('redis_string')->getKeysByPattern(\$this->__list_sorted_set_cache_name_prefix . ':*');";
            $code .= "#        if(is_array(\$res) && !empty(\$res)){";
            $code .= "#            Registry::get('redis_string')->deleteString(\$res);";
            $code .= "#        }";
            $code .= "#    }";
            $code .= "##    return \$data_from_storage;";
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
            $code .= "#    if(empty(\$id))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_UPDATE_ID_EMPTY, " . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_UPDATE_ID_EMPTY_NO);";
            $code .= "#    if(empty(\$update_column) || ! is_array(\$update_column))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_UPDATE_COLUMN_UPDATE_ARR_INVALID, " . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_UPDATE_COLUMN_UPDATE_ARR_INVALID_NO);";
            $code .= "#    // is_into_redis 写入redis 需要使用redis但redis不存在时会为true，反之为false";
            $code .= "#    // update_redis 更新redis 需要使用redis且redis存在时为true，反之为false";
            $code .= "#    // delete_list_sorted_set 删除列表sortedSet与列表meta的string 需要使用redis且redis存在时为true，反之为false";
            $code .= "#    // select_db 查询数据库";
            $code .= "#    \$is_into_redis = \$update_redis = \$select_db = \$delete_list_sorted_set = false;";
//            $code .= "#    \$redis_is_exists = [];";
            $code .= "#    \$redis_is_exists = null;";
            $code .= "#    // 需要使用缓存 但没有传入缓存名";
            $code .= "#    if(\$cache === true && empty(\$cache_name))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY, " . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY_NO);";
            $code .= "##    // 需要使用缓存";
            $code .= "#    if(\$cache === true && \$cache_name){";
            $code .= "#        \$cache_name = \$this->__single_string_cache_name_prefix . ':' . \$cache_name;";
            $code .= "#        \$redis_is_exists = Registry::get('redis_string')->getString(\$cache_name);";
            $code .= "#    }";
            $code .= "#    // 不使用缓存";
            $code .= "#    else \$select_db = true;";
            $code .= "##    // 缓存不存在 查询数据库为true 写入redis为true";
            $code .= "#    if(\$redis_is_exists === null) \$select_db = \$is_into_redis = true;";
            $code .= "#    // 缓存存在 直接json_decode缓存中的数据库 更新redis为true";
            $code .= "#    else{";
            $code .= "#        \$redis_is_exists = json_decode(\$redis_is_exists, true);";
            $code .= "#        \$update_redis = \$delete_list_sorted_set = true;";
            $code .= "#    }";
            $code .= "##    // 实例化 " . $table_name . "_model";
            $code .= "#    \$" . $table_name . "_model = " . ucfirst($table_name) . "Model::getInstance();";
            $code .= "#    \$model_reflection_class = new \\ReflectionClass(\$" . $table_name . "_model);";
            $code .= "#    foreach (\$model_reflection_class->getProperties() as \$val){";
            $code .= "#        if (stripos(\$val->getName(), '_') === 0){";
            $code .= "#            \$column_name = substr(\$val->getName(), stripos(\$val->getName(), '_') + 1);";
            $code .= "#            \$" . $table_name . "_model->__set(\$val->getName(), ";
            $code .= "#                (! isset(\$update_column[\$column_name]) ? null : \$update_column[\$column_name]));";
            $code .= "##            if(isset(\$redis_is_exists[\$column_name]) && isset(\$update_column[\$column_name]))";
            $code .= "#                \$redis_is_exists[\$column_name] = \$update_column[\$column_name];";
            $code .= "#        }";
            $code .= "#    }";
//            $code .= "#    foreach (\$update_column as \$column => \$value){";
//            $code .= "#        // 缓存存在时 需要更新指定字段的时";
//            $code .= "#        if(isset(\$redis_is_exists[\$column]))";
//            $code .= "#            \$redis_is_exists[\$column] = \$value;";
//            $code .= "##        // 设置user_model里的各个属性，即各个字段的值";
//            $code .= "#        \$model_column_name = '_' . \$column;";
//            $code .= "#        \$" . $table_name . "_model->__set(\$model_column_name, \$value);";
//            $code .= "#    }";
            $code .= "#    // 修改数据库";
            $code .= "#    \$" . $table_name . "_model->__set('_id', \$id)->update();";
            $code .= "##    // 不需要使用缓存 或缓存不存在时 读取数据库";
            $code .= "#    // 之所以再从数据库中获取一边，是为了返回给调用者一个" . $table_name;
            $code .= "#    if(\$select_db === true){";
            $code .= "#        // 直接使用主键查询";
            $code .= "#        \$data_from_db = \$" . $table_name . "_model->find(\$id);";
//            $code .= "##        // 要编辑的user不存在与数据库";
//            $code .= "#        if(\$data_from_db instanceof Exception) throw \$data_from_db;";
            $code .= "##        \$is_into_redis = \$cache;";
            $code .= "##        \$" . $table_name . "_transformer = new " . ucfirst($table_name) . "Transformer(\$data_from_db);";
            $code .= "#        \$redis_is_exists = \$" . $table_name . "_transformer->SingleData();";
            $code .= "#    }";
            $code .= "##    if(\$delete_list_sorted_set === true){";
            $code .= "#        // 删除缓存中的列表SortedSet数据";
            $code .= "#        Registry::get('redis_sorted_set')";
            $code .= "#            ->deleteSortedSet(\$this->__list_sorted_set_cache_name_prefix . ':*');";
            $code .= "##        // 删除缓存中的列表meta数据";
            $code .= "#        \$res = Registry::get('redis_string')->getKeysByPattern(\$this->__list_sorted_set_cache_name_prefix . ':*');";
            $code .= "#        if(is_array(\$res) && !empty(\$res)){";
            $code .= "#            Registry::get('redis_string')->deleteString(\$res);";
            $code .= "#        }";
            $code .= "#    }";
            $code .= "##    if(\$is_into_redis === true)";
            $code .= "#        Registry::get('redis_string')->genString(\$cache_name, json_encode(\$redis_is_exists), \$expire);";
            $code .= "##    if(\$update_redis === true)";
            $code .= "#        Registry::get('redis_string')->updateString(\$cache_name, json_encode(\$redis_is_exists), \$expire);";
            $code .= "##    return \$redis_is_exists;";
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
            $table_name = strtolower(str_replace("Service", "", substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $code .= "#    if(empty(\$id))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_DELETE_ID_EMPTY, " . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_DELETE_ID_EMPTY_NO);";
            $code .= "#    // 删除缓存的结果 缓存不存在或不删除缓存为null 缓存删除成功为1 缓存删除失败为0";
            $code .= "#    \$delete_from_redis = \$data_has_been_delete = null;";
            $code .= "#    // 需要使用缓存 但没有传入缓存名";
            $code .= "#    if(\$cache === true && empty(\$cache_name))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY, " . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY_NO);";
            $code .= "##    // 需要使用缓存";
            $code .= "#    if(\$cache === true && \$cache_name){";
            $code .= "#        \$cache_name = \$this->__single_string_cache_name_prefix . ':' . \$cache_name;";
            $code .= "#        // 从缓存中读取要删除的数据，并用于返回";
            $code .= "#        \$data_has_been_delete = Registry::get('redis_string')->getString(\$cache_name);";
            $code .= "#        if(\$data_has_been_delete !== null){";

            $code .= "#            \$data_has_been_delete = json_decode(\$data_has_been_delete, true);";
            $code .= "#            // 删除缓存数据";
            $code .= "#            \$delete_from_redis = Registry::get('redis_string')->deleteString(\$cache_name);";
//            $code .= "##        // 删除缓存中的列表SortedSet数据";
//            $code .= "#        \$member = str_replace(\$this->__single_string_cache_name_prefix . ':', '', \$cache_name);";
            $code .= "##            // 修改缓存中的列表meta数据";
            $code .= "#            \$pattern_res = Registry::get('redis_string')->getKeysByPattern(\$this->__list_sorted_set_cache_name_prefix . ':*');";
            $code .= "#            if(is_array(\$pattern_res) && !empty(\$pattern_res)){";
            $code .= "#                \$meta_info_match = \$meta_info_after_delete = [];";
            $code .= "#                // 删除缓存中的列表SortedSet数据";
            $code .= "#                \$member = str_replace(\$this->__single_string_cache_name_prefix . ':', '', \$cache_name);";
            $code .= "##                // 遍历pattern返回的key数据，获取到每个真实的list meta的redis string key";
            $code .= "#                // 并以真实的redis string key为键，删除掉需要删除的记录后的sortedSet长度为值，生成一个二维数据meta_info_match";
            $code .= "#                foreach (\$pattern_res as \$key => \$real_redis_sorted_set_key){";
            $code .= "#                    if(! is_null(Registry::get('redis_sorted_set')->getSortedSetLength(\$real_redis_sorted_set_key))){";
            $code .= "#                        array_push(\$meta_info_match, \$real_redis_sorted_set_key);";
            $code .= "#                        Registry::get('redis_sorted_set')";
            $code .= "#                            ->deleteSortedSetItem(\$this->__list_sorted_set_cache_name_prefix . ':*', \$member);";
            $code .= "#                    }";
//            $code .= "#                \$meta_info_match[\$real_redis_sorted_set_key] = Registry::get('redis_sorted_set')->getSortedSetLength(\$real_redis_sorted_set_key);";
            $code .= "#                }";
            $code .= "##                // 若meta_info_match不为空，遍历";
            $code .= "#                if(\$meta_info_match){";
            $code .= "#                    // 删除缓存中的列表meta数据";
            $code .= "#                    Registry::get('redis_string')->deleteString(\$meta_info_match);";
//            $code .= "#                \$i = 1;";
//            $code .= "#                foreach (\$meta_info_match as \$meta_key => \$meta_info){";
//            $code .= "#                    // 读取每个真实的redis string key下的列表的meta info，并对值进行修改，然后updateString回redis中";
//            $code .= "#                    \$meta_info_before_delete = json_decode(Registry::get('redis_string')->getString(\$meta_key), true);";
//            $code .= "#                    // 最后一页 且只有一条数据 删除";
//            $code .= "#                    if(\$i === count(\$meta_info_match) && \$meta_info_before_delete['count'] == 1){";
//            $code .= "#                        Registry::get('redis_string')->deleteString(\$meta_key);";
//            $code .= "#                    }else{";
//            $code .= "#                        \$meta_info_after_delete = [";
//            $code .= "#                            'total' => \$meta_info_before_delete['total'] - 1,";
//            $code .= "#                            'per_page' => \$meta_info_before_delete['per_page'],";
//            $code .= "#                            'total_pages' => (int)ceil((\$meta_info_before_delete['total'] - 1)  / \$meta_info_before_delete['per_page']),";
//            $code .= "#                            'current_page' => \$meta_info_before_delete['current_page'],";
//            $code .= "#                            'count' => \$i === count(\$meta_info_match) ?";
//            $code .= "#                                (int)(\$meta_info_before_delete['count'] - 1) :";
//            $code .= "#                                \$meta_info_before_delete['count'],";
//            $code .= "#                            'links' => \$meta_info_before_delete['links']";
//            $code .= "#                        ];";
//            $code .= "#                        Registry::get('redis_string')->updateString(\$meta_key, json_encode(\$meta_info_after_delete));";
//            $code .= "#                    }";
//            $code .= "#                    \$i++;";
//            $code .= "#                }";
            $code .= "#                }";
//            $code .= "#            // 删除缓存中的列表meta数据";
//            $code .= "#            // Registry::get('redis_string')->deleteString(\$res);";
            $code .= "#            }";
            $code .= "#        }";
            $code .= "#    }";
//            $code .= "#    // 不使用缓存，从数据库中读取要删除的数据，并用于返回";
//            $code .= "#    else \$data_has_been_delete = \$this->getOne(\$id, false);";
            $code .= "#    // 不使用缓存 或缓存不存在";
            $code .= "#    if (\$data_has_been_delete === null)";
            $code .= "#        \$data_has_been_delete = \$this->getOne(\$id, false);";
            $code .= "##    // 缓存删除成功 或不使用缓存 或缓存不存在";
            $code .= "#    if(\$delete_from_redis === 1 || \$delete_from_redis === null)";
            $code .= "#        // 删除数据库";
            $code .= "#        " . ucfirst($table_name) . "Model::getInstance()->__set('_id', \$id)->delete();";
            $code .= "#    // 缓存删除失败";
            $code .= "#//    else if(\$delete_from_redis === false) throw new Exception('删除缓存失败');";
            $code .= "##    return \$data_has_been_delete;";
        }
        return $code;
    }

    public function genBatchDeleteFunctionMain($file_path = '', $type = 'public', $parameters_arr = []){
        $code = "";
        if(!empty($file_path) && !empty($parameters_arr)){
            $table_name = strtolower(str_replace("Service", "", substr($file_path, strrpos($file_path, '/') + 1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $code = "    \$array = !empty(\$arr) && is_array(\$arr) ? \$arr : '';";
            $code .= "#    if(empty(\$array))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_DELETE_RETURN_FALSE,";
            $code .= "#            " . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_DELETE_RETURN_FALSE_NO);";
            $code .= "#    \$rules_arr = \$groups_arr = \$condition = \$delete_column_arr = [];";
            $code .= "#    \$return = false;";
            $code .= "#    // 需要操作缓存";
            $code .= "#    \$id_arr = array_column(\$array, 'id');";
            $code .= "#    // 将需要删除的记录遍历出来，并根据每一行记录中是否包含主键来判断是否需要生成查询数据库的查询条件";
            $code .= "#    array_walk(\$array, function(\$value, \$key) use(&\$rules_arr, &\$array, &\$groups_arr){";
            $code .= "#        // 主键不存在与每一行记录里";
            $code .= "#        if(! in_array(\$this->__primary_index, array_keys(\$value))){";
            $code .= "#            \$rules = [];";
            $code .= "#            // 将每一行记录的条件写入rules数组";
            $code .= "#            foreach (\$value as \$column_name => \$real_value){";
            $code .= "#                \$rules[] = ['field' => \$column_name, 'op' => 'eq', 'data' => \$real_value];";
            $code .= "#            }";
            $code .= "#            if(!empty(\$rules)){";
            $code .= "#                // 这一条记录有多个查询条件用AND连接";
            $code .= "#                if(count(\$rules) > 1){";
            $code .= "#                    array_push(\$groups_arr, [";
            $code .= "#                        'groupOp' => 'AND',";
            $code .= "#                        'rules' => \$rules";
            $code .= "#                    ]);";
            $code .= "#                }";
            $code .= "#                // 只有一条记录只有一个查询条件的";
            $code .= "#                else{";
            $code .= "#                    \$rules_arr = array_merge(\$rules_arr, \$rules);";
            $code .= "#                }";
            $code .= "#            }";
            $code .= "#        }";
            $code .= "#    });";
            $code .= "##    // 生成查询条件";
            $code .= "#    if(\$rules_arr){";
            $code .= "#        \$condition['groupOp'] = 'OR';";
            $code .= "#        \$condition['rules'] = \$rules_arr;";
            $code .= "#        if(\$groups_arr) \$condition['groups'] = \$groups_arr;";
            $code .= "#    }";
            $code .= "##    // 从符合查询条件的查询结果中取出id字段，并合并到现有的id_arr数组中";
            $code .= "#    if(\$condition){";
            $code .= "#        \$res = \$this->getList(1, count(\$array), 'desc', 'id', \$condition);";
//            $code .= "##        if(\$res instanceof Exception) throw \$res;";
            $code .= "##        if(isset(\$res['data']) && ! empty(\$res['data']))";
            $code .= "#             \$id_arr = array_merge(\$id_arr, array_column(\$res['data'], 'id'));";
            $code .= "#    }";

            $code .= "##    // id_arr不为空时，表示要删除的记录都已经从数据库中获取到了，";
            $code .= "#    //因此 需要生成string的缓存名数组 以及 以primary_key为键，对应的数据库值为值的二维数组";
            $code .= "#    if(\$id_arr){";
            $code .= "#        // 去重";
            $code .= "#        \$id_arr = array_unique(\$id_arr);";
            $code .= "#        // 生成缓存名 以及 以primary_key为键，对应的数据库值为值的二维数组";
            $code .= "#        array_walk(\$id_arr, function(\$value, \$key) use(&\$id_arr, &\$delete_column_arr){";
            $code .= "#            \$id_arr[\$key] = \$this->__single_string_cache_name_prefix . ':' . \$value;";
            $code .= "#            array_push(\$delete_column_arr, [\$this->__primary_index => \$value]);";
            $code .= "#        });";
            $code .= "#    }";
            $code .= "##    // 需要操作缓存，且缓存名数组已经生成完毕";
            $code .= "#    if(\$cache === true && \$id_arr){";
            $code .= "#        // 删除缓存";
            $code .= "#        Registry::get('redis_string')->deleteString(\$id_arr);";
            $code .= "#        // 删除列表缓存数据";
            $code .= "#        array_walk(\$id_arr, function (\$val, \$key) {";
            $code .= "#            Registry::get('redis_sorted_set')";
            $code .= "#                ->deleteSortedSetItem(\$this->__list_sorted_set_cache_name_prefix . ':*', \$val);";
            $code .= "#        });";
            $code .= "#        // 修改缓存中的列表meta数据";
            $code .= "#        \$pattern_res = Registry::get('redis_string')->getKeysByPattern(\$this->__list_sorted_set_cache_name_prefix . ':*');";
            $code .= "##        // 删除缓存中的列表meta数据";
            $code .= "#        \$meta_info_match = [];";
            $code .= "#        array_walk(\$pattern_res, function (\$real_redis_sorted_set_key, \$key) use (&\$meta_info_match) {";
            $code .= "#            if(! is_null(Registry::get('redis_sorted_set')->getSortedSetLength(\$real_redis_sorted_set_key)))";
            $code .= "#                array_push(\$meta_info_match, \$real_redis_sorted_set_key);";
            $code .= "#        });";
            $code .= "#        if(! empty(\$meta_info_match))";
            $code .= "#            Registry::get('redis_string')->deleteString(\$meta_info_match);";
            $code .= "#    }";
            $code .= "##    // 删除条件生成成功";
            $code .= "#    if(\$delete_column_arr){";
            $code .= "#        // 删除数据库";
            $code .= "#        " . ucfirst($table_name) . "Model::getInstance()->batchDelete(\$delete_column_arr);";
//            $code .= "#        \$res = " . ucfirst($table_name) . "Model::getInstance()->batchDelete(\$delete_column_arr);";
//            $code .= "##        if(\$res instanceof Exception) throw \$res;";
            $code .= "##        \$return = true;";
            $code .= "#     }";
            $code .= "#    return \$return;";
        }
        return $code;
    }

    public function genBatchInsertFunctionMain($file_path = '', $type = 'public', $parameters_arr = []){
        $code = "";
        if(!empty($file_path) && ! empty($parameters_arr)){
            $table_name = strtolower(str_replace("Service", "", substr($file_path, strrpos($file_path, '/') + 1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $code = "#    \$array = !empty(\$arr) && is_array(\$arr) ? \$arr : '';";
            $code .= "#    if(empty(\$array))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_INSERT_RETURN_FALSE,";
            $code .= "#            " . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_INSERT_RETURN_FALSE_NO);";
            $code .= "#    \$res = " . ucfirst($table_name) . "Model::getInstance()->batchInsert(\$array);";
//            $code .= "#     if(\$res instanceof Exception) throw \$res;";
            $code .= "##    // 用唯一索引字段生成查询条件 将刚刚插入的数据读取出来";
//            $code .= "#    if(property_exists(\$this, '__unique_key')){";
            $code .= "#    if(\$this->__unique_index){";
            $code .= "#        \$rules_arr = \$data_from_storage = [];";
            $code .= "#        array_reduce(array_keys(\$array), function(\$carry, \$key) use(&\$rules_arr, &\$array){";
            $code .= "#            array_push(\$rules_arr, ['field' => \$this->__unique_index, 'op' => 'eq', 'data' => \$array[\$key][\$this->__unique_index]]);";
            $code .= "#        });";
            $code .= "#        if(\$rules_arr){";
            $code .= "#            \$condition = [";
            $code .= "#                'groupOp' => 'OR',";
            $code .= "#                 'rules' => \$rules_arr";
            $code .= "#            ];";
            $code .= "#            \$data_from_storage = \$this->getList(1, count(\$array), 'desc', 'id', \$condition);";
            $code .= "#        }";
            $code .= "##        \$cache_name_arr = \$data_into_redis = [];";
            $code .= "#        if(\$cache === true && \$data_from_storage && isset(\$data_from_storage['data'])){";
            $code .= "#            array_reduce(array_keys(\$data_from_storage['data']), function (\$carry, \$key) use(&\$cache_name_arr, &\$data_from_storage, &\$data_into_redis){";
            $code .= "#                array_push(\$cache_name_arr, \$this->__single_string_cache_name_prefix . ':' . \$data_from_storage['data'][\$key][\$this->__primary_index]);";
            $code .= "#                array_push(\$data_into_redis, json_encode(\$data_from_storage['data'][\$key]));";
            $code .= "#            });";
            $code .= "#            if(\$cache_name_arr && \$data_into_redis)";
            $code .= "#                Registry::get('redis_string')->genString(\$cache_name_arr, \$data_into_redis, \$expire);";
            $code .= "#        }";
            $code .= "#    }else{";
            $code .= "#        \$data_from_storage = [\$res];";
            $code .= "#    }";
            $code .= "#    return \$data_from_storage;";
        }
        return $code;
    }

    public function genBatchUpdateFunctionMain($file_path = '', $type = 'public', $parameters_arr = []){
        $code = "";
        if(!empty($file_path) && !empty($parameters_arr)){
            $table_name = strtolower(str_replace("Service", "", substr($file_path, strrpos($file_path, '/') + 1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $code = "    if(empty(\$update_column) || empty(\$id))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_UPDATE_EMPTY_CONDITION,";
            $code .= "#            " . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_UPDATE_EMPTY_CONDITION_NO);";
            $code .= "#    if(! is_array(\$id) || ! is_array(\$update_column))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE,";
            $code .= "#            " . ucfirst($table_name) . "ErrorMsg::" . strtoupper($table_name) . "_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE_NO);";
            $code .= "#    \$cache_name = is_array(\$cache_name) && ! empty(\$cache_name) ? \$cache_name : false;";
            $code .= "##    \$cache_name_arr = \$redis_is_exists = null;";
            $code .= "#    \$batch_update_res = \$update_db = false;";
            $code .= "#    // 不使用缓存，直接修改数据库";
            $code .= "#    if(\$cache === false) \$update_db = true;";
            $code .= "#    // 使用缓存，且缓存名存在，检查缓存";
            $code .= "#    elseif(\$cache === true && \$cache_name !== false){";
            $code .= "#        \$cache_name = \$this->__single_string_cache_name_prefix . ':*';";
            $code .= "#        \$cache_name_arr = Registry::get('redis_string')->getKeysByPattern(\$cache_name);";
            $code .= "#    }";
            $code .= "##    // 缓存名读取成功";
            $code .= "#    if(\$cache_name_arr !== null && !empty(\$cache_name_arr)){";
            $code .= "#        \$redis_is_exists = Registry::get('redis_string')->getString(\$cache_name_arr);";
            $code .= "#        if(is_array(\$redis_is_exists))";
            $code .= "#            array_walk(\$redis_is_exists, function (\$json_encode_string, \$idx) use(&\$redis_is_exists){";
            $code .= "#                \$redis_is_exists[\$idx] = json_decode(\$json_encode_string, true);";
            $code .= "#            });";
            $code .= "#        // cache_name_arr要么是个数组要么是个null，永远不会进下面这个判断";
            $code .= "#//        elseif(is_array(\$redis_is_exists))";
            $code .= "#//            \$redis_is_exists[] = json_decode(\$redis_is_exists, true);";
            $code .= "#    }";
            $code .= "##    // 缓存存在";
            $code .= "#    if(\$redis_is_exists !== null){";
            $code .= "#        \$match_update_column = [];";
            $code .= "#        // 生成匹配用的数组，以primary_id为键的二维数组";
            $code .= "#        array_walk(\$update_column, function(\$value, \$key) use(&\$match_update_column){";
            $code .= "#            \$match_update_column[\$value['id']] = \$value;";
            $code .= "#        });";
            $code .= "##        // 修改redis_is_exists里的值";
            $code .= "#        // 若要修改的数据存在于redis中，则按照字段，将要修改的新值替换掉redis缓存中的旧值";
            $code .= "#        // 若要修改的数据不存在与redis，则从redis_is_exists中unset掉";
            $code .= "#        array_reduce(";
            $code .= "#            array_keys(\$redis_is_exists), function(\$carry, \$idx) use(&\$redis_is_exists, \$match_update_column, \$id){";
            $code .= "#                if(in_array(\$redis_is_exists[\$idx]['id'], \$id)){";
            $code .= "#                    \$real_id = \$redis_is_exists[\$idx]['id'];";
            $code .= "#                    array_reduce(";
            $code .= "#                        array_keys(\$redis_is_exists[\$idx]),";
            $code .= "#                        function(\$ca, \$column) use(&\$redis_is_exists, \$match_update_column, \$real_id, \$idx){";
            $code .= "#                            if(isset(\$match_update_column[\$redis_is_exists[\$idx]['id']][\$column]))";
            $code .= "#                                \$redis_is_exists[\$idx][\$column] = \$match_update_column[\$redis_is_exists[\$idx]['id']][\$column];";
            $code .= "#                        }";
            $code .= "#                    );";
            $code .= "#                }else{";
            $code .= "#                    unset(\$redis_is_exists[\$idx]);";
            $code .= "#                }";
            $code .= "#            }";
            $code .= "#        );";
            $code .= "#    }";
            $code .= "##    // 需要修改redis";
            $code .= "#    if(\$redis_is_exists){";
            $code .= "#        \$update_redis_arr = \$redis_key_arr = [];";
            $code .= "#        // 生成redis_key数组与要修改进redis的数组，两个数组下标相同";
            $code .= "#        array_walk(\$redis_is_exists, function(\$value, \$key) use(&\$update_redis_arr, &\$redis_key_arr){";
            $code .= "#            \$redis_key_arr[] = \$this->__single_string_cache_name_prefix . ':' . \$value['id'];";
            $code .= "#            \$update_redis_arr[] = json_encode(\$value);";
            $code .= "#        });";
            $code .= "#        \$res = Registry::get('redis_string')->updateString(\$redis_key_arr, \$update_redis_arr, \$expire);";
            $code .= "#        // 校验结果";
            $code .= "#        if(\$res === null){";
            $code .= "#            // redis修改失败";
            $code .= "#        }else if(is_array(\$res)){";
            $code .= "#            // 删除缓存中的列表SortedSet数据";
            $code .= "#            Registry::get('redis_sorted_set')";
            $code .= "#                ->deleteSortedSet(\$this->__list_sorted_set_cache_name_prefix . ':*');";
            $code .= "##            // 删除缓存中的列表meta数据";
            $code .= "#            \$res = Registry::get('redis_string')->getKeysByPattern(\$this->__list_sorted_set_cache_name_prefix . ':*');";
            $code .= "#            if(is_array(\$res) && !empty(\$res)){";
            $code .= "#                Registry::get('redis_string')->deleteString(\$res);";
            $code .= "#            }";
            $code .= "#            \$update_db = true;";
            $code .= "#        }";
            $code .= "#    }";
            $code .= "##    // 修改数据库";
            $code .= "#    if(\$update_db === true){";
            $code .= "#        // 返回sql执行过后被修改的记录数";
            $code .= "#        \$batch_update_res = " . ucfirst($table_name) . "Model::getInstance()->genBatchUpdateSql(\$update_column);";
            $code .= "#        // if(\$batch_update_res instanceof Exception)";
            $code .= "#        //     throw \$batch_update_res;";
            $code .= "#    }";
            $code .= "#    return \$batch_update_res;";
        }
        return $code;
    }

    public function genSelectFunctionMain($file_path = '', $parameters_arr =[], $is_one = true){
        return $is_one === true ? $this->__genGetOneFunctionMain($file_path, $parameters_arr) :
            $this->__genGetListFunctionMain($file_path, $parameters_arr);
    }

    private function __genGetListFunctionMain($file_path = '', $parameters_arr = []){
        $code = '';
        if (!empty($file_path)) {
            $table_name = strtolower(str_replace("Service", "", substr($file_path, strrpos($file_path, '/') + 1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $code .= "    \$select_db = \$is_into_redis = false;";
            $code .= "#    \$cache_name = \$cache_name === '' ? false : \$cache_name;";
            $code .= "#    \$result_from_db = new Exception('未知错误');";
            $code .= "#    \$redis_is_exists = null;";
            $code .= "#    \$full_data = [];";

            $code .= "##    // 需要使用缓存 但没有传入缓存名";
            $code .= "#    if(\$cache === true && empty(\$cache_name))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY, " . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY_NO);";

            $code .= "##    // 使用缓存，且缓存名存在，检查缓存";
            $code .= "#    if(\$cache === true && is_string(\$cache_name))";
            $code .= "#        \$redis_is_exists = Registry::get('redis_sorted_set')->getSortedSet(\$cache_name);";

            $code .= "#    // 不使用缓存或缓存不存在 select_db为true";
            $code .= "#    if(\$redis_is_exists === null) \$select_db = true;";

            $code .= "#    // 读取数据库数据";
            $code .= "#    if(\$select_db === true)";
            $code .= "#        \$result_from_db = " . ucfirst($table_name) . "Model::getInstance()->__set('page', \$page)->__set('page_size', \$page_size)";
            $code .= "#            ->setOrderBy(['order' => \$order, 'sort' => \$sort])->findBy(\$condition);";

            $code .= "#    // 数据库查无结果 或 select_db === false";
            $code .= "#    // if(\$result_from_db instanceof Exception && \$cache === false) throw \$result_from_db;";
            $code .= "#     // 从数据库中查询出结果了";
            $code .= "#    if(\$result_from_db instanceof " . ucfirst($table_name) . "Model){";
            $code .= "#        \$transformer = new " . $table_name . "Transformer(\$result_from_db);";
            $code .= "#        // 根据是否使用缓存来获取数据";
            $code .= "#        \$data = \$transformer->BackEndData(\$cache);";
            $code .= "#        \$full_data = \$transformer->BackEndData();";
            $code .= "#        \$redis_is_exists = \$cache === true ? \$data['data'] : \$data;";

            $code .= "#        \$is_into_redis = \$cache;";
            $code .= "#    }";

            $code .= "#    // 有正确数据，且需要写入redis的sortedSet";
            $code .= "#    if(\$is_into_redis === true && \$redis_is_exists && isset(\$full_data['meta'])){";
            $code .= "#        Registry::get('redis_sorted_set')->genSortedSet(\$cache_name, \$redis_is_exists, \$expire);";
            $code .= "#        Registry::get('redis_string')->genString(\$cache_name, json_encode(\$full_data['meta']), \$expire);";
            $code .= "#    }";

            $code .= "##    // 读取缓存";
            $code .= "#    // 并按照sortedSet的顺序，将mget的结果一个一个写进redis_is_exists['data']里";
            $code .= "#    // 并删除掉多余无用的redis_is_exists的键";
            $code .= "#    if(\$cache){";
//            $code .= "#        // 从string中mget出结果";
//            $code .= "#        \$detail_in_redis = [];";
//            $code .= "#        if(count(array_filter(\$redis_is_exists)) > 0)";
//            $code .= "#            \$detail_in_redis = Registry::get('redis_string')->getString(\$redis_is_exists);";
//            $code .= "#            // 去重之后的数组长度与去重之前不一致，代表有数据重复，有可能是对应mobile的redis string不存在导致的";
//            $code .= "#            if(count(array_filter(\$detail_in_redis)) !== count(\$detail_in_redis) ||";
//            $code .= "#                count(array_filter(\$detail_in_redis)) === 0){";
//            $code .= "#            // 列表缓存不存在 单条数据缓存也有部分不存在";
//            $code .= "#            if(!isset(\$full_data['data'])){";
//            $code .= "#                \$match_redis_is_exists = \$redis_is_exists;";
//            $code .= "#                foreach (array_values(array_filter(\$detail_in_redis)) as \$detail){";
//            $code .= "#                    \$detail = json_decode(\$detail, true);";
//            $code .= "#                    \$full_data['data'][] = \$detail;";
//            $code .= "#                    \$key = array_search(\$detail[\$this->__unique_index], \$match_redis_is_exists);";
//            $code .= "#                    \$key = array_search(\$detail[\$this->__primary_index], \$match_redis_is_exists);";
//            $code .= "#                    unset(\$match_redis_is_exists[\$key]);";
//            $code .= "#                }";
//            $code .= "#                if(\$match_redis_is_exists){";
//            $code .= "#                    foreach (\$match_redis_is_exists as \$k => \$primary_key){";
//            $code .= "#                        \$condition = ['groupOp' => 'AND', 'rules' => [['field' => \$this->__unique_index, 'op' => 'eq', 'data' => \$unique_column_value]]];";
//            $code .= "#                        \$full_data['data'][] = \$this->getOne(\$condition, true, \$unique_column_value);";
//            $code .= "#                        \$full_data['data'][] = \$this->getOne((int)\$primary_key, true, \$primary_key);";
//            $code .= "#                        unset(\$match_redis_is_exists[\$k]);";
//            $code .= "#                    }";
//            $code .= "#                }";
//            $code .= "#            }";
//            $code .= "#            if(isset(\$full_data['data'])){";
//            $code .= "#                foreach (\$full_data['data'] as \$detail){";
//            $code .= "#                    \$key = array_search(\$detail[\$this->__primary_index], \$redis_is_exists);";
//            $code .= "#                    \$key = array_search(\$detail[\$this->__unique_index], \$redis_is_exists);";
//            $code .= "#                    Registry::get('redis_string')->genString(\$detail[\$this->__unique_index], json_encode(\$detail), \$expire);";
//            $code .= "#                    \$single_cache_name = \$this->__single_string_cache_name_prefix . ':' . \$detail[\$this->__primary_index];";
//            $code .= "#                    Registry::get('redis_string')->genString(\$single_cache_name, json_encode(\$detail), \$expire);";
//            $code .= "#                    \$detail['index'] = \$key;";
//            $code .= "#                    \$redis_is_exists['data'][] = \$detail;";
//            $code .= "#                    unset(\$redis_is_exists[\$key]);";
//            $code .= "#                }";
//            $code .= "#            }";
//            $code .= "#            array_multisort(array_column(\$redis_is_exists['data'], 'index'), SORT_ASC, \$redis_is_exists['data']);";
//            $code .= "#        }else{";
//            $code .= "#            foreach (\$detail_in_redis as \$v){";
//            $code .= "#                \$detail = json_decode(\$v, true);";
//            $code .= "#                \$key = array_search(\$detail[\$this->__unique_index], \$redis_is_exists);";
//            $code .= "#                \$key = array_search(\$detail[\$this->__primary_index], \$redis_is_exists);";
//            $code .= "#                \$detail['index'] = \$key;";
//            $code .= "#                \$redis_is_exists['data'][] = \$detail;";
//            $code .= "#                unset(\$redis_is_exists[\$key]);";
//            $code .= "#            }";
//            $code .= "#        }";
            $code .= "#        // 从string中mget出结果";
            $code .= "#        \$detail_in_redis = [];";
            $code .= "#        if(is_array(\$redis_is_exists) && count(array_unique(\$redis_is_exists)) > 0){";
            $code .= "#            array_walk(\$redis_is_exists, function (\$value, \$idx) use(&\$redis_is_exists){";
            $code .= "#                \$redis_is_exists[\$idx] = \$this->__single_string_cache_name_prefix . ':' . \$value;";
            $code .= "#            });";
            $code .= "#            \$detail_in_redis = Registry::get('redis_string')->getString(\$redis_is_exists);";
            $code .= "#        }";
            $code .= "#        // 去重之后的数组长度与去重之前不一致，代表有数据重复，有可能是对应mobile的redis string不存在导致的";
            $code .= "#        if((count(array_filter(\$detail_in_redis)) !== count(\$detail_in_redis) ||";
            $code .= "#            count(array_filter(\$detail_in_redis)) === 0) && \$redis_is_exists){";
            $code .= "#            // 列表缓存不存在 单条数据缓存也有部分不存在";
            $code .= "#            if(!isset(\$full_data['data'])){";
            $code .= "#                \$match_redis_is_exists = \$redis_is_exists;";
            $code .= "#                if(\$match_redis_is_exists){";
            $code .= "#                    foreach (\$match_redis_is_exists as \$k => \$primary_key){";
            $code .= "#                        \$primary_key = str_replace(\$this->__single_string_cache_name_prefix . ':', '', \$primary_key);";
            $code .= "#                        \$condition = (int)\$primary_key;";
            $code .= "#                        \$full_data['data'][] = \$this->getOne(\$condition, true, \$primary_key);";
            $code .= "#                    }";
            $code .= "#                }";
            $code .= "#            }";
            $code .= "##           if(isset(\$full_data['data'])){";
            $code .= "#                foreach (\$full_data['data'] as \$detail){";
            $code .= "#//                    \$key = array_search(\$detail[\$this->__primary_index], \$redis_is_exists);";
            $code .= "#                    \$single_cache_name = \$this->__single_string_cache_name_prefix . ':' . \$detail[\$this->__primary_index];";
            $code .= "#                    \$key = array_search(\$single_cache_name, \$redis_is_exists);";
            $code .= "#                    Registry::get('redis_string')->genString(\$single_cache_name, json_encode(\$detail), \$expire);";
            $code .= "#                    \$detail['index'] = \$key;";
            $code .= "#                    \$redis_is_exists['data'][] = \$detail;";
            $code .= "#                    unset(\$redis_is_exists[\$key]);";
            $code .= "#                }";
            $code .= "#            }";
            $code .= "#            array_multisort(array_column(\$redis_is_exists['data'], 'index'), SORT_ASC, \$redis_is_exists['data']);";
            $code .= "#        }else{";
            $code .= "#            foreach (\$detail_in_redis as \$v){";
            $code .= "#                \$detail = json_decode(\$v, true);";
            $code .= "#                \$key = array_search(\$this->__single_string_cache_name_prefix . ':' . \$detail[\$this->__primary_index], \$redis_is_exists);";
            $code .= "#                \$detail['index'] = \$key;";
            $code .= "#                \$redis_is_exists['data'][] = \$detail;";
            $code .= "#                unset(\$redis_is_exists[\$key]);";
            $code .= "#            }";
            $code .= "#        }";
            $code .= "##        \$redis_is_exists['meta'] = json_decode(Registry::get('redis_string')->getString(\$cache_name), true);";
            $code .= "#    }";

            $code .= "#    return \$redis_is_exists;";
        }
        return $code;
    }

    private function __genGetOneFunctionMain($file_path = '', $parameters_arr = []){
        $code = '';
        if (!empty($file_path)) {
            $table_name = strtolower(str_replace("Service", "", substr($file_path, strrpos($file_path, '/') + 1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
            $code .= "    // 查询数据库，写入缓存变量 false表示不执行，true表示要执行";
            $code .= "#    \$select_db = \$is_into_redis = false;";
            $code .= "#    \$cache_name = \$cache_name === '' ? false : \$cache_name;";
            $code .= "#    \$redis_is_exists = null;";
            $code .= "##    // 需要使用缓存 但没有传入缓存名";
            $code .= "#    if(\$cache === true && empty(\$cache_name))";
            $code .= "#        throw new Exception(" . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY, " . ucfirst($table_name) . "ErrorMsg::REDIS_KEY_IS_NOT_EMPTY_NO);";
            $code .= "#    // 使用缓存，且缓存名存在，检查缓存";
            $code .= "#    if(\$cache_name !== false && is_string(\$cache_name))";
            $code .= "#        \$redis_is_exists = Registry::get('redis_string')->getString(\$cache_name);";
            $code .= "##    // 缓存不存在 查询数据库为true";
            $code .= "#    if(\$redis_is_exists === null) \$select_db = true;";
            $code .= "#    // 缓存存在 直接json_decode缓存中的数据库";
            $code .= "#    else \$redis_is_exists = json_decode(\$redis_is_exists, true);";
            $code .= "##    // 需要查询数据库";
            $code .= "#    if(\$select_db === true){";
            $code .= "#        // 多条件查询";
            $code .= "#        if(is_array(\$condition)) \$data_from_db = " . ucfirst($table_name) . "Model::getInstance()->findOneBy(\$condition);";
            $code .= "#        // 直接使用主键查询";
            $code .= "#        else \$data_from_db = " . ucfirst($table_name) . "Model::getInstance()->find(\$condition);";
            $code .= "##        // 登录账号不存在与数据库";
            $code .= "#        // if(\$data_from_db instanceof Exception) throw \$data_from_db;";
            $code .= "##        \$is_into_redis = \$cache;";
            $code .= "##        \$" . $table_name . "_transformer = new " . ucfirst($table_name) . "Transformer(\$data_from_db);";
            $code .= "#        \$redis_is_exists = \$" . $table_name . "_transformer->SingleData();";
            $code .= "#    }";
            $code .= "##    if(\$is_into_redis === true){";
            $code .= "#        \$cache_name = \$this->__single_string_cache_name_prefix . ':' . \$cache_name;";
            $code .= "#        Registry::get('redis_string')->genString(\$cache_name, json_encode(\$redis_is_exists), \$expire);";
            $code .= "#    }";

            $code .= "##    return \$redis_is_exists;";
        }
        return $code;
    }
}