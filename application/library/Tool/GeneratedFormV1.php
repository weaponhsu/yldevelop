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
 * Date: 2016-07-07
 * Time: 下午 4:58
 */

require_once __DIR__ . '/GeneratedCode.php';

class GeneratedFormV1 extends GeneratedCode
{
    protected $_code_arr = [
        'start' => '<?php',
        'namespace' => 'models\\Form\\admin\\#table_name#',
        'use' => [
            'models\\Form\\AbstractFormBuilder'
        ],
        'class' => 'class #class_name# extends AbstractFormBuilder{',
        'public_variable' => [],
        'protected_variable' => [
            'type' => [
                '',
                'string',
                '可根据该参数判断_fields数组总应该增减哪些键值对'
            ],
            'fields' => [
                '',
                'array',
                '#需要填充到表单里的数组，该数组由table中每个column的相关属性确定，主要格式：
                #//column
                #"mobile" => [
                #    //comment
                #    "label" => "主键",
                #    //column
                #    "name" => "id",
                #    //如果是主键就是hidden，反之就根据column的类型来定，对应关系int/varchar/date => text、boolean => radio、text => textarea
                #    "type" => "hidden",
                #    //一个属性一个键，对应一个值
                #    "attr" => [
                #        //是否必须根据column的null来判断
                #        "required" => true,
                #        //XXX为column的comment
                #        "placeholder" => "请输入XXX",
                #        //input的class
                #        "class" => "form-control",
                #        //input的错误信息提示，主要配合error使用
                #        "data-error" => "data-error"
                #    ], 
                #    //表单验证规则
                #    "validator" => [
                #        //字段允许提交的类型 根据数据结构设置
                #        "type" => "string",
                #        //字段允许长度 根据数据结构设置
                #        "length" => [
                #            "min" => "11",
                #            "max" => "11",
                #        ],
                #        //自定义验证规则，必须是数组
                #        "customer" => [
                #            "mobile",
                #            ……
                #        ],
                #    ],
                #    //当表单验证失败时需要回填到表单上的值，也就是用户输入的值
                #    "value" => "1", 
                #    //表单验证失败时，需要提示在页面上让用户看的错误提示信息
                #    "error" => ""
                #]'
            ]
        ],
        'private_variable' => [],
        'public_function' => [
            'setFields' => [
                'fields' => ['', 'string', ''],
                'function' => '        $this->_fields = $fields;#        return $this;'
            ],
            'getFields' => [
                'function' => '        return $this->_fields;'
            ],
            'generateForm' => [
                'type' => ['', 'string', '类型 需要根据type参数的值删减_fields数组中的键值对'],
                'action' => ['', 'string', '接受表单的action，就是/module/controller/action中的action'],
                'method' => ['', 'string', '表单提交类型，一般是POST，也可以是GET,DELETE,PUT'],
                'function' => '    $this->_type = $type;#    $this->__refreshFields();#    return $this->createBuilder($action, $method);'
            ],
            'fillData' => [
                'data' => ['', 'array', '要填充到form里的_fields数组，通常情况下是填充过value和error的数组'],
                'function' => '    foreach($data as $column => $value){#        if(isset($this->_fields[$column])){#            $this->_fields[$column][\'value\'] = $value;#        }#    }#    return $this;'
            ],
            'getView' => [
                'function' => '    foreach($this->_fields as $input => $value){#        if($input == \'button\'){#            foreach($value as $button_name => $val){#                $this->add($val[\'type\'], $val[\'label\'], $val[\'name\'], $val[\'attr\']);#            }#        }else{#        $this->add($value[\'type\'], $value[\'label\'], $value[\'name\'], $value[\'attr\'], isset($value[\'value\']) ? $value[\'value\'] : \'\', isset($value[\'error\']) ? $value[\'error\'] : \'\');#        }#    }##    return $this->getHtml();'
            ],
            'isValid' => [
                'function' => '    foreach($this->_fields as $value){#        if(isset($value[\'validator\'])){#            $validator_arr[$value[\'name\']] = $value[\'validator\'];#        }#    }##    if(!empty($validator_arr)){#        $result = $this->validation($validator_arr);#        if($result !== true){#            $this->_setError($result->getError());#            $this->_setValue($result->getValue());#        }else{#            return true;#        }#    }##    return $this->_fields;'
            ],
            'getErrorArray' => [
                'function' => '        $result = [];#        foreach($this->_fields as $field_name => $field){#            if(!empty($field[\'error\'])){#                $result[] = [\'field\' => $field_name, \'error\' => $field[\'error\']];#            }#        }##        return $result;'
            ]
        ],
        'protected_function' => [
            'setValue' => [
                'value_array' => ['', 'array', '要填充到_fields数组的value键的值'],
                'function' => '    foreach($value_array as $name => $value){#        foreach($this->_fields as $input_name => $value_arr){#            if($input_name == $name){#                $this->_fields[$input_name][\'value\'] = $value;#            }#        }#    }'
            ],
            'setError' => [
                'error_array' => ['', 'array', '要填充到_fields数组的error键的值'],
                'function' => '    foreach($error_array as $name => $value){#        foreach($this->_fields as $input_name => $error_arr){#            if($input_name == $name){#                $this->_fields[$input_name][\'attr\'][\'data-error\'] = $this->_fields[$input_name][\'error\'] = $value;#            }#        }#    }'
            ]
        ],
        'private_function' => [
            'refreshFields' => [
                'function' => '#'
            ]
        ]
    ];

    public function generatedFormCode($file_path = ''){
        $code = '';
        if(!empty($this->_code_arr) && !empty($file_path)){
            foreach($this->_code_arr as $key => $element){
                switch ($key){
                    case 'start':
                        $code .= $this->genStartCode($element);
                        break;
                    case 'namespace':
                        if(strpos($element, '#table_name#') !== false){
                            $element = str_replace('#table_name#', ucfirst(substr($file_path, strrpos($file_path, '/')+1, strrpos($file_path, 'Form.php') - strrpos($file_path, '/') - 1)), $element);
                        }
                        $code .= $this->genNamespaceCode($element);
                        break;
                    case 'use':
                        $code .= $this->genUseCode($element);
                        break;
                    case 'class':
                        $code .= $this->genClass($element, $file_path);
                        break;
                    case 'public_variable':
                    case 'protected_variable':
                    case 'private_variable':
                        foreach($element as $variable_name => $element_arr){
                            $code .= $variable_name == 'fields' ?
                                $this->genVariable(substr($key, 0, strpos($key, "_")), [$variable_name => $element_arr], true, $file_path) :
                                $this->genVariable(substr($key, 0, strpos($key, "_")), [$variable_name => $element_arr]);
                        }
                        break;
                    case 'public_function':
                    case 'protected_function':
                    case 'private_function':
                        foreach($element as $function_name => $parameter_function_arr){
                            $parameter_arr = [];
                            $function = '';
                            foreach($parameter_function_arr as $k => $v){
                                if($k != 'function'){
                                    $parameter_arr[] = [$k => $v];
                                }else{
                                    $function = $v;
                                }
                            }
                            $code .= $this->genFunction(substr($key, 0, stripos($key, '_')), $function_name, $parameter_arr, $function);
                        }
                        break;
                }
            }
        }
        return $code . '}';
    }

}