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

class GeneratedServiceV1 extends GeneratedCode
{
    private $__column_arr = [];

    protected $_code_arr = [
        'start' => '<?php',
        'namespace' => 'models\\Service',
        'use' => [
            'ErrorMsg\\Admin\\ErrorMsg',
            'ErrorMsg\\Admin\\ErrorTips',
            'models\\DAO\\#table_name# as DAO_#table_name#',
            'Yaf\\Registry',
            'Yaf\\Session'
        ],
        'class' => 'class #class_name# extends Base implements ServiceImpl {',
        'protected_variable' => [
            '#table_name#' => ['', 'string', '查询返回结果'],
            'foreign_key' => ['[]', 'array', '外键关联字段']
        ],
        'construct' => [
            'function' => ''
        ],
        'public_variable' => [
            '#column#' => ['', 'string', '字段']
        ],
        'private_variable' => [
        ],
        'public_function' => [
            'getConstruct' => [
                'function' => '',
                'annotation' => '获取完整表字段信息'
            ],
            'genRealComment' => [
                'function' => '',
                'construct' => ['', 'array', ''],
                'annotation' => ''
            ],
            'tableInfo' => [
                'function' => '',
            ],
            'create' => [
                'function' => '',
                'annotation' => '创建#table_name#',
                'jump' => ['false', 'boolean', '是否throw']
            ],
            'update' => [
                'function' => '',
                'annotation' => '编辑#table_name#'
            ],
            'delete' => [
                'function' => '',
                'annotation' => '删除#table_name#，需先指定主键'
            ],
            'getListByCond' => [
                'condition' => ['', 'array', '查询条件'],
                'page' => ['1', 'integer', '当前页'],
                'page_size' => ['10', 'integer', '每页显示条数'],
                'order' => ['id', 'string', '排序字段'],
                'sort' => ['desc', 'string', '排序方式'],
                'annotation' => '条件查询#table_name#',
                'function' => ''
            ],
            'getOneResult' => [
                'condition' => ['', 'array', '查询条件'],
                'function' => '',
                'annotation' => '查询条件#table_name'
            ],
            'getRealData' => [
                'data' => ['[]', 'array', '需要匹配的数据'],
                'read' => ['false', 'boolean', '是否是读取数据，默认false，写入数据时该值为false，读取数据时该值为true，默认false'],
                'is_excel' => ['false', 'boolean', '是否是execl导出，默认false。该值只在显示/导出数据值有用，导出数据的时候，如果是excel该值为true，反之为false'],
                'annotation' => '获取真实数据',
                'function' => ''
            ],
            'setForeignKey' => [
                'foreignKey' => ['[]', 'array', '外键关联字段'],
                'annotation' => '获取外键关系',
                'function' => ''
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
                                $table_name = ucfirst(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
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
                                $code .= $this->genServiceVariable(substr($key, 0, stripos($key, '_')), [], $file_path);
                            }else{
                                if($variable_name == '#table_name#'){
                                    $variable_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
                                }
                                $code .= $this->genVariable(substr($key, 0, stripos($key, '_')),[$variable_name => ['', 'string', '']]);
                            }
                        }
                        break;
                    case 'construct':
//                        $method = 'gen' . ucfirst($key);
                        $function_main = $this->__genConstruct($file_path);
                        $code .= $this->genConstruct($function_main);
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
                                $function_main = ($function_name == 'getListByCond' || $function_name == 'getOneResult') ? ($function_name == 'getListByCond' ? $this->genSelectFunctionMain($file_path, $parameter_arr) : $this->genSelectFunctionMain($file_path, $parameter_arr, 'one')) : $this->$method_name($file_path, $column_variable_type);
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
        return $code . '}';
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
        $column_string_arr = [];
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            if(empty($this->__column_arr)){
                $this->setColumnArr($file_path);
                foreach($this->__column_arr as $index => $value_arr){
                    if($value_arr['Key'] == 'PRI' && $value_arr['Extra'] == 'auto_increment'){
                        unset($this->__column_arr[$index]);
                    }
                }
            }
//            $code .= "    return %this->_" . $table_name . "->insert(";
            $code .= "    %data = ";
            foreach($this->__column_arr as $key => $column_array){
                $column_string_arr[] = '"' . strtolower($column_array['Field'] . '" => %this->' . ($type == 'private' ? '__' : ($type == 'protected' ? '_' : '')) . strtolower($column_array['Field']));
            }
            $code .= '[' . implode(',', $column_string_arr) . ']' . ";\r\n";
            $code .= "#    \$data = \$this->getRealData([\$data]);#";
            $code .= '#    foreach(%data[0] as %v){#        %real_data[] = %v;#    }';
            $code .= "#    return %this->_" . $table_name . "->insert(%real_data, %jump);";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成update方法的代码
     * @param string $file_path 要生成service的文件名，既表名
     * @param string $type 字段属性的类型，默认值是public
     * @return mixed
     */
    public function genUpdateFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        $column_string_arr = [];
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            if(empty($this->__column_arr)){
                $this->setColumnArr($file_path);
            }
            foreach($this->__column_arr as $key => $column_array){
                $column_name = ($type == 'private' ? '__' : ($type == 'protected' ? '_' : '')) . strtolower($column_array['Field']);
                    $column_string_arr[] = '    if(%this->' . $column_name . ')'.
                        '{#        %data["' . $column_array['Field'] . '"] = %this->' . $column_name . ';' .
                        ($column_array['Key'] == 'PRI' ? '#    }else{#        return ErrorMsg::INVALID_PRIMARY_KEY;#    }#' : '#    }#');
            }
            $code .= implode("#", $column_string_arr) . "#    \$data = \$this->getRealData([\$data]);#    return %this->_" . $table_name . "->update(%data[0]);\r\n";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成delete方法
     * @param string $file_path 要生成service的文件名，既表名
     * @param string $type 字段属性的类型，默认值是public
     * @return mixed
     */
    public function genDeleteFunctionMain($file_path = '', $type = 'public'){
        $code = $column_string = '';
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
//            if(empty($this->__column_arr)){
                $this->setColumnArr($file_path, 'delete');
//            }
            foreach($this->__column_arr as $key => $column_array){
                if($column_array['Key'] == 'PRI'){
                    $column_string = ($type == 'private' ? '__' : ($type == 'protected' ? '_' : '')) . strtolower($column_array['Field']);
                }
            }
            $code = '#    if(!%this->' . $column_string . '){#        return ErrorMsg::INVALID_PRIMARY_KEY;#    }##    return %this->_' . $table_name . '->delete($this->' . $column_string . ');';
        }
        return str_replace('%', '$', $code);
    }

    /**
     * @param string $file_path
     * @param array $parameter_arr
     * @param string $one_or_all
     * @return mixed
     */
    public function genSelectFunctionMain($file_path = '', $parameter_arr = [], $one_or_all = 'all'){
        $code = '';
        $code_arr = [];
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = $one_or_all == 'all' ? '    %result = %this->_'. $table_name .'->findBy(' : '    %result = %this->_'. $table_name .'->findOneBy(';
            foreach($parameter_arr as $parameter_name => $column_default_type_annotation_arr){
                foreach($column_default_type_annotation_arr as $column => $default_type_annotation_arr){
                    $code_arr[] .= '%' . $column;
                }
            }
            $code .= implode(', ', $code_arr) . ');';
            $code .= "#    %result['data'] = %this->getRealData(%result['data'], true);#    return %result;";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * @param string $file_path
     * @return mixed
     */
    private function __genConstruct($file_path = ''){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = "%this->_". $table_name ." = new DAO_" . ucfirst($table_name) . "();#        parent::__construct(%this->_" . strtolower($table_name) . ")";
        }
        return str_replace('%', '$', str_replace('#', "\r\n", $code));
    }

    /**
     * @param string $file_path
     * @return mixed
     */
    public function genGetConstructFunctionMain($file_path = ''){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = '#            return $this->_' . $table_name . '->tableColumnInfo();';
        }
        return str_replace('%', '$', $code);
    }

