<?php

namespace ErrorMsg\Admin;


use ErrorMsg\AbstractErrorMsg;

class ClassErrMsg extends AbstractErrorMsg
{
    const CLASSIFICATION_PARAMETERS_INVALID = '无效参数';
    const CLASSIFICATION_PARAMETERS_INVALID_NO = '400';

    const CLASSIFICATION_CREATE_FAILURE = '文章分类创建失败';
    const CLASSIFICATION_CREATE_FAILURE_NO = '422';

    const CLASSIFICATION_EDIT_FAILURE = '文章分类编辑失败';
    const CLASSIFICATION_EDIT_FAILURE_NO = '422';

    const CLASSIFICATION_INVALID_OPERATION = '无权编辑文章分类';
    const CLASSIFICATION_INVALID_OPERATION_NO = '422';

    const CLASSIFICATION_NOT_EXISTS = '文章分类不存在';
    const CLASSIFICATION_NOT_EXISTS_NO = '404';

    const CLASSIFICATION_IS_DELETED = '文章分类已被删除';
    const CLASSIFICATION_IS_DELETED_NO = '404';

}