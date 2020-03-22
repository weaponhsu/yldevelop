<?php


namespace models\Exception\DAO;

use ReflectionException;

class ModelReflectionException extends ReflectionException
{
    const MODEL_REFLECTION_EXCEPTION_MSG = '类%class_name%报出ReflectionException错误: {%msg%}';
    const MODEL_REFLECTION_EXCEPTION_MSG_NO = '130001';
}
