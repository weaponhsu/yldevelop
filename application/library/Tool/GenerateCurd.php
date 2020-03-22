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
 * Time: 下午 2:05
 */

class GenerateCurd
{
    /**
     * @var 要生成对应crud方法的表名
     */
    private $__table_name;

    private $__file_arr;

    private $__write_file_arr;

    /**
     * @var
     * 要生成的文件类型 DAO、FORM、SERVICE、CONTROLLER、PHTML、ACTIONS及其对应的生成目录
     */
    protected $_allowed_file = [
//        'dao' => BASEPATH.'application/models/DAO/#table_name#.php',
//        'form' => BASEPATH.'application/models/Form/admin/#table_name#/#table_name#Form.php',
//        'service' => BASEPATH.'application/models/Service/#table_name#.php',
//        'controller' => BASEPATH.'application/modules/Admin/controllers/#table_name#.php',
//        'actions' => 'application/Admin/#table_name#/#action_name#.php',

        'model' => BASEPATH . 'application/models/DAO/#table_name#Model.php',
//        'form' => BASEPATH.'application/models/Form/admin/#table_name#/#table_name#Form.php',
        'service' => BASEPATH.'application/models/Service/#table_name#Service.php',
//        'controller' => BASEPATH.'application/modules/Admin/Controllers/#table_name#.php',
        'transformer' => BASEPATH . 'application/models/Transformer/#table_name#Transformer.php',
//        'phtml' => BASEPATH.'application/modules/Admin/views/#table_name#/#action_name#.phtml',
        'errormsg' => BASEPATH . 'application/library/ErrorMsg/Api/#table_name#ErrorMsg.php'
    ];

    /**
     * @var array
     * 要重写的文件类型
     */
    protected $_rewrite_file = [
        'errorTips' => BASEPATH.'application/library/ErrorMsg/Admin/ErrorTips.php',
//        'errorMsg' => 'application/library/ErrorMsg/Admin/ErrorMsg.php'
    ];

    /**
     * @var array
     * 每个controller需要生成的方法，及其这些方法到底放在哪个文件里：controller表示要放在controller里，action表示要放在actions里
     */
    protected $_action_arr = [
        'index' => 'controller',
        'data' => 'controller',
        'create' => 'controller',
        'store' => 'controller',
        'edit' => 'controller',
        'update' => 'controller',
        'delete' => 'controller'
    ];

    /**
     * @var array
     * 允许生成的代码类型
     */
    protected $_code_arr = [
//        'dao',
        'Model',
//        'Form',
        'Service',
//        'Controllers',
//        'phtml',
        'Transformer',
        'ErrorMsg'
    ];

    /**
     * @var 文件头注释
     */
    protected $_file_head_note = "";

    /**
     * @var 函数注释
     */
    protected $_function_note;

    /**
     * @var 文件的命名空间
     */
    protected $_namespace;

    /**
     * @var 文件内所使用的所有类的use
     */
    protected $_use;

    /**
     * @var 类型
     */
    protected $_class_name;

    /**
     * @var 父类
     */
    protected $_extend_class;

    protected $_protected_function;

    protected $_private_function;

    protected $_public_function;

    protected $_filter_parameter_arr;

    public function __construct($table_name = '', $filter_parameter_arr = [], $action_name = 'crud'){
        $this->__table_name = !empty($table_name) ? strtolower(trim($table_name)) : '';
        $this->_filter_parameter_arr = !empty($filter_parameter_arr) && is_array($filter_parameter_arr) ? $filter_parameter_arr : [];
        if(empty($this->__table_name)) {
            return 1;
        }
        if($action_name !== 'crud'){
            foreach ($this->_allowed_file as $action => $file_path){
                if($action_name != $action){
                    unset($this->_allowed_file[$action]);
                }
            }
        }
    }

