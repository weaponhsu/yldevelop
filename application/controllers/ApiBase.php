<?php



use Yaf\Controller_Abstract;
use Yaf\Registry;
use ErrorMsg\Api\ErrorMsg;

class ApiBaseController extends Controller_Abstract
{
    protected $_foreign_relationship_result;

    protected function _verify($method_name = '', $action_name = ''){
        //解密失败
        if(empty(Registry::get("parameters"))){
            return ErrorMsg::SECRET_IS_NULL;
        }

        //接口controller参数为空
        if(empty($method_name)){
            return ErrorMsg::INVALID_METHOD_NAME;
        }

        //接口action参数为空
        if(empty($action_name)){
            return ErrorMsg::INVALID_ACTION_NAME;
        }

        //获取当前接口的可接受参数，并生成数组
        $parameter_str = Registry::get("config")['api'][substr($method_name, 0, strrpos($method_name, 'controller'))][substr($action_name, 0, strrpos($action_name, 'action'))];
        if(!$parameter_str){
            return ErrorMsg::API_PARAMETERS_DOES_NOT_CONFIGURATION;
        }
        $parameters_arr = explode(',', $parameter_str);

        //遍历本次调用接口的参数是否为配置的可接受参数
//        exit(json_encode([$parameters_arr, Registry::get("parameters")]));
        foreach($parameters_arr as $key => $value){
            if(!isset(Registry::get("parameters")[trim(strtolower($value))])){
                return str_replace('%s', $value, ErrorMsg::INVALID_PARAMETER);
            }
        }

        return true;
    }

    /**
     * 返回字符串 默认error
     * @param string $string
     * @return bool
     */
    protected function _responseString($string = 'error') {
        return $this->getResponse()->setBody($string);
    }

    /**
     * 返回json字符串
     * @param null $array 要返回的数据
     * @param string $errno
     * @param string $errmsg
     * @return bool
     */
    protected function _responseJson($array = null, $errno = '000', $errmsg = ''){
        $return_result = [
            'errno' => $errno,
            'errmsg' => $errmsg,
            'result' => $array == null ? new stdClass() : $array
        ];

        if($this->getRequest()->isCli() === false){
            header("Content-Type: application/json; charset=UTF-8");
        }

        $from_file = debug_backtrace()[0]['file'];
        if (strpos($from_file, 'Error.php') === false) {
            switch ($this->getRequest()->getMethod()) {
                case 'POST':
                    /*// 批量删除
                    if (strpos(debug_backtrace()[1]['function'], 'batchDelete') !== false)
                        header('HTTP/1.1 204 NO CONTENT', true, 204);
                    // 创建
                    else*/
                        header('HTTP/1.1 201 CREATED', true, 201);
                    break;
                case 'PUT':
                    header('HTTP/1.1 200 OK', true, 201);
                    break;
//                case 'DELETE':
//                    header("HTTP/1.1 204 OK", true, 204);
//                    break;
                default:
                    header('HTTP/1.1 200 OK', true, 200);
                    break;
            }
        }

        return $this->getResponse()->setBody(
            ! isset(Registry::get("parameters")['callback']) ? json_encode($return_result) :
                Registry::get("parameters")['callback'] . '(' . json_encode($return_result) . ')'
        );
    }

    /**根据fetchAll返回的数据进行分页处理
     * @param $total_result
     * @param $page
     * @param $page_size
     * @return array
     */
    public function getMeta($total_result, $page, $page_size) {
        $total = $total_result;
        if ($page !== 0 && $page_size !== 0) {
            $current_page = intval($page);
            $per_page = intval($page_size);
            $total_pages = intval(ceil($total_result / $page_size));
            $count = $total_pages <= 1 ? $total_result : (
            $total_pages != $current_page ? $per_page :
                $total_result - (($current_page - 1) * $per_page)
            );
        } else {
            $current_page = 0;
            $per_page = 0;
            $total_pages = 0;
            $count = 0;
        }
        $links = new \stdClass();
        if ($total_pages !== 0)
            if ($total_pages > $current_page + 1)
                $links->next_page = $current_page + 1;
        if ($page > 1 && $total_pages > 1)
            $links->last_page = $current_page - 1;
        $meta = ['total' => $total, 'per_page' => $per_page, 'total_pages' => $total_pages, 'count' => $count, 'current_page' => $current_page, 'links' => $links];
        return $meta;
    }
}
