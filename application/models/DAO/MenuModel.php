<?php


namespace models\DAO;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Swagger(
 *     @SWG\Definition(
 *          type="object",
 *          definition="menuSingleData",
 *          required={"errno", "errmsg", "data"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", type="object", ref="#/definitions/menuSingleObj")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="menuSingleObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/menuSingle")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="menuListData",
 *          required={"errno", "errmsg", "result"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", ref="#/definitions/menuListObj"),
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="menuListObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/menuData"),
 *          @SWG\Property(property="meta", ref="#/definitions/meta")
 *     ),
 *     @SWG\Definition(
 *          type="array",
 *          definition="menuData",
 *          @SWG\Items(
 *              title="data", ref="#/definitions/menuSingle"
 *          )
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="menuSingle",
 *          @SWG\Property(property="id", type="integer", format="int32",  description="主键"),
 *          @SWG\Property(property="name", type="string", format="string",  description="显示名"),
 *          @SWG\Property(property="parent", type="integer", format="int32",  description="上级"),
 *          @SWG\Property(property="path", type="string", format="string",  description="层级关系"),
 *          @SWG\Property(property="url", type="string", format="string",  description="特殊URL"),
 *          @SWG\Property(property="display", type="integer", format="int32",  description="是否显示到左侧菜单(0为否,1为是,默认0)"),
 *          @SWG\Property(property="is_operation", type="integer", format="int32",  description="是否是操作(0为否,1为是,默认0)"),
 *          @SWG\Property(property="list_order", type="integer", format="int32",  description="排序"),
 *          @SWG\Property(property="created_at", type="string", format="string",  description="创建时间"),
 *          @SWG\Property(property="created_by", type="integer", format="int32",  description="创建人"),
 *          @SWG\Property(property="updated_at", type="string", format="string",  description="最近一次编辑时间"),
 *          @SWG\Property(property="updated_by", type="integer", format="int32",  description="最后一次编辑人"),
 *     )
 * )
 */
class MenuModel extends Model
{
    protected $table = 'menu';

}