    public function getFilePath(){
        $path_arr = $path_array = $write_file_arr = [];
        foreach($this->_allowed_file as $type => $path){
            if($type === 'phtml'){
                foreach($this->_action_arr as $action_name => $file_path){
//                    if($action_name != 'data'){
                    if(!in_array($action_name, ['data', 'delete', 'update', 'store'])){
                        $real_file_path = str_replace("#action_name#", $action_name, $path);
                        $path_arr[$file_path][] = str_replace("#table_name#", $this->__table_name, $real_file_path);
                    }
                }
            }else{
                $path_arr[$type][] = str_replace("#table_name#", ucfirst($this->__table_name), $path);
            }
        }

        foreach($path_arr as $type => $val){
            foreach($val as $real_path){
                if(strpos($real_path, '#') === false){
                    $this->__file_arr[] = $real_path;
                }
            }
        }

        foreach($this->_rewrite_file as $type => $path){
            $write_file_arr[$type][] = $path;
        }

        foreach($write_file_arr as $type => $path){
            foreach($path as $real_path){
                $this->__write_file_arr[] = $real_path;
            }
        }

        var_dump($this);
        exit();
        return $this;
    }

    /**
     * 检测目录与文件是否存在
     */
    public function generateFile(){
        foreach($this->__file_arr as $dir){
            $real_dir = substr($dir, 0, strrpos($dir, '/'));
            if(strpos($real_dir, 'views') != false && strpos($real_dir, '_') !== false){
                $real_last_dir_array = [];
                $real_last_dir = substr($real_dir, strrpos($real_dir, '/') + 1);
                $real_last_dir_arr = explode('_', $real_last_dir);
                foreach($real_last_dir_arr as $k => $v){
                    $real_last_dir_array[] = $k == 0 ? $v : ucfirst($v);
                }
                $real_dir = str_replace($real_last_dir, implode('', $real_last_dir_array), $real_dir);
            }
            //当前文件所在目录已经存在，检测文件是否存在，如果存在，备份原文件，创建新文件。
            //当前文件所在目录不存在，创建目录，再创建文件
            if(!is_dir($real_dir)){
                mkdir($real_dir, 0777);
            }
            $this->__chkFile($dir);
        }
    }

    /**
     * 传入文件绝对路径，检测文件是否存在，存在则移动并创建一个新的，反之创建新文件
     * @param string $file_path
     * @return bool
     */
    private function __chkFile($file_path = ''){
        if(!empty($file_path)){
            $fh = null;
            $real_file_path = '';
            //如果生成控制器，且控制器文件名中包含下划线，则切换为驼峰
            if(strpos($file_path, '_') !== false){
                $file_name_arr = $file_name_array = [];
//                $file_name = '';
                if(strpos($file_path, 'Controllers') !== false){
                    $file_name_arr = explode('_', $file_path);
//                    $file_name = substr($file_path, strrpos($file_path, '/') + 1, (strrpos($file_path, '.') - strrpos($file_path, '/') - 1));
//                    $file_name_arr = explode('_', $file_name);
                } else if(strpos($file_path, 'views') !== false){
                    $file_name_arr = explode('_', $file_path);
                }
                foreach($file_name_arr as $k => $v){
                    $file_name_array[] = strpos($file_path, 'Controllers') !== false ? ucfirst($v) : ($k == 0 ? $v : ucfirst($v));

                }

//                $real_file_path = str_replace($file_name, implode('', $file_name_array), $file_path);
                $real_file_path = implode('', $file_name_array);

            }
            if(!empty($real_file_path)){
                if(file_exists($real_file_path)){
                    $copy_file_path = 'code_backup' . substr($real_file_path, stripos($real_file_path, '/')) . '_' . date("Y-m-d", time()) . '.php';
                    $this->__chkDir($copy_file_path);
//                    @rename($real_file_path, substr($real_file_path, 0, strrpos($real_file_path, '.')) . '_' . date("Y-m-d",  time()) . '.php');
                    @rename($real_file_path, substr($copy_file_path, 0, strrpos($copy_file_path, '.')));
                }
                $fh = fopen($real_file_path, 'wr');
            }else{
                $copy_file_path = BASEPATH . 'code_backup' . substr($file_path, stripos($file_path, '/')) . '_' . date("Y-m-d", time()) . '.php';
                $this->__chkDir($copy_file_path);
                @rename($file_path, substr($copy_file_path, 0, strrpos($copy_file_path, '.')));
//                @rename($file_path, substr($file_path, 0, strrpos($file_path, '.')) . '_' . date("Y-m-d",  time()) . '.php');
                $fh = fopen($file_path, 'wr');
            }
            if($fh){
                $code = $this->__generateCode($file_path);
                fwrite($fh, $code);
                fclose($fh);
            }
            $code = $this->__generateCode($file_path);
//            echo $code;exit;
            return true;
        }
        return false;
    }

