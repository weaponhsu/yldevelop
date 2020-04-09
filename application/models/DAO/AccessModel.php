<?php

namespace models\DAO;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
use Yaf\Registry;


/**
 * @SWG\Swagger(
 *     @SWG\Definition(
 *          type="object",
 *          definition="accessSingleData",
 *          required={"errno", "errmsg", "data"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", type="object", ref="#/definitions/accessSingleObj")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="accessSingleObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/accessSingle")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="accessListData",
 *          required={"errno", "errmsg", "result"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", ref="#/definitions/accessListObj"),
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="accessListObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/accessData"),
 *          @SWG\Property(property="meta", ref="#/definitions/meta")
 *     ),
 *     @SWG\Definition(
 *          type="array",
 *          definition="accessData",
 *          @SWG\Items(
 *              title="data", ref="#/definitions/accessSingle"
 *          )
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="accessSingle",
 *          @SWG\Property(property="id", type="integer", format="int32",  description="主键"),
 *          @SWG\Property(property="rule_id", type="integer", format="int32",  description="角色"),
 *          @SWG\Property(property="menu_id", type="integer", format="int32",  description="菜单"),
 *     )
 * )
 */
class AccessModel extends Model{

    protected $table = 'access';

    public $timestamps = false;

    /**
     * 注册事件
     */
    static public function boot() {
        parent::boot();

        static::created(function ($model) {
            // 日志记录
            Registry::get('db_log')->info(get_class($model) . ' - created - ' . json_encode(Capsule::connection()->getQueryLog()[0]));
        });

        static::updated(function ($model) {
            // 日志记录
            Registry::get('db_log')->info(get_class($model) . ' - updated - ' . json_encode(Capsule::connection()->getQueryLog()[0]));
        });

        static::deleted(function ($model) {
            // 日志记录
            Registry::get('db_log')->info(get_class($model) . ' - deleted - ' . json_encode(Capsule::connection()->getQueryLog()[0]));
        });
    }

}
