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
 * Time: 下午 4:59
 */

require_once __DIR__ . '/GeneratedCode.php';

class GeneratedDao extends GeneratedCode
{
    protected $_code_arr = [
        'start' => '<?php',
        'namespace' => 'models\\DAO',
        'use' => null,
//        'class' => 'class #class_name# extends base{',
        'class' => 'class #class_name#Model extends base{',
//        'construct' => 'parent::__construct(substr(get_class($this), strrpos(get_class($this), "\\\\")+1))',
        'construct' => 'parent::__construct(str_replace("Model", "", substr(get_class($this), strrpos(get_class($this), "\\\\")+1)))',
        'end' => '}'
    ];

    public function generatedDaoCode($file_path = ''){
        $code = '';
        if(!empty($this->_code_arr) && !empty($file_path)){
            foreach($this->_code_arr as $key => $element){
                switch ($key){
                    case 'start':
                        $code .= $this->genStartCode($element);
//                        $code .= $element . "\r\n" . str_replace(['#date#', '#time#'], [date("Y-m-d", time()), date("H:i:s", time())], $this->_file_head_note) . "\r\n";
                        break;
                    case 'namespace':
                        $code .= $this->genNamespaceCode($element);
//                        $code .= 'namespace ' . $element . ";\r\n\r\n";
                        break;
                    case 'use':
                        $code .= $this->genUseCode($element);
                        /*if($element !== null){
                            if(is_array($element)){
                                foreach($element as $use_file_namespace){
                                    $code .= 'use ' . $use_file_namespace . ";\r\n";
                                }
                                $code .= "\r\n";
                            }else{
                                $code .= 'use ' . $element . "; \r\n";
                            }
                        }*/
                        break;
                    case 'class':
                        $code .= $this->genClass($element, $file_path);
//                        $code .= "\r\n" . str_replace('#class_name#', substr($file_path, strrpos($file_path, '\\')+1, (strrpos($file_path, '.') - 1 - strrpos($file_path, '\\'))), $element) . "\r\n";
                        break;
                    case 'construct':
                        $code .= $this->genConstruct($element);
//                        $code .= $this->genConstruct($element, ['parameter1' => ['', 'string', '参数1'], 'parameter2' => ['', 'string', '参数']]);
//                        var_dump($code);
//                        exit;
//                        $code .= "      public function __construct(){\r\n            " . $element . "; " . "\r\n" . "      }\r\n";
                        break;
                    default:
                        $code .= $element . "\r\n";
                        break;
                }
            }
        }

        return $code;
    }

}