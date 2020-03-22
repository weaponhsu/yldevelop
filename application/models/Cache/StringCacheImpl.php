<?php

namespace models\Cache;


interface StringCacheImpl
{
    public function genString($key='', $value='', $expire = 86400);
    public function getString($key = '');
    public function updateString($key = '', $value = '', $expire = 86400);
    public function deleteString($key = '');
    public function setExpire($key, $expire = 86400);
}