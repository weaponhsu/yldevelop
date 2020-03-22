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
 * Date: 2016-07-11
 * Time: 上午 10:43
 */

require_once __DIR__ . '/GeneratedCode.php';

class RewriteErrorTips extends GeneratedCode
{
    private $__error_tips = '';


    public function rewriteErrorTipsCode($file_path = '', $table_name = ''){
        //打开旧文件，一行一行读取出来，生成数组，并且把最后一行剔除掉，这样往数组最后加入新内容才不会报fatal error
        $old_content = $this->__getContent($file_path);
        if(empty($old_content)){
            exit($file_path . ' is empty');
        }
        $this->__error_tips = implode("", $old_content);

        //生成新的内容数组，并与旧内容合并
        $error_tips_arr = $this->_genErrorTips($old_content, $table_name);
        if(empty($error_tips_arr)){
            exit('无法获取表名称');
        }

        //无需修改ErrorTips
        if($error_tips_arr === true){
            return true;
        }
        $this->__error_tips .= implode("\r\n", $error_tips_arr);

        //写入新文件结果，写入成功true，反之false
        return $this->__setContent($file_path);
    }


    private function __getContent($file_path = ''){
        $result_arr = [];
        //文件路径不为空且文件存在
        if(!empty($file_path)){
            if(!file_exists($file_path)){
                return $result_arr;
            }
            $fh = fopen($file_path, 'r');
            $result_arr = [];
            while(!feof($fh)){
                $result = fgets($fh);
                $result_arr[] = $result;
            }
            unset($result_arr[count($result_arr)-1]);
            fclose($fh);
        }
        return $result_arr;
    }

    private function __setContent($file_path = ''){
        if(!empty($this->__error_tips) && !empty($file_path)){
            $fh = fopen($file_path, 'w');
            fwrite($fh,  $this->__error_tips . "\r\n}");
            fclose($fh);
            return true;
        }
        return false;
    }

}