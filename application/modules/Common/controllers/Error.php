<?php

use \Doctrine\DBAL\Exception;
use Exception as Except;

class ErrorController extends ApiBaseController
{
    public function errorAction(\Exception $exception) {

        $err_no = $exception->getCode();
        $err_msg = $exception->getMessage();
        $result = new stdClass();

        var_dump($exception->getFile());

        var_dump(get_class($exception));
        var_dump($exception->getCode());
        echo $exception->getMessage() . "。<位置: {" . str_replace(APP_PATH, "", $exception->getFile()) . "-{$exception->getLine()}}>";
        \Yaf\Registry::get('db_log')->err($exception->getMessage() . 'file: ' . $exception->getFile() . ', line: ' . $exception->getLine());
        exit();

        if ($exception instanceof Exception\UniqueConstraintViolationException)
            $err_no = '422';

        switch ($err_no) {
            case '400':
                header('HTTP/1.1 400 INVALID REQUEST', true, $err_no);
                break;
            case '403':
                header('HTTP/1.1 403 Forbidden', true, 401);
                break;
            case '404':
                header('HTTP/1.1 404 NOT FOUND', true, $err_no);
                break;
            case '422':
                header('HTTP/1.1 422 Unprocesable entity', true, $err_no);
                break;
            case '410':
                header('HTTP/1.1 410 Gone', true, $err_no);
                break;
            default:
                header('HTTP/1.1 401 Unauthorized', true, 401);
                break;
        }

        return $this->_responseJson($result, $err_no, $err_msg);
    }

}
