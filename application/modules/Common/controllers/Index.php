<?php

use Hashids\Hashids;
use youliPhpLib\Common\PwdAss;
use youliPhpLib\Common\RsaOperation;
use youliPhpLib\Common\StringOperation;
use Yaf\Registry;
use models\Exception\DAO\ModelSqlException;
use models\Exception\DAO\ModelDriverException;
use models\Exception\DAO\ModelException;
use models\Exception\DAO\ModelReflectionException;
use models\Exception\Service\ServiceException;
use models\Exception\Transformer\TransformerException;

/**
 * Class CommonController
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="www.yldevelop.com",
 *   basePath="/",
 *   info={
 *     "title"="代付系统",
 *     "version"="1.0.0",
 *     "description" = "接口测试接口与文档"
 *   },
 *     @SWG\Definition(
 *          type="object",
 *          definition="links",
 *          required={"next_page", "prev_page"},
 *          @SWG\Property(property="next_page", type="integer", format="int32", description="下一页页码"),
 *          @SWG\Property(property="prev_page", type="integer", format="int32", description="上一页页码")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="meta",
 *          required={"total", "per_page", "total_pages", "current_page", "count"},
 *          @SWG\Property(property="total", type="integer", format="int32", description="总条目"),
 *          @SWG\Property(property="per_page", type="integer", format="int32", description="每页显示条目"),
 *          @SWG\Property(property="total_pages", type="integer", format="int32", description="总页数"),
 *          @SWG\Property(property="current_page", type="integer", format="int32", description="当前页"),
 *          @SWG\Property(property="count", type="integer", format="int32", description="当前也总条目"),
 *          @SWG\Property(property="links", type="object", ref="#/definitions/links", description="上一页下一页对象")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="unauthorized",
 *          required={"errno", "errmsg", "result"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="错误编号"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误信息提示"),
 *          @SWG\Property(property="result", type="object", description="空对象")
 *     )
 * )
 */
class IndexController extends ApiBaseController
{
    public function indexAction() {
        echo __METHOD__;
    }
}
