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
 * Date: 2018/5/4
 * Time: 下午3:56
 */
require_once __DIR__ . '/GeneratedCode.php';

class GeneratedErrorMsg extends GeneratedCode
{
    private $__column_arr = [];
    protected $_table_idx = 0;

    protected $_code_arr = [
        'start' => '<?php',
        'namespace' => 'ErrorMsg\Api',
        'use' => [
            'ErrorMsg\\AbstractErrorMsg'
        ],
        'class' => 'class #class_name# extends AbstractErrorMsg{',
        'const_variable' => [
            '#table_name#_BATCH_UPDATE_EMPTY_CONDITION' => ['update_column或id不能为空', 'const', ''],
            '#table_name#_BATCH_UPDATE_EMPTY_CONDITION_NO' => ['6x0003', 'const', ''],
            '#table_name#_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE' => ['update_column必须与id为同一数据类型', 'const', ''],
            '#table_name#_BATCH_UPDATE_CONDITION_ID_INVALID_TYPE_NO' => ['6x0004', 'const', ''],
            '#table_name#_BATCH_UPDATE_RETURN_FALSE' => ['批量update语句生成失败', 'const', ''],
            '#table_name#_BATCH_UPDATE_RETURN_FALSE_NO' => ['6x0005', 'const', ''],
            '#table_name#_BATCH_DELETE_RETURN_FALSE' => ['批量delete时参数类型不合法', 'const', ''],
            '#table_name#_BATCH_DELETE_RETURN_FALSE_NO' => ['6x0006', 'const', ''],
            '#table_name#_BATCH_INSERT_RETURN_FALSE' => ['批量insert时参数类型不合法', 'const', ''],
            '#table_name#_BATCH_INSERT_RETURN_FALSE_NO' => ['6x0007', 'const', ''],
            '#table_name#_UPDATE_ID_EMPTY' => ['修改数据时primary_key不能为空', 'const', ''],
            '#table_name#_UPDATE_ID_EMPTY_NO' => ['6x0008', 'const', ''],
            '#table_name#_UPDATE_COLUMN_UPDATE_ARR_INVALID' => ['修改数据时column_arr不合法', 'const', ''],
            '#table_name#_UPDATE_COLUMN_UPDATE_ARR_INVALID_NO' => ['6x0009', 'const', ''],
            '#table_name#_DELETE_ID_EMPTY' => ['删除数据时primary_key不能为空', 'const', ''],
            '#table_name#_DELETE_ID_EMPTY_NO' => ['6x0010', 'const', ''],
        ]
    ];

    public function getTableIndex($file_path){
        $table_info = $this->_getTablesInfo();
        $table_name_arr = [];
        array_walk($table_info, function($value, $idx) use(&$table_name_arr){
            array_push($table_name_arr, $value['TABLE_NAME']);
        });

        $file_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
        $table_name = str_replace('errormsg', '', $file_name);

        return array_search($table_name, $table_name_arr);
    }

    public function generatedErrorMsgCode($file_path = ''){
        $code = '';
        $column_variable_type = 'private';
        $this->setColumnArr($file_path);
        $this->_table_idx = $this->getTableIndex($file_path);

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
                                $table_name = ucfirst(str_replace("ErrorMsg", "", substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
                                $element[$id] = str_replace('#table_name#', $table_name, $use_namespace);
                            }
                        }
                        $code .= $this->genUseCode($element);
                        break;
                    case 'class':
                        $code .= $this->genClass($element, $file_path);
                        break;
                    case 'const_variable':
                        foreach($element as $variable_name => $element_arr){
                            $code .= $this->genConstVariable($variable_name, $element_arr, $file_path);
                        }
                        break;
                }
            }
        }
        return str_replace("#", "\r\n", $code) . '}';
//        exit();
    }

    public function setColumnArr($file_path = '', $operation = '')
    {
        if(!empty($file_path)){
            $table_name = str_replace('errormsg', '', strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))));
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

    public function genConstVariable($variable_name = '', $parameters_arr = [], $file_path = ''){
        if(strrpos($variable_name, '_NO') + 3 == strlen($variable_name)){
            $parameters_arr[0] = str_replace('x', $this->_table_idx, $parameters_arr[0]);
        }
        $file_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
        $table_name = str_replace('errormsg', '', $file_name);
        $variable_name = strtoupper(str_replace('#table_name#', $table_name, $variable_name));
        $res = $this->genVariable('const', [$variable_name => $parameters_arr], false);
        return $res;
    }


}