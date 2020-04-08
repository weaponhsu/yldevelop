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
 *     "title"="论坛",
 *     "version"="1.0.0",
 *     "description" = "接口测试接口与文档",
 *     "contact":
 *     {
 *          "email":"huangxu4328@gmail.com"
 *     },
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
        $user_model = new \models\DAO\UserModel();
//        exit();
//        $user_model->all()->toArray();
//        $sql = $user_model::query('select password from user where id = ?', [66]);
//        var_dump($sql->get()->toArray());

        $user = \models\Business\User::login('13333333333', 'Aa123456');

        return $this->_responseJson($user);
        echo 'adf';exit();

        // 1688 获取商品分类测试
        // 97 => 1043171 => 1043183
//        $category_list = \models\Business\Alibaba::getCategory(97);
//        var_dump($category_list);
//        $res = \models\Service\AlibabacategoryService::getInstance()->batchInsert($category_list);
//        var_dump($res);

//        $category_list = \models\Business\Alibaba::getSubCategoryById(1043183);
//        var_dump($category_list);

        $category_info = \models\Business\Alibaba::getCategoryFrom1688Api(1043435);
        var_dump($category_info);
        exit();

//        $res = \models\Business\Location::getLocation();
        $res = \models\Business\Location::getLocation('', 1, 2);
        var_dump($res);
//        $res = \models\Business\Location::getLocation('350000000000', 2);
//        var_dump($res);
//        $res = \models\Business\Location::getLocation('350200000000', 3);
//        var_dump($res);
//        $res = \models\Business\Location::getLocation('350205000000', 4);
//        var_dump($res);
        exit();

        $res = \models\Business\PicCode::genPicCode('13779957421', 'register');
        var_dump($res);

        try {
//            $role_list = \models\Service\RoleService::getInstance()->getList(1, 20, 'desc', 'id', []);
            $role_list = \models\Service\RoleService::getInstance()->getList(1, 1, 'desc', 'id', [
                'groupOp' => 'AND', 'rules' => [
                    ['field' => 'id', 'op' => 'ge', 'data' => 1]
                ]
            ]);
            var_dump($role_list);
        } catch (ModelDriverException $e) {
        } catch (ModelException $e) {
        } catch (ModelReflectionException $e) {
        } catch (ModelSqlException $e) {
        } catch (ServiceException $e) {
        } catch (TransformerException $e) {
        }

        exit();

        $user_list = $this->login('13333333333', 'Aa123456');

//        $user_model = \models\DAO\UserModel::getInstance();
//        $sql = "SELECT u.`mobile`, u.`role`, r.`name` FROM `user` AS u LEFT JOIN `role` AS r ON u.`role` = r.`id` WHERE u.`mobile` = '13333333333'";
//        $user_list = $user_model->query($sql);

        try {
            /*$user_list = $this->getUserList(
                ['mobile' => '13333', 'stats' => 1]
            );
            var_dump($user_list);*/

            /*$user_list = \models\Service\UserService::getInstance()->getList(1, 2, 'desc', 'id',
                ['groupOp' => 'AND', 'rules' => [
                    ['field' => 'username', 'op' => 'in', 'data' => '13333333333, 13333333334']
                ]]);
            var_dump($user_list);
            exit();*/

            /*$mobile = '13333333339';
            $password = 'Aa123456';
            $hash_id = new Hashids('youli', 16, 'abcdefghijklmnopqrstuvwxyz01234569');
            $uuid = $hash_id->encode($mobile);
            $user_create_res = \models\Service\UserService::getInstance()->create($mobile, $password, '', 1, $mobile,
                0, $uuid, 0, 1, 1, true);
            var_dump($user_create_res);*/

            /*$user_update_res = \models\Service\UserService::getInstance()->update(['role' => 1, 'stats' => 1], $user_create_res['id'], true, $user_create_res['id']);
            var_dump($user_update_res);*/

            /*$user_delete_res = \models\Service\UserService::getInstance()->delete($user_create_res['id'], true, $user_create_res['id']);
            var_dump($user_delete_res);*/


            /*$user_list = $this->getUserList(
                ['mobile' => '13111', 'stats' => 0]
            );
            var_dump($user_list);*/

            /*$user_list = \models\Service\UserService::getInstance()->getOne(76, true, 76);
            var_dump($user_list);*/

            /*$hash_id = new Hashids('youli', 16, 'abcdefghijklmnopqrstuvwxyz01234569');
            $user_list = \models\Service\UserService::getInstance()->batchInsert(
                [
                    ['mobile' => '13111111111', 'username' => '13111111111', 'password' => 'Aa123456', 'uuid' => $hash_id->encode('13111111111')],
                    ['mobile' => '13111111112', 'username' => '13111111112', 'password' => 'Aa123456', 'uuid' => $hash_id->encode('13111111112')]
                ], true
            );
            var_dump($user_list);*/

            if('*' === $pwd = PwdAss::getInstance(8, true)->HashPassword('123'))
                throw new Exception('密码生成失败', 400);

            /*$user_list = \models\Service\UserService::getInstance()->batchUpdate([
                ['id' => 167, 'mobile' => '13111111113', 'stats' => 1],
                ['id' => 168, 'mobile' => '13111111114', 'stats' => 0]
            ], true);*/

            /*$user_list = \models\Service\UserService::getInstance()->batchDelete([167, 168], true);
            var_dump($user_list);*/
            var_dump($user_list);

        } catch (ServiceException $e) {
            throw $e;
        } catch (ModelReflectionException $e) {
            throw $e;
        } catch (ModelDriverException $e) {
            throw $e;
        } catch (ModelException $e) {
            throw $e;
        } catch (ModelSqlException $e) {
            throw $e;
        } catch (TransformerException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
        exit();

//        return $this->_responseJson($user_list, 000);
//        $str = '{
//            "data": "C\/lE32P\/w7NBdcTyy1Y3LJ43\/cKs8SGurq71zigvBAXp5gvvFRJeFcEsY8puFLRT3VUmY+ke\/4Pw\/UUA4GrMShG1WTLZWiVCz7g8dK6PN2hX\/YJ7myRWiexlh5o8VquT",
//            "encrypt_str": "bRwn5vpROwvfRy+pqf3wGTjP5yUT6CWTScP\/1\/Cwc1kZbBE75xuvAlYHKm4BG0kWIGLdUxJvxXyNyZ0RVPcmhZmb3V3s5V2Y5PgZGZeMeguto8W0EOFBCdVURkVS8N+kjoPwxk2SC1RAl6BoiO9gf93FxpXWkmdSeWY6zJZQz3GMGSAYUXvR\/D3vnlb57PXHfYHJzqIDcIqICtaGQwPQF9r1np986PfmrjyNfSPNK3edsudfxHIv9OZdWQ5dQELYYMN\/QXyqfKm8W\/aMNX4RxcAjwweUCdngP7Pm8XzhOYOM8QQYGoy7AjCtoG3rV2ZVP9oWSgcg6Z9bsCdw2UCdMBgUO\/qblixZga4H2Ljb2CCV9xt\/p+Yex68bZHzZZDSvD9kUkAFvyqF+TkHjobiMJ1Yn+sSWmwvigXlchE2eFnntUwkDXOOjGKFU++b1RFkDZEEY1VbuECfb4V\/M2NbQJY07x9lAnHIjCiZ+wd18695MhOOp0ICh+IslxM1Trufp82wR3B+bVjnKb93SuVGex3PEEzhdg4S5wFaE9S7R5vJcLJhfv32CMcehRolZBBHykhilsr+7XSfRClOGdnLsK3eo213T9g3aDAnJigP5Vk56xax632RLgs9PxG6QT8PCFeIcHf2KqHOMegXDFjRD40cZxPIvC1sfpXzElKef\/lA=",
//            "sign": "YdOl81rN3EpUq9NnF\/HXs0tBB6IR8n3RTdhoKacPQ5ixgf0jmwdnhOfVdbSaqN0gDbEMM8uaGZKT5Bhb2Di0tbtQIcESOWaJhwmDVvTV\/Ticq5wwYsN+wbECxWGcDkufyxSKEZc13tEUx6rpxFDHiaKtGHD4ToEI8M7dLl+\/nJoDeTxXXQBWP+au5ArAmcAoWrdczIqVCao7MOp5YI+oq1IZrUKWuuiLDy26lvyE0tBBzLPgHt5cPJdE\/imx+QcDno63JWYBWn1kbnAy7+\/tEvRRct78k8h9N52Y1YwrGulkUKA3UoLggjWOg\/uANivdp5wBZpWoYX\/M+egDarDJ0YqjkIsfBSairUzfaL149ftICIW5UyhiZoI+JhTEj3FW\/Ca\/pnHin\/afP5qUvsxPu2T4rgHvWrJtSS\/OuJ7Riy24uGi+JIMMyUhtTut9+knxmwTvZn\/R6xfulCkZXuNXMjJdJWTrNi9Ozw0yC+v8mofO2wcsXxA6fU6+45eGFvO7Q8mEAz6JTLPIbfXO3jDOXIDQ5rAw3Sf+8IFzoANkG3A+vSD+Nw6Qv31tmq+F8PgAZCvu0042caZgVaEuhJ+QF10Y7e5chJqM\/S5VTfOlR+y2OzJypC+vZKD+qnnkdPxhms0E2fa25Uuwi6mEgyLQyYjjjJldwIpU4EpR1lM99mA="
//        }';
//        $data = json_decode($str, true);
//
//        $sign = $data['sign'];
//        $data = [
//            'data' => $data['data'],
//            'encrypt_str' => $data['encrypt_str']
//        ];
//        ksort($data);
//        var_dump($data);
//        var_dump($sign);
//
        $response = 'success';
        Registry::get('notify_log')->debug('模拟商户收到异步回调:' . json_encode(Registry::get('parameters')) . '; 商户返回{' . $response . '}');
        // 解密参数
        $rsa = RsaOperation::getInstance(Registry::get('config')['rsa']['public_pem'], Registry::get('config')['rsa']['private_pem']);

//        var_dump($rsa->publicDecrypt($data['encrypt_str']));

        $sign = Registry::get('parameters')['sign'];
        $data = [
            'encrypt_str' => Registry::get('parameters')['encrypt_str'],
            'data' => Registry::get('parameters')['data']
        ];
        ksort($data);

        Registry::get('notify_log')->debug('data:' . json_encode($data) . '; sign{' . $sign . '}');

        list($key, $iv) = explode('-', $rsa->publicDecrypt($data['encrypt_str']));
//        var_dump(urldecode(http_build_query($data)));
//        var_dump($sign);
//        var_dump($rsa->verify($sign, urldecode(http_build_query($data))));
//        exit();

        if ($rsa->verify($sign, urldecode(http_build_query($data))) === false)
            throw new Exception('222', 400);

        list($key, $iv) = explode('-', $rsa->publicDecrypt($data['encrypt_str']));
        Registry::get('notify_log')->debug('模拟商户收到异步回调:' . $key . '-' . $iv);
        $data = \Common\AesUtil::getInstance($key, $iv)->decrypt($data['data']);
        $response = 'error';
        Registry::get('notify_log')->debug('模拟商户收到异步回调:' . $data . ', 返回结果: {' . $response . '}');
        return $this->_responseString($response);

        // 密码
        $pwd_ass = PwdAss::getInstance(6, true);
        $pwd = 'aa123456';
        $new_pwd = $pwd_ass->HashPassword($pwd);
//        var_dump($new_pwd);
        $res = $pwd_ass->CheckPassword($pwd, $new_pwd);
//        var_dump($res);
//        echo __METHOD__;

        $mobile = '12312312312';
        $r = StringOperation::mobileIsValid($mobile);

    }

    public function genAccountAction() {
        if ($this->getRequest()->isCli() === false)
            throw new \Yaf\Exception('无效请求');

        $res = \models\Business\Account::setValidAccountToRedis();
        print_r($res);
    }

    public function genStoresAction() {
        if ($this->getRequest()->isCli() === false)
            throw new \Yaf\Exception('无效请求');

        $goods_info = \models\Business\Goods::setAllValidGoodsToRedis();
        print_r($goods_info);
    }

    /**
     * 对指定订单进行订单状态查询
     * @throws \Yaf\Exception
     */
    public function queryOrderStatsAction() {
        $parameters = Registry::get('parameters');
        Pdd::createNotify($parameters['id'], true);
    }

    /**
     * 对指定订单进行收货确认
     * @throws \Yaf\Exception
     */
    public function confirmOrderAction() {
        $day = random_int(2, 5);
        $delay = 86400 * $day;
        $parameters = Registry::get('parameters');
        Pdd::confirmOrder($parameters['id'], $delay);
    }

    public function testAction() {
        exit('done');

        $sign = "Nm8yiTaWISr08j5zEA7fS7as6uicFt0e0Y4PLxJu9zFQuIN1hvz43/mBDL8b4UFCqm7ixQSGQe2G7xusd3jiFcK/ddrwOi6fZ7x12/A9Aiz56Osf0Fx8fI5Uzag9URM4hV1a4hWdtxMTRDloUSH8m5Gqw2noOI9zP1yj2I6Mdc1mvuHEu+sxdgyeU3/CUk3kWAGegIt2m1nyrAK4myXrWbJhC1q1DKW50T+f23jWL+RKHK1zkpx9UWW/VI4kpVC2vmc/2aOThWqOX6mlK7PgG7l/w54qODiGiMdlV9/XFSlGYjoAmcnPXR8BOZqdlt6VkTKTs0GfUm1PnK2sod6hl/9MuVK3j8FqWnGXKjBvREXY+7cHg1c6XM3tMryajzz7JenVpwgP39KRJMg5rbOXMxkxB0gaWacJxBST4r4DmJMFXNMn51V9NPVMwDNoPZvoxdMtKMuqX2M6NwYt8Nv+Tqc5osVpskZ/P/jcK5QVm4JNJYa8qM8CID9Qwb3BZyLA27DgTeWszj4mNRETOdcJUd3chi4+l4X3BdyWFy1c3Uawz6m0k6M4Y7V03d+LmXAsxhPsHusPHWXC4a+OSDQwFTwSzYJfzqpX9SDSNW9P9v/hetdWGwzP6YdvCM7CXaNuiUqgnY5xR717gV0rHxeAyn7sMLoEuB+Zt3i8nxRkyEA=";
        $sign = "M83v03E0c27txaaY4VsRL3X1eRehf4qLYth6YjWP6JqFKs3em5IZzTzYOPcHoj6VIOLaz1nGUQrwyejdvFcTwOYNuKAyjwlsFQfxIQ2PYgb2T1VjwoDq+ZoGb58VdVsb0lwK83/hKO4W9JaK0NdPLrpiOsW9hz9kwjuHAFUNY70ybzTCsFOE/PDi03YVWZPgwz+8Ylx+C38FxSgTB1i7Zq6XtSSJuGo/yqWo2Wcd/mzByQSK3XQtl/V0OoK5ZF3B0Bz/3wE5DDHUbGzGTGcnB9zAwEdxco6gKXy1TxZvaftIBYDS783PJtZIb3h6Y3zsotYkf+TnNTnP5+XBuDe2SScPSvxGFW+9VnKpRGIIRX5qgVrg7kn7avM0mLlZbUvu3G7QE2yQGzCXIcMXr+h+Xwc73dYxaJpxWKjnTLOENvtJUO72WO5AxKLYzvyqdzx4VwFC3AkLsmbPFW0zV8evNxhPsYPacAFaudZWeQZcqDnRlkfW2n3HOxBfcigDW+EDbRPMAV5qd5pF4xcDaFuSIEsBO/MjkbtW4JB3tmeZIfB6Gb6UhEEbZHleyuZkW2M/76LtAZU3g4JaezzgYrrwxJLz3Sx/CAMTmBSifZYXX4OK+qsZb9Ql6YcaWmT8Q1yei2UFUrh1Q0gQ6KjAK/OezyfSMnLL5HR8lSH6peCO9Zs=";

        $data = [
            'data' => "7s0lnMCnISsmiiIxK+ygbw==",
            'encrypt_str' => "fGDJg+LQKnYmKl4K0THulZAYU+OfMxmn1L/UKvSeQO91IuI1LtaXVpJ+JH/AEGk01pT77tvgx1UrA0oC6LyHZH2WGZNq5itereKg14Lzk5ZxpPNG4SBekY0tQYVUtZgXIsVJEPa31wRx2uUltB3sVzmzuxz9X164aotQkGC0wrjQfafnuXYc+1wKlQONUhVdHCOU9OQOqAgoX0cPtqKMZln9dkpWvJEIq5QE9CGdDhudH78GYH2T2qLLEi4kX96wyCQ0kJm28Pl9Df2JWJLsw1H0nqIprpAF72m0aHkk6HsVuxNxF1aIWSUpJTHxi0MZDvZHK1cJTqhY9ZGUt/NINpoDG/EtbT6ABj446rliFZKrNTe85L+fAjb78SrJ2bl49/EmM8s4p+6FxM2M5dJtGqQNeriExiyplLO9zObYcPh+iiNAO4oVMC/kZq6E7IhcOL4XpkYGYkPrvq3jg5H+/rczRypBPk6NVeAy514YTszbjo65feDuNNy11rhk0zz5chm/8O4uZqKh+DgV768NXHdFKvk5ASVNWl52Zrueiuhs6Pr76opHefd8gwBGsbbc4oPImk+ofF3XggNvIz/9/UxujbdSbRu6U9OvSeLO7CGzwlq588w+33YFglYumo6uY/7HKOpLBm94s/GIvA/Gl3+RkXpmuSZapvZSmwxqSp4="
        ];
        ksort($data);

        $rsa = \youliPhpLib\Common\RsaOperation::getInstance(Registry::get('config')['rsa']['public_pem'], Registry::get('config')['rsa']['private_pem']);
        $sign = $rsa->sign($data);
        var_dump($sign);
        var_dump(urldecode(http_build_query($data)));
        var_dump($rsa->verify($sign, urldecode(http_build_query($data))));


        exit();
        $ga = new PHPGangsta_GoogleAuthenticator();
        /*$secret = $ga->createSecret();
        var_dump($secret);

        $qrCodeUrl = $ga->getQRCodeGoogleUrl('Blog', $secret, "pdd");
        echo $qrCodeUrl;
        exit();*/
        $secret = '5COL6MTRFWOYH3YF';
        var_dump($secret);

        $code = Registry::get('parameters')['code'];
        $res = $ga->verifyCode($secret, $code, 1);
        var_dump($res);
        exit();

        $parameters = Registry::get('parameters');
        Registry::get('user_log')->info("ip:" . StringOperation::getIP());
        Registry::get('user_log')->info("parameters:" . json_encode($parameters));
//        echo json_encode($this->getRequest()->getServers());
//        exit();
        $referer = $this->getRequest()->getServer('HTTP_REFERER');
        $referer = parse_url($referer);
        parse_str($referer['query'], $referer_arr);

        $url = isset($referer_arr['url']) ? base64_decode($referer_arr['url']) : '';
        if (!empty($url))
            Registry::get('user_log')->info("server:" . $url);

        Registry::get('user_log')->info("cookie:" . json_encode($_COOKIE));


        return $this->_responseJson(new stdClass(), '000', 'success');
    }
}
