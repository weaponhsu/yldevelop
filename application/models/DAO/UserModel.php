<?php


namespace models\DAO;


use Illuminate\Database\Eloquent\Model;
use models\Exception\DAO\ModelSqlException;
use Yaf\Registry;
/**
 * @SWG\Swagger(
 *     @SWG\Definition(
 *          type="object",
 *          definition="userSingleData",
 *          required={"errno", "errmsg", "data"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", type="object", ref="#/definitions/userSingleObj")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="userSingleObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/userSingle")
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="userListData",
 *          required={"errno", "errmsg", "result"},
 *          @SWG\Property(property="errno", type="integer", format="int32", description="编码"),
 *          @SWG\Property(property="errmsg", type="string", format="string", description="错误提示信息"),
 *          @SWG\Property(property="result", ref="#/definitions/userListObj"),
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="userListObj",
 *          @SWG\Property(property="data", type="object", ref="#/definitions/userData"),
 *          @SWG\Property(property="meta", ref="#/definitions/meta")
 *     ),
 *     @SWG\Definition(
 *          type="array",
 *          definition="userData",
 *          @SWG\Items(
 *              title="data", ref="#/definitions/userSingle"
 *          )
 *     ),
 *     @SWG\Definition(
 *          type="object",
 *          definition="userSingle",
 *          @SWG\Property(property="id", type="integer", format="int32",  description="主键"),
 *          @SWG\Property(property="username", type="string", format="string",  description="登录名"),
 *          @SWG\Property(property="password", type="string", format="string",  description="密码"),
 *          @SWG\Property(property="google_secret", type="string", format="string",  description="谷歌认证器"),
 *          @SWG\Property(property="role", type="integer", format="int32",  description="角色"),
 *          @SWG\Property(property="mobile", type="string", format="string",  description="手机号码"),
 *          @SWG\Property(property="stats", type="integer", format="int32",  description="状态(0为封禁,1为允许登录,默认0)"),
 *          @SWG\Property(property="uuid", type="string", format="string",  description="uuid"),
 *          @SWG\Property(property="last_login_time", type="string", format="string",  description="上次登录时间"),
 *          @SWG\Property(property="login_times", type="integer", format="int32",  description="登录次数"),
 *          @SWG\Property(property="created_at", type="string", format="string",  description="创建时间"),
 *          @SWG\Property(property="created_by", type="integer", format="int32",  description="创建人"),
 *          @SWG\Property(property="updated_at", type="string", format="string",  description="最后一次修改时间"),
 *          @SWG\Property(property="updated_by", type="integer", format="int32",  description="最后一次修改人"),
 *     )
 * )
 */
class UserModel extends Model
{
    protected $table = 'user';

}
