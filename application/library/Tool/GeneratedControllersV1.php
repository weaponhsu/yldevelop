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
 * Time: 下午 6:03
 */

require_once __DIR__ . '/GeneratedCode.php';

class GeneratedControllersV1 extends GeneratedCode
{
    private $__column_arr = [];

    protected $_code_arr = [
        'start' => '<?php',
        'namespace' => '',
        'use' => [
            'Yaf\Session',
            'Yaf\Registry',
            'models\Form\admin\#table_name#\#table_name#Form',
            'models\Service\#table_name# as #table_name#Service',
            'ErrorMsg\Admin\ErrorTips'
        ],
        'class' => 'class #class_name#Controller extends BaseController{',
        'private_variable' => [
            '#table_name#_form' => ['', 'string', '表单'],
            '#table_name#_service' => ['', 'string', '服务'],
            'foreign_relationship_result' => ['', 'array', '外键关联']
        ],
        'construct' => [
            'function' => ''
        ],
        'public_variable' => [
        ],
        'protected_variable' => [
        ],
        'public_function' => [
            'init' => [
                'function' => ''
            ],
            'indexAction' => [
                'function' => ''
            ],
            'dataAction' => [
                'function' => ''
            ],
            /*'operationAction' => [
                'function' => ''
            ],*/
            'createAction' => [
                'function' => ''
            ],
            'storeAction' => [
                'function' => ''
            ],
            /*'storeV1Action' => [
                'function' => ''
            ],*/
            'editAction' => [
                'function' => ''
            ],
            'updateAction' => [
                'function' => ''
            ],
            /*'updateV1Action' => [
                'function' => ''
            ],*/
            'deleteAction' => [
                'function' => ''
            ],
            /*'deleteV1Action' => [
                'function' => ''
            ]*/
        ],
        'protected_function' => [],
        'private_function' => [
            'refreshFields' => [
                'function' => '',
                'annotation' => '',
                '#table_name#_service' => ['', 'string', '测试']
            ]
        ]
    ];