    /**
     * @param string $file_path
     * @return mixed
     */
    public function genTableInfoFunctionMain($file_path = ''){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = '#        return $this->_' . $table_name . '->tableInfo();';
        }
        return str_replace('%', '$', $code);
    }

    /**
     * @param string $file_path
     * @return mixed
     */
    public function genGenRealCommentFunctionMain($file_path = ''){
        $code = '';
        if(!empty($file_path)){
            $code = "        if(!empty(%construct)){
            %table_name_arr = %field_name_arr = %new_match_arr = %comment_array = [];
            foreach (%construct as %index => %column_construct){
                %i = 0;
                if(strrpos(%column_construct['Comment'], '.') !== false){
                    %comment_arr = explode('.', %column_construct['Comment']);
                    %comment_array[%index] = %comment_arr[count(%comment_arr)-1] = str_replace(['\\'', '\\\"', ' \\'', ' \\\"', '\\' ', '\\\" '], '\\\"', %comment_arr[count(%comment_arr)-1]);
                    preg_match_all(\"/<\\\"(.*)\\\":\\\"(.*)\\\">/Usi\", %comment_arr[count(%comment_arr)-1], %array);
                    if(isset(%array[1]) && !empty(%array[1]) && isset(%array[2]) && !empty(%array[2])){
                        foreach(%array[1] as %key => %condition){
                            if(strpos(%array[2][%key], ',')){
                                %array[2][%key] = explode('_', %array[1][%key+1])[count(explode('_', %array[1][%key+1]))-1];
                            }
                            if(stripos(%condition, 'result_') !== false){
                                %condition = %table_name_arr[%i-1];
                            }
                            %table_name_arr[] = %condition;
                            %field_name_arr[] = %array[2][%key];
                            %i++;
                        }
                    }
                    %match_arr[] = %column_construct['Comment'];
                }
            }

            if(empty(%table_name_arr)){
                return %construct;
            }
            foreach(%table_name_arr as %index => %table_name){
                require_once realpath(dirname(__FILE__)) . '/' . ucfirst(%table_name) . '.php';
                %class_name = '\\models\\Service\\\\' . ucfirst(%table_name);
                %class = new %class_name();
                %table_construct[%index] = %class->getConstruct();
                %table_info[%index] = %class->genRealComment(%table_construct[%index]);
                if(isset(\$table_info[\$index][0]['Create Table'])){
                    preg_match_all('/CHARSET=utf8 COMMENT=\\'(.*)\\'/Usi', %table_info[%index][0]['Create Table'], %table_comment_arr);
                    foreach(%table_construct[%index] as %i => %column){
                        if(in_array(%column['Field'], %field_name_arr)){
                            %key = array_search(%column['Field'], %field_name_arr);
                            %new_match_arr[%table_name] = %table_comment_arr[1][0];
                            %new_match_arr[%column['Field']] = %table_construct[%index][%key]['Comment'];
                        }
                    }
                }
            }

            foreach(%new_match_arr as %key => %val){
                foreach(%comment_array as %k => %v){
                    %construct[%k]['Comment'] = str_replace(['const', 'default', %key], ['数字', '数字(可缺省)', %val], %construct[%k]['Comment']);
                    %construct[%k]['Column_name'] = substr(
                        %construct[%k]['Comment'],
                        0,
                        (strpos(%construct[%k]['Comment'], '.<') !== false ?
                            stripos(%construct[%k]['Comment'], '.<') :
                            (strpos(%construct[%k]['Comment'], '.{') !== false ? 
                                strpos(%construct[%k]['Comment'], '.{') : 
                                (strpos(%construct[%k]['Comment'], '.[<') !== false ?
                                    strpos(%construct[%k]['Comment'], '.[<'):
                                        (strpos(%construct[%k]['Comment'], '.[{<') !== false ?
                                            strpos(%construct[%k]['Comment'], '.[{<') :
                                            %construct[%k]['Comment']                                        
                                        )
                                )
                            )
                        )
                    );
                }
            }
        }
        return %construct;";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * @param string $file_path
     * @return string
     */
    public function genGetRealDataFunctionMain($file_path = ''){
        $code = '';
        if(!empty($file_path)){
            $code = "#        //获取完整的表字段备注#        %table_construct = %this->getConstruct();".
                "#        %foreign_map_arr = %this->genComment(%this->_foreign_key);".
                "##        foreach(%data as %row => %value){".
                "#            foreach(%table_construct as %index => %column_array){".
                "#                if(isset(%value[%column_array['Field']])){".
                "#                    %real_comment = substr(".
                "#                        %column_array['Comment'],".
                "#                        0,".
                "#                        (stripos(%column_array['Comment'], '.<') !== false ?".
                "#                              stripos(%column_array['Comment'], '.<') :".
                "#                                (stripos(%column_array['Comment'], '.{<') !== false ?".
                "#                                    stripos(%column_array['Comment'], '.{<') :".
                "#                                    (stripos(%column_array['Comment'], '.[<') !== false ?".
                "#                                        stripos(%column_array['Comment'], '.[<') :".
                "#                                        (stripos(%column_array['Comment'], '.[{<') !== false ?".
                "#                                            stripos(%column_array['Comment'], '.[{<') :".
                "#                                            strlen(%column_array['Comment'])".
                "#                                        )".
                "#                                    )".
                "#                                )".
                "#                            )".
                "#                    );".
                "#                    //将需要匹配的数据中的所有非法字符(；;， )都换成合法字符(,)".
                "#                    %column_value_arr[%real_comment][] = str_replace(['，', ',', '；', ';'], ',', str_replace(' ', '', %value[%column_array['Field']]));/*%value[%column_array['Field']];*/".
                "#                    if(isset(%foreign_map_arr[%column_array['Field']]) && strpos(%table_construct[%index]['Comment'], %foreign_map_arr[%column_array['Field']]) === false){".
                "#                         %table_construct[%index]['Comment'] = %column_array['Comment'] . '.' . %foreign_map_arr[%column_array['Field']];".
                "#                    }".
                "#                }".
                "#            }".
                "#        }".
                "#        //根据表注释，生成外键查询sql数组#//        %foreign_sql = %this->genSelectSqlV1(%table_construct, %read);".
                "#        %foreign_sql = %this->genSelectSql(%table_construct, %read);".
                "##        if(!empty(%column_value_arr) && %foreign_sql){".
                "#            %data = %this->matchReplace(%table_construct, %foreign_sql, %column_value_arr, %read, %is_excel);".
                "#        }".
                "##        return %data;";
        }
        return str_replace('%', '$', $code);
    }

    public function genSetForeignKeyFunctionMain(){
        $code = "    %this->_foreign_key = %foreignKey;#    return %this;";
        return str_replace('%', '$', $code);
    }
}