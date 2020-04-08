<?php


namespace models\DAO;


use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Swagger(
 *     @SWG\Definition(
 *          type="object",
 *          definition="authoritySingleData",
 *          required={"errno", "errmsg", "data"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", type="object", ref="#/definitions/authoritySingleObj")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="authoritySingleObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/authoritySingle")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="authorityListData",
 *          required={"errno", "errmsg", "result"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", ref="#/definitions/authorityListObj"),
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="authorityListObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/authorityData"),
 *          @SWG\Property(property="meta", ref="#/definitions/meta")
 *     ),
 *     @SWG\Definition(
 *          type="array",
 *          definition="authorityData",
 *          @SWG\Items(
 *              title="data", ref="#/definitions/authoritySingle"
 *          )
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="authoritySingle",
 *          @SWG\Property(property="id", type="integer", format="int32",  description="主键"),
 *          @SWG\Property(property="rule_id", type="integer", format="int32",  description="权限"),
 *          @SWG\Property(property="role_id", type="integer", format="int32",  description="角色"),
 *     )
 * )
 */
class AuthorityModel extends Model
{
    protected $table = 'authority';

    public $timestamps = false;

}