    public function generatedControllersCode($file_path = ''){
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
                                $element[$id] = str_replace('#table_name#', $table_name, $use_namespace);
                            }
                        }
                        $code .= $this->genUseCode($element);
                        break;
                    case 'class':
                        $code .= $this->genClass($element, $file_path, true);
                        break;
                    case 'public_variable':
                    case 'protected_variable':
                    case 'private_variable':
                        foreach($element as $variable_name => $element_arr){
                            if($variable_name == '#column#'){
                                $column_variable_type = substr($key, 0, stripos($key, '_'));
                                $code .= $this->genServiceVariable(substr($key, 0, stripos($key, '_')), [], $file_path);
                            }else{
                                if(strpos($variable_name, '#table_name#') !== false){
                                    $variable_name = str_replace("#table_name#", strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/')))), $variable_name);
                                }
                                $code .= $this->genVariable(substr($key, 0, stripos($key, '_')),[$variable_name => ['', 'string', '']]);
                            }
                        }
                        break;
                    /*case 'construct':
//                        $method = 'gen' . ucfirst($key);
                        $function_main = $this->__genConstruct($file_path);
                        $code .= $this->genConstruct($function_main);
                        break;*/
                    case 'public_function':
                    case 'protected_function':
                    case 'private_function':
                        foreach($element as $function_name => $parameter_function_arr){
                            $parameter_arr = [];
                            $function = $annotation = '';
                            foreach($parameter_function_arr as $k => $v){
                                if($k != 'function' && $k != 'annotation'){
                                    $parameter_arr[] = [(strpos($k, '#') !== false ? $this->_setAnnotationString($file_path, $k) : $k) => $v];
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
                                $function_main =
                                    ($function_name == 'getListByCond' || $function_name == 'getOneResult') ?
                                        ($function_name == 'getListByCond' ?
                                            $this->genSelectFunctionMain($file_path, $parameter_arr) :
                                            $this->genSelectFunctionMain($file_path, $parameter_arr, 'one')
                                        ) :
                                        $this->$method_name($file_path, $column_variable_type);
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
     * 生成controller初始化函数
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $type 与表名对应的变量名的属性，可选值public protected private
     * @return mixed
     */
    public function genInitFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) && in_array($type, ['public', 'protected', 'private'])){
            $table_name = ucfirst(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = '    %this->' . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . strtolower($table_name) . '_form = new ' . ucfirst($table_name) . 'Form();';
            $code .= '#    %this->_getForeignTable();#    %this->__foreign_relationship_result = isset(%this->_foreign_relationship_result["' . strtolower($table_name) . '"]) ? %this->_foreign_relationship_result["' . strtolower($table_name) . '"] : "";';
//            $code .= '    $this->' . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . strtolower($table_name) . '_service = new ' . ucfirst($table_name) . 'Service();';
//            $code .= '##        $old_field = $this->' . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . strtolower($table_name) . '_form->getFields();'.
//                '##        foreach($this->'  . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . strtolower($table_name) .  '_service->genRealComment($this->' . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . strtolower($table_name) . '_service->getConstruct()) as $index => $column){'.
//                '#            if(isset($old_field[$column["Field"]])){' .
//                '#                $old_field[$column["Field"]]["attr"]["placeholder"] = "请输入" . str_replace(["<\"", "\">", "\""], "\"", $column["Comment"]);'.
//                '#                $old_field[$column["Field"]]["label"] = isset($column["Column_name"]) ? $column["Column_name"] : $old_field[$column["Field"]]["label"];'.
//                '#            }'.
//                '#        }'.
//                '##        $this->' . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . strtolower($table_name) . '->setFields($old_field);';
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成controller的indexAction
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @return mixed
     */
    public function genIndexActionFunctionMain($file_path = ''){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $table_name_arr = [];
            if(strpos($table_name, '_') !== false){
                foreach(explode('_', $table_name) as $k => $v){
                    $table_name_arr[] = $k == 0 ? $v : ucfirst($v);
                }
            }
            $code = "#    %this->_setHeader();#    %this->_setLeftMenu();#    %this->getView()->assign('csrf', Session::getInstance()->get('csrf'))->display('" . (!empty($table_name_arr) ? implode('', $table_name_arr) : $table_name) . "/index.phtml');#    %this->_setFooter();";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成controller的dataAction
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @return mixed
     */
    public function genDataActionFunctionMain($file_path = ''){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = "   if(Registry::get('method') == 'POST'){#        %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();".
                "#        %condition = !isset(Registry::get('parameters')['filters']) ? [] : json_decode(Registry::get('parameters')['filters'], true);".
                "#        echo json_encode(".
                "%" . $table_name . "_service->setForeignKey(%this->__foreign_relationship_result)->getListByCond(%condition, Registry::get('parameters')['page'] ? Registry::get('parameters')['page'] : 1, ".
                "Registry::get('config')['admin']['page_size'], Registry::get('parameters')['sidx'] ? Registry::get('parameters')['sidx'] : '', Registry::get('parameters')['sord'] ? Registry::get('parameters')['sord'] : ''));#   }";
        }
        return str_replace('%', '$', $code);
    }

    public function genOperationActionFunctionMain($file_path = ''){
        $code = '';
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
//            $code = "   if(Registry::get('method') == 'POST'){#        %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();#        echo json_encode(".
//                "%" . $table_name . "_service->setForeignKey(%this->__foreign_relationship_result)->getListByCond([], Registry::get('parameters')['page'] ? Registry::get('parameters')['page'] : 1, ".
//                "Registry::get('config')['admin']['page_size'], Registry::get('parameters')['sidx'] ? Registry::get('parameters')['sidx'] : '', Registry::get('parameters')['sord'] ? Registry::get('parameters')['sord'] : ''));#   }";
            $code = "#    %result = [];#".
                "     switch (Registry::get(\"parameters\")['oper']){#".
                "        case 'add':#".
                "           %result = %this->storeV1Action();#".
                "           break;#".
                "        case 'edit':#".
                "            %result = %this->updateV1Action();#".
                "            break;#".
                "        case 'del':#".
                "            %result = %this->deleteV1Action();#".
                "            break;#".
                "     }#".
                "     echo json_encode(%result);";
        }
        return str_replace('%', '$', $code);

    }

    /**
     * 生成controller的createAction
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $type 与表名对应的变量名的属性，可选值public protected private
     * @return mixed
     */
    public function genCreateActionFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) && in_array($type, ['public', 'protected', 'private'])){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = "#    %this->_setHeader();#    %this->_setLeftMenu();#    %this->getView()->assign('form', %this->" . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . strtolower($table_name) . "_form->generateForm('create', 'store', 'post')->getView());#    %this->display('create');#    %this->_setFooter();";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成controller的storeAction
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $type 与表名对应的变量名的属性，可选值public protected private
     * @return mixed
     */
    public function genStoreActionFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) && in_array($type, ['public', 'protected', 'private'])){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = "        %parameter_arr = [];##        if(Registry::get('method') == 'POST'){#" .
                "#                //表单验证成功#            if(%this->" . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . $table_name . "_form->isValid() === true){#" .
                "                %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();#                %this->__refreshFields(%". $table_name ."_service);##";
            $code .= $this->__genServiceOperationChain($file_path, 'store');
            $code .= "%parameter_arr = [#" . "                    'redirect_url' => '/admin/" . (strpos($table_name, '_') === false ? $table_name : implode('', explode('_', $table_name))) . "/index',#" .
                "                    'title' => ErrorTips::" . strtoupper($table_name) . "_CREATE_SUCCESS,#" .
                "                    'description' => ErrorTips::" . strtoupper($table_name) . "_CREATE_SUCCESS_DESCRIPTION,#" .
                "                ];#". "            }else{#                //表单验证失败#".
                "                %this->getView()->assign('form', %this->" . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . $table_name . "_form->generateForm('create', 'store', 'post')->getView());##" .
                "                %this->_setHeader();#".
                "                %this->_setLeftMenu();#".
                "                %this->display('create');#".
                "                %this->_setFooter();exit;#            }#        }##" .
                "        %this->_redirect_url(%parameter_arr);#            ";
        }
        return str_replace('%', '$', $code);
    }


    /**
     * 生成controller的storeV1Action
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $type 与表名对应的变量名的属性，可选值public protected private
     * @return mixed
     */
    public function genStoreV1ActionFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) && in_array($type, ['public', 'protected', 'private'])){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = "        %parameter_arr = ['code' => '001', 'message' => '非法请求'];##    if(Registry::get('method') == 'POST'){#" .
                "#        //表单验证成功#        if(%this->" . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . $table_name . "_form->isValid() === true){#" .
                "            %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();#            %this->__refreshFields(%". $table_name ."_service);##";
            $code .= $this->__genServiceOperationChain($file_path, 'store');
            $code .= "            %parameter_arr = [#" .
                "                'code' => ! %store_result instanceof Exception ? '000' : '999',#" .
                "                'message' => ! %store_result instanceof Exception ? ErrorTips::" . strtoupper($table_name) . "_CREATE_SUCCESS : %store_result->getMessage(),#" .
                "            ];#". "        }else{#            //表单验证失败#".
                "            %parameter_arr = [#               'code' => '002',#".
                "               'message' => %this->". ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . $table_name . "_form->getErrorArray()#".
                "            ];#".
                "            }#               }#".
                "        return %parameter_arr;";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成controller里的updateAction
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $type 与表名对应的变量名的属性，可选值public protected private
     * @return mixed
     */
    public function genUpdateActionFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) && in_array($type, ['public', 'protected', 'private'])){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            /*$table_name_arr = [];
            if(strpos($table_name, '_') !== false){
                foreach(explode('_', $table_name) as $k => $v){
                    $table_name_arr[] = $k == 0 ? $v : ucfirst($v);
                }
            }
            if(!empty($table_name_arr)){
                $table_name = implode('', $table_name_arr);
            }*/

            $code = "    %parameter_arr = [];##    if(Registry::get('method') == 'POST'){#" .
                "         if(%this->" . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . $table_name . "_form->isValid() === true){#" .
                "              %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();#              %this->__refreshFields(%". $table_name ."_service);##";
            $code .= $this->__genServiceOperationChain($file_path, 'update');
            $code .= "#              %parameter_arr = [#" .
                    "                  'redirect_url' => '/admin/" . $table_name . "/index',#" .
                    "                  'title' => ErrorTips::" . strtoupper($table_name) . "_EDIT_SUCCESS,#" .
                    "                  'description' => ErrorTips::" .  strtoupper($table_name). "_EDIT_SUCCESS_DESCRIPTION,#" .
                    "              ];##" .
                    "         }else{##" .
                    "             //表单验证失败#" .
                    "             %this->_setHeader();#".
                    "             %this->_setLeftMenu();#".
                    "             %this->getView()->assign('form', %this->" . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . $table_name . "_form->generateForm('update', 'update', 'post')->getView());#" .
                    "             %this->display('edit');#" .
                    "             %this->_setLeftMenu();exit;#".
                    "         }#" .
                    "    }##" .
                    "    %this->_redirect_url(%parameter_arr);";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成controller里的updateV1Action
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $type 与表名对应的变量名的属性，可选值public protected private
     * @return mixed
     */
    public function genUpdateV1ActionFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) && in_array($type, ['public', 'protected', 'private'])){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            /*$table_name_arr = [];
            if(strpos($table_name, '_') !== false){
                foreach(explode('_', $table_name) as $k => $v){
                    $table_name_arr[] = $k == 0 ? $v : ucfirst($v);
                }
            }
            if(!empty($table_name_arr)){
                $table_name = implode('', $table_name_arr);
            }*/

            $code = "    %parameter_arr = ['code' => '001', 'message' => '非法请求'];##    if(Registry::get('method') == 'POST'){#" .
                "         if(%this->" . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . $table_name . "_form->isValid() === true){#" .
                "              %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();#              %this->__refreshFields(%". $table_name ."_service);##";
            $code .= $this->__genServiceOperationChain($file_path, 'update');
            $code .= "#              %parameter_arr = [#" .
                "                    'code' => ! %update_result instanceof Exception ? '000' : '999',#" .
                "                    'message' => ! %update_result instanceof Exception ? ErrorTips::" . strtoupper($table_name) . "_EDIT_SUCCESS : %update_result->getMessage(),#" .
                "                ];##" .
                "            }else{##" .
                "                //表单验证失败#" .
                "                %parameter_arr = [#".
                "                    'code' => '002',#".
                "                    'message' => %this->" . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . $table_name . "_form->getErrorArray()#".
                "                ];#".
                "            }#" .
                "        }##" .
                "        return %parameter_arr;";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成controller里的deleteAction
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $type 与表名对应的变量名的属性，可选值public protected private
     * @return mixed
     */
    public function genDeleteActionFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) && in_array($type, ['public', 'protected', 'private'])){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            /*$table_name_arr = [];
            if(strpos($table_name, '_') !== false){
                foreach(explode('_', $table_name) as $k => $v){
                    $table_name_arr[] = $k == 0 ? $v : ucfirst($v);
                }
            }
            if(!empty($table_name_arr)){
                $table_name = implode('', $table_name_arr);
            }*/

            $code = "#    %return_arr = ['msgCode' => '002', 'message' => ErrorTips::" . strtoupper($table_name) . "_NOT_EXISTS];##" .
                "    if(Registry::get('method') == 'POST'){#".
                "        %id_arr = explode(',', Registry::get('parameters')['id']);##" .
                "        if(!empty(%id_arr)){#" .
                "            %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();#" .
                "            foreach(%id_arr as %id){#";
            $code .= $this->__genServiceOperationChain($file_path, 'delete');
            $code .= "            }#".
                "            %return_arr = ['msgCode' => '000', 'message' => ErrorTips::" . strtoupper($table_name) . "_DELETE_SUCCESS];#".
//                "        %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();#" .
//                "        %" . $table_name . "_is_exists = %" . $table_name . "_service->getOneResult(['id' => Registry::get('parameters')['id']]);##".
//                "        %return_arr = ['msgCode' => '001', 'message' => ErrorTips::" . strtoupper($table_name) . "_NOT_EXISTS];#".
//                "        if(isset(%" . $table_name . "_is_exists['data']) && !empty(%" . $table_name . "_is_exists['data'])){#";
//            $code .= $this->__genServiceOperationChain($file_path, 'delete');
//            $code .= "#            %return_arr = ['msgCode' => '000', 'message' => ErrorTips::" . strtoupper($table_name) . "_DELETE_SUCCESS];#".
//                "                %parameter_arr = [#".
//                "                    'redirect_url' => '/admin/user/index',#".
//                "                    'title' => ErrorTips::USER_DELETE_SUCCESS,#".
//                "                   'description' => ErrorTips::USER_DELETE_SUCCESS_DESCRIPTION,#".
//                "                ];#".
                "        }#".
                "    }##".
                "    echo json_encode(%return_arr);#";
//                "        %this->_redirect_url(%parameter_arr);#";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成controller里的deleteV1Action
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $type 与表名对应的变量名的属性，可选值public protected private
     * @return mixed
     */
    public function genDeleteV1ActionFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) && in_array($type, ['public', 'protected', 'private'])){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            /*$table_name_arr = [];
            if(strpos($table_name, '_') !== false){
                foreach(explode('_', $table_name) as $k => $v){
                    $table_name_arr[] = $k == 0 ? $v : ucfirst($v);
                }
            }
            if(!empty($table_name_arr)){
                $table_name = implode('', $table_name_arr);
            }*/

            $code = "#    %parameter_arr = ['code' => '002', 'message' => ErrorTips::" . strtoupper($table_name) . "_NOT_EXISTS];##" .
                "    if(Registry::get('method') == 'POST'){#".
                "        %id_arr = explode(',', Registry::get('parameters')['id']);##" .
                "        if(!empty(%id_arr)){#" .
                "            %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();#" .
                "            foreach(%id_arr as %id){#";
            $code .= $this->__genServiceOperationChain($file_path, 'delete');
            $code .= "            }#".
                "            %parameter_arr = ['code' => '000', 'message' => ErrorTips::" . strtoupper($table_name) . "_DELETE_SUCCESS];#".
//                "        %" . $table_name . "_service = new " . ucfirst($table_name) . "Service();#" .
//                "        %" . $table_name . "_is_exists = %" . $table_name . "_service->getOneResult(['id' => Registry::get('parameters')['id']]);##".
//                "        %return_arr = ['msgCode' => '001', 'message' => ErrorTips::" . strtoupper($table_name) . "_NOT_EXISTS];#".
//                "        if(isset(%" . $table_name . "_is_exists['data']) && !empty(%" . $table_name . "_is_exists['data'])){#";
//            $code .= $this->__genServiceOperationChain($file_path, 'delete');
//            $code .= "#            %return_arr = ['msgCode' => '000', 'message' => ErrorTips::" . strtoupper($table_name) . "_DELETE_SUCCESS];#".
//                "                %parameter_arr = [#".
//                "                    'redirect_url' => '/admin/user/index',#".
//                "                    'title' => ErrorTips::USER_DELETE_SUCCESS,#".
//                "                   'description' => ErrorTips::USER_DELETE_SUCCESS_DESCRIPTION,#".
//                "                ];#".
                "        }#".
                "    }##".
                "    return %parameter_arr;#";
//                "        %this->_redirect_url(%parameter_arr);#";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * 生成controller的editAction
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $type 与表名对应的变量名的属性，可选值public protected private
     * @return mixed
     */
    public function genEditActionFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) || in_array($type, ['public', 'protected', 'private'])){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            /*$table_name_arr = [];
            if(strpos($table_name, '_') !== false){
                foreach(explode('_', $table_name) as $k => $v){
                    $table_name_arr[] = $k == 0 ? $v : ucfirst($v);
                }
            }
            if(!empty($table_name_arr)){
                $table_name = implode('', $table_name_arr);
            }*/

            $code = "    %" . $table_name . "_service = new " . ucfirst($table_name) . "service();#    %this->__refreshFields(%". $table_name ."_service);##    %" . $table_name . "_is_exists = %" . $table_name . "_service->setForeignKey(%this->__foreign_relationship_result)->getOneResult(['id' => Registry::get('parameters')['id']]);" .
                "#    if(!isset(%" . $table_name . "_is_exists['data']) || empty(%" . $table_name . "_is_exists['data'])){".
                "#        %parameter_arr = [".
                "#            'redirect_url' => '/admin/". $table_name ."/index',".
                "#            'title' => ErrorTips::". strtoupper($table_name) ."_NOT_EXISTS," .
                "#            'description' => ErrorTips::". strtoupper($table_name) ."_NOT_EXISTS,".
                "#        ];".
                "#".
                "#".
                "        %this->_redirect_url(%parameter_arr);#".
                "    }##".
                "    %this->_setHeader();#".
                "    %this->_setLeftMenu();#".
                "    %this->getView()->assign('form', %this->" . ($type == 'protected' ? '_' : ($type == 'private' ? '__' : '')) . $table_name . "_form->generateForm('edit', 'update', 'post')->fillData(%" . $table_name . "_is_exists['data'][0])->getView());##" .
                "    %this->display('edit');";
        }
        return str_replace('%', '$', $code);
    }

    /**
     * @param string $file_path
     * @return $this
     */
    public function setColumnArr($file_path = '')
    {
        if(!empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $this->__column_arr = $this->_getTableConstruct($table_name);
        }
        return $this;
    }

    /**
     * 生成service的链式操作
     * @param string $file_path controller所在路径，用以获取表名，生成与之对应的form的变量名
     * @param string $operation controller里默认的操作类型，可选值store update delete
     * @return string
     */
    private function __genServiceOperationChain($file_path = '', $operation = 'store'){
        $code = $real_field_name = '';
        $operation_method_arr = [
            'store' => 'create',
            'update' => 'update',
            'delete' => 'delete'
        ];
        if(!empty($file_path) && in_array($operation, ['store', 'update', 'delete'])){
            $code_arr = [];
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            if(empty($this->__column_arr)){
                $this->setColumnArr($file_path);
            }
            $code_arr[] = '               ' . (($operation == 'store' || $operation == 'update') ? '%' . $operation . '_result = ' : '') . '%' . $table_name . '_service' .
                ($operation == 'update' ? '->setForeignKey(%this->__foreign_relationship_result)' : '');
            foreach($this->__column_arr as $key => $column_value){
                //将包含_的字段名拆分生成对应的函数名，如：created_at => setCreatedAt
                if(strpos($column_value['Field'], '_') !== false){
                    $field_arr = explode('_', $column_value['Field']);
                    foreach($field_arr as $v){
                        $real_field_name .= ucfirst($v);
                    }
                }
                //若是insert数据，则生成除了字段为autoincrement的所有字段的set方法
                if($operation == 'store' && /*$column_value['Key'] != 'PRI'*/$column_value['Extra'] != 'auto_increment' && $column_value['Field'] != 'created_at' && $column_value['Field'] != 'updated_at'){
                    $code_arr[] = "set" . (!empty($real_field_name) ? $real_field_name : ucfirst($column_value['Field'])) . "(Registry::get('parameters')['" . strtolower($column_value['Field']) . "'])";
                }
                if($operation == 'update' && strtolower($column_value['Field']) != 'created_at' && strtolower($column_value['Field']) != 'updated_at'){
                    $code_arr[] = "set" . (!empty($real_field_name) ? $real_field_name : ucfirst($column_value['Field'])) . "(Registry::get('parameters')['" . strtolower($column_value['Field']) . "'])";
                }
                //若是update或delete数据，则只生成setId这个方法
                /*if(in_array($operation, ['delete', 'update']) && $column_value['Key'] == 'PRI'){*/
                if($operation == 'delete' && $column_value['Key'] == 'PRI'){
                    $code_arr[] = "set" . (!empty($real_field_name) ? $real_field_name : ucfirst($column_value['Field'])) . "(%id)";
                }
                $real_field_name = '';
            }
            $code_arr[] = "" . $operation_method_arr[$operation] . "();";
            $code = implode('->', $code_arr);
        }
        if($operation == 'update'){
//            echo $code;exit;
        }
        return $code;
    }

    /**
     * 生成refreshFields方法
     * @param string $file_path
     * @param string $type
     * @return mixed
     */
    public function genRefreshFieldsFunctionMain($file_path = '', $type = 'public'){
        $code = '';
        if(!empty($file_path) || in_array($type, ['public', 'protected', 'private'])){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $code = "        if(%" . $table_name . "_service instanceof " . ucfirst($table_name) . "Service){#            %old_field = %this->__" . $table_name . "_form->getFields();" .
                "#            foreach(%"  . $table_name .  "_service->genRealComment(%"  . $table_name .  "_service->getConstruct()) as %index => %column){".
                "#                if(isset(%old_field[%column['Field']])){".
                "#                    %old_field[%column['Field']]['attr']['placeholder'] = '请输入' . str_replace(['\"\\<\"\"', '\"\\\">\"', \"\\\"\"], '', %column['Comment']);".
                "#                    %old_field[%column['Field']]['label'] = isset(%column['Column_name']) ? %column['Column_name'] : %old_field[%column['Field']]['label'];".
                "#                }".
                "#            }".
                "##            %this->__"  . $table_name .  "_form->setFields(%old_field);".
                "#            return true;".
                "#        }".
                "#        return false;";
        }
        return str_replace('%', '$', $code);
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

    protected function _setAnnotationString($file_path = '', $func_parameter_name = ''){
        $return = '';
        if(!empty($func_parameter_name) && !empty($file_path)){
            $table_name = strtolower(substr($file_path, strrpos($file_path, '/')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '/'))));
            $return = str_replace(['#', 'table_name'], ['', $table_name], $func_parameter_name);
        }
        return $return;
    }
}