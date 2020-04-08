<?php


namespace models\DAO;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Swagger(
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleSingleData",
 *          required={"errno", "errmsg", "data"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", type="object", ref="#/definitions/roleSingleObj")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleSingleObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/roleSingle")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleListData",
 *          required={"errno", "errmsg", "result"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", ref="#/definitions/roleListObj"),
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleListObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/roleData"),
 *          @SWG\Property(property="meta", ref="#/definitions/meta")
 *     ),
 *     @SWG\Definition(
 *          type="array",
 *          definition="roleData",
 *          @SWG\Items(
 *              title="data", ref="#/definitions/roleSingle"
 *          )
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="roleSingle",
 *          @SWG\Property(property="id", type="integer", format="int32",  description="主键"),
 *          @SWG\Property(property="name", type="string", format="string",  description="角色"),
 *          @SWG\Property(property="created_at", type="string", format="string",  description="创建时间"),
 *          @SWG\Property(property="created_by", type="integer", format="int32",  description="创建人"),
 *          @SWG\Property(property="updated_at", type="string", format="string",  description="最后一次修改时间"),
 *          @SWG\Property(property="updated_by", type="integer", format="int32",  description="最后一次修改人"),
 *     )
 * )
 */
class RoleModel extends Model
{
    protected $table = 'role';

    public $timestamp = false;

    protected $perPage = 10;

}
