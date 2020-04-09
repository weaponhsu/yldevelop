<?php

namespace models\DAO;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;
use Yaf\Registry;


/**
 * @SWG\Swagger(
 *     @SWG\Definition(
 *          type="object",
 *          definition="ruleSingleData",
 *          required={"errno", "errmsg", "data"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", type="object", ref="#/definitions/ruleSingleObj")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="ruleSingleObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/ruleSingle")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="ruleListData",
 *          required={"errno", "errmsg", "result"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", ref="#/definitions/ruleListObj"),
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="ruleListObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/ruleData"),
 *          @SWG\Property(property="meta", ref="#/definitions/meta")
 *     ),
 *     @SWG\Definition(
 *          type="array",
 *          definition="ruleData",
 *          @SWG\Items(
 *              title="data", ref="#/definitions/ruleSingle"
 *          )
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="ruleSingle",
 *          @SWG\Property(property="id", type="integer", format="int32",  description="主键"),
 *          @SWG\Property(property="name", type="string", format="string",  description="权限名称"),
 *          @SWG\Property(property="stats", type="integer", format="int32",  description="状态(0为否,1为是,默认1)"),
 *          @SWG\Property(property="created_by", type="integer", format="int32",  description="创建者"),
 *          @SWG\Property(property="created_at", type="string", format="string",  description="创建时间"),
 *          @SWG\Property(property="updated_by", type="integer", format="int32",  description="更新者"),
 *          @SWG\Property(property="updated_at", type="string", format="string",  description="更新时间"),
 *     )
 * )
 */
class RuleModel extends Model{

    protected $table = 'rule';

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
