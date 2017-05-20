<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017-05-11
 * Time: 16:47
 */

namespace app\controllers\common;

//所有的控制器都会继承这个基类
use app\models\Access;
use app\models\AccessLog;
use app\models\back;
use app\models\RoleAccess;
use app\models\User;
use app\models\UserRole;
use app\services\UrlSrevice;
use yii\web\Controller;
use Yii;

class BaseController extends Controller
{
    protected $auth_cookie_name = "datou";
    protected $current_user = null;//当前登录人信息
    //允许操作的动作
    protected $allowAction = [
        'user/login',
        'user/vlogin',
        'default/index',
        'default/error',
        'default/test'
    ];

    //系统中所有动作需要的登录之后才可以操作，在此统一验证
    public function beforeAction($action)
    {
        //获取的登录状态
        $login_status = $this->checkLoginStatus();

        //如果没有登录，且该动作不在允许操作的动作之内，就提示该动作需要登录
        if (!$login_status && !in_array($action->uniqueId, $this->allowAction)) {
            if (\Yii::$app->request->isAjax) {
                $this->returnJson([], '该动作需要登录', '300');
            } else {
                /*实在个大问题，没有此方法*/
                $this->redirect(UrlSrevice::buildUrl(["/user/login"]));//返回到登录页面
            }
            return false;
        }
        //保存所有的访问到数据库当中
        $get_params = $this->get( null );
        $post_params = $this->post( null );
        $model_log = new AccessLog();
        $model_log->uid = $this->current_user?$this->current_user['id']:0;
        $model_log->target_url = isset( $_SERVER['REQUEST_URI'] )?$_SERVER['REQUEST_URI']:'';
        $model_log->query_params = json_encode( array_merge( $post_params,$get_params ) );
        $model_log->ua = isset( $_SERVER['HTTP_USER_AGENT'] )?$_SERVER['HTTP_USER_AGENT']:'';
        $model_log->ip = isset( $_SERVER['REMOTE_ADDR'] )?$_SERVER['REMOTE_ADDR']:'';
        $model_log->created_time = date("Y-m-d H:i:s");
        $model_log->save( 0 );

        if (!$this->checkPrivilege($action->getUniqueId())) {
            $this->redirect(UrlSrevice::buildUrl(['/default/error']));
            return false;
        }
        return true;
    }

    /*
     * 检验用户是否有改权限
     * */
    public function checkPrivilege($url)
    {
        //出去超级管理员
        if ($this->current_user && $this->current_user['is_admin']) {
            return true;
        }
        //出去忽略的全限
        if (in_array($url, $this->allowAction)) {
            return true;
        }
        //最后检验是否具有改权限
        if (!$this->getRolePrivilege()) {
            return false;
        }
        //注意返回是二维数组
        $access_list = $this->getRolePrivilege();
        foreach ($access_list as $item) {
            if (in_array($url, $item)) {
                return true;
            }
        }

        return false;
    }

    /*
     * 获取登录用户的权限
     * 通过用户 ID -> 角色role -> 权限 access
     *
     */
    public function getRolePrivilege($uid = 0)
    {
        if (!$uid && $this->current_user) {
            $uid = $this->current_user['id'];
        }
        //获取角色ids
        $role_ids = UserRole::find()
            ->where(['uid' => $uid])
            ->select('role_id')
            ->asArray()
            ->column();
        if ($role_ids) {
            //获取权限ids
            $access_ids = RoleAccess::find()
                ->where(['role_id' => $role_ids])
                ->select('access_id')
                ->asArray()
                ->column();
            //获取所有的权限列表
            $access_list = Access::find()
                ->where(['id' => $access_ids])
                ->select('urls')
                ->column();
            //对每个存储的路由进行json_decode
            $decode_access_list = [];
            foreach ($access_list as $item) {
                $decode_access_list[] = @json_decode($item);
            }

            return $decode_access_list;
        }
        return false;
    }

    //获取post提交过来的数据
    public function post($name, $default_value = '')
    {
        return \Yii::$app->request->post($name, $default_value);
    }

    //获取get提交过来的数据
    public function get($name, $default_value ='')
    {
        return \Yii::$app->request->get($name, $default_value);
    }

    //返回json数据
    public function returnJson($data, $msg = "", $code)
    {
        header('Content-type: application/json');//设置头部内容格式
        return json_encode([
            'msg' => $msg,
            'code' => $code,
            'data' => $data,
        ]);
        return Yii::$app->end();//结束请求
    }

    //检验登录状态
    public function checkLoginStatus()
    {
        //获取cookie判断是否登录
        $cookie = \Yii::$app->request->cookies;
        $value = $cookie->get($this->auth_cookie_name);

        if (!$value) {
            return false;
        }
        list($auth_token, $uid) = explode("#", $value);

        if ($uid && preg_match('/^\d+$/', $uid)) {
            $user = User::find()->where(['id' => $uid])->one();

            //校验token是否与数据的数据一致，防止伪造
            $isSome = $this->createAuthToken($user) == $auth_token ? true : false;
            if ($isSome) {
                //说明改用户已经登录,
                $this->current_user = $user;
                $view = Yii::$app->view;
                $view->params["current_user"] = $user['name'];

                return true;
            }
            return false;
        }
        return false;
    }

    public function createCookie($user)
    {
        $auth_token = $this->createAuthToken($user);
        $cookie = \Yii::$app->response->cookies;
        $cookie->add(new \yii\web\Cookie([
            'name' => $this->auth_cookie_name,
            'value' => $auth_token . "#" . $user['id'],
        ]));
    }

    //拼接token
    public function createAuthToken($user)
    {
        return md5($user['id'] . $user['name'] . $user['email'] . $_SERVER['HTTP_USER_AGENT']);
    }
}