    /**
     * 生成代码
     * @param string $file_path 要生成代码的文件的绝对路径
     * @return bool|string
     */
    private function __generateCode($file_path = ''){
        if(!empty($file_path)){
            $code = '';
            foreach($this->_code_arr as $type /*=> $element_arr*/){
                if(strpos(substr($file_path, strrpos($file_path, '/')+1, strrpos($file_path, '.php') - strrpos($file_path, '/') - 1), $type) !== false ||
                    strpos(substr($file_path, 0, strrpos($file_path, '/')+1), $type) ||
                    strpos(substr($file_path, strrpos($file_path, '/')+1), $type)){
//                if(strpos(strtolower(substr($file_path, strrpos($file_path, '/')+1)), $type )){
//                if(strpos(strtolower($file_path), $type)){
                    $generate_code_class_name = 'Generated' . ucfirst($type);
                    if(file_exists(__DIR__ . '/' . $generate_code_class_name . '.php')){
                        require_once __DIR__ . '/' . $generate_code_class_name . '.php';
                        $generate_code_function_name = 'generated' . ucfirst($type) . 'Code';
                        $generate_code_class = new $generate_code_class_name();
                        if($type == 'phtml'){
                            $code = $generate_code_class->setFileHeadNote($this->_file_head_note)->$generate_code_function_name($file_path, $this->_filter_parameter_arr);
                        }else{
                            $code = $generate_code_class->setFileHeadNote($this->_file_head_note)->$generate_code_function_name($file_path);
                        }
                    }
                }
            }
            if(strpos($file_path, 'views') !== false){
                return $code;
            }else{
                return str_replace("{*}", "#", str_replace("#", "\r\n", $code));
            }
//            return str_replace("#", "\r\n", $code);
        }
        return false;
    }

    /**
     * 重写ErrorTips与ErrorMsg
     */
    public function rewriteFile(){
        foreach($this->_rewrite_file as $dir){
            if(!file_exists($dir)){
                exit($dir . ' not exists');
            }else{
                $this->__rewriteCode($dir);
            }
        }
        return $this;
    }

    /**
     * 重写errorTips与errorMsg
     * @param string $file_path
     * @return $this
     */
    private function __rewriteCode($file_path = ''){
        if(!empty($file_path)){
            $table_name = $this->__table_name;
            foreach($this->_rewrite_file as $type => $file){
                $rewrite_code_class_name = "Rewrite" . ucfirst($type);
                if(file_exists(__DIR__ . "/" . $rewrite_code_class_name . '.php')){
                    require_once __DIR__ . "/" . $rewrite_code_class_name . '.php';
                    $rewrite_code_function_name = 'rewrite' . ucfirst($type) . 'Code';
                    $rewrite_code_class = new $rewrite_code_class_name();
                    $rewrite_code_class->$rewrite_code_function_name($file, $table_name);
                }
            }
        }
        return true;
    }

    private function __chkDir($file_path = ''){
        $file_path = !empty($file_path) && is_string($file_path) && strpos($file_path, '/') !== false ? trim($file_path) : '';
        if(!empty($file_path)){
            $file_array = explode('/', $file_path);
            $real_file_dir = '';
            foreach ($file_array as $index => $value){
                if($index + 1 < count($file_array)){
                    $real_file_dir .= $value . '/';
                    if(!is_dir($real_file_dir)){
                        mkdir($real_file_dir, 0777);
//                        chown($real_file_dir, 'momo');
                    }
                }
            }
        }

        return true;
    }
}
