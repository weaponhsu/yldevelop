<?php


namespace models\Exception\Transformer;

use Exception;

class TransformerException extends Exception
{

    const INSTANCE_IS_INVALID = "不是个Model类";
    const INSTANCE_IS_INVALID_NO = "400003";

}
