<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017-05-11
 * Time: 18:42
 */

namespace app\controllers;


use app\controllers\common\BaseController;
use app\models\Role;
use app\models\User;
use app\models\UserRole;
use app\services\UrlSrevice;
use yii\db\Connection;

//用户实现伪登录
class UserController extends BaseController
{
    public function actionIndex()
    {
        $data = User::find()->where(['status' => 1])->all();
        return $this->render('index', ['data' => $data]);
    }

    /*
     * 处理get和post请求
     * get 展示角色
     * post添加叫角色 或 编辑角色
     */
    public function actionSet()
    {

        if (\Yii::$app->request->isGet) {
            $id = $this->get('id', 0);
            $data = [];
            $user_roles = [];
            if ($id) {
                //查询单个数据进行编辑
                $data = User::find()->where(['id' => $id])->one();
                $user_roles = $this->Userrole($id);
            }
            //查询出角色表
            $roles = Role::find()->all();
            //查询出用户越角色的关系表
            return $this->render('add', ['data' => $data, 'roles' => $roles, 'user_roles' => $user_roles]);
        }

        //处理post数据
        $id = intval($this->post('id', 0));
        $name = trim($this->post('name', ''));
        $email = trim($this->post('email', ''));
        $time = date("Y-m-d H:m:s");

        $isExist = User::find()->where(['email' => $email])->andWhere(['!=', 'id', $id])->count();
        //判断数据是否存在吗， 存在就报错
        if ($isExist) {
            return $this->returnJson('此邮箱已经存在', '此邮箱已经存在', 400);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->returnJson('此邮箱格式错误', '此邮箱格式错误', 400);
        }

        $user_model = User::find()->where(['id' => $id])->one();
        $role_ids = $this->post('roles', []);
        $rm_user_roles = [];
        if (!$user_model) {
            //用不存户存在 添加
            $user_model = new User();
            $user_model->created_time = $time;
            $add_user_roles = $role_ids;
        } else {
            //获取user_role表中数据
            $user_roles = $this->Userrole($id);
            $add_user_roles = array_diff($role_ids, $user_roles);
            $rm_user_roles = array_diff($user_roles, $role_ids);
        }
        //用户存在 修改
        $user_model->name = $name;
        $user_model->email = $email;
        $user_model->updated_time = $time;

        //保存角色数据
        if ($user_model->save(0)) {
            //获取最后插入的ID
            $id = $id ? $id : $user_model->attributes['id'];
            if (!empty($rm_user_roles)) {
                UserRole::deleteAll(
                    [
                        'uid' => $id,
                        'role_id' => $rm_user_roles  // 这里传递的是一个数组，相当于 in
                    ]
                );
            }
            //直接 添加新添加的角色选项
            foreach ($add_user_roles as $role) {
                $user_roles = new UserRole();
                $user_roles->uid = $id;
                $user_roles->role_id = $role;
                $user_roles->created_time = $time;
                $user_roles->save(0);

            }
        }
        return $this->returnJson([], "操作成功~~", 200);
    }

    //获取user_role表中数据
    public
    function Userrole($id)
    {
        $user_roles = UserRole::find()
            ->where(['uid' => $id])
            ->select(['role_id'])
            ->indexBy('role_id')
            ->asArray()
            ->all();
        return array_keys($user_roles);
    }

    public
    function actionVlogin()
    {
        $urltodefault = UrlSrevice::buildUrl(['/']);
        //获取1d
        $uid = \Yii::$app->request->get('uid', 0);

        if (!$uid) {
            return $this->redirect($urltodefault);
        }

        $user = User::find()->where(['id' => $uid])->one();
        if (!$user) {
            return $this->redirect($urltodefault);
        }

        //设置cookie ， 设置为$auth_token+#+$usename

        $this->createCookie($user);

        return $this->redirect($urltodefault);
    }

    //用户登录页面
    public
    function actionLogin()
    {
        return $this->render("login", [
            'host' => $_SERVER['HTTP_HOST']
        ]);
    }

    public
    function actionVloginout()
    {
        $cookie = \Yii::$app - request()->cookies;
        if ($cookie->get($this->auth_cookie_name)) {
            //$cookie->
        }
    }
}