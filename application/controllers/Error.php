<?php

use Yaf\Controller_Abstract;
use Yaf\Session;

class ErrorController extends Controller_Abstract
{
    public function errorAction($exception){
        var_dump($exception->getMessage());
    }

}