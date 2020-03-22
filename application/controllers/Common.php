<?php


use Yaf\Controller_Abstract;

class CommonController extends Controller_Abstract
{

    public function testAction() {
        return $this->display('test');
    }

}