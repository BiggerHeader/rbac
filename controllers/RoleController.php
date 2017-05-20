<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017-05-12
 * Time: 15:40
 */

namespace app\controllers;


use app\controllers\common\BaseController;
use app\models\Access;
use app\models\Role;
use app\models\RoleAccess;
use yii\filters\AccessRule;

class RoleController extends BaseController
{
    public function actionIndex()
    {
        $data = Role::find()->all();
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
            $role_accesss = [];
            if ($id) {
                //查询单个数据进行编辑
                $data = Role::find()->where(['id' => $id])->one();
                $role_accesss = $this->RoleAccess($id);
            }
            //获取权限列表
            $access_list = Access::find()->where(['status' => 1])->all();
            //获取选择中的权限
            return $this->render('add', ['data' => $data, 'access_list' => $access_list, 'role_accesss' => $role_accesss]);
        }

        //处理post数据
        $id = $this->post('id', 0);
        $name = $this->post('name', '');
        $time = date("Y-m-d H:m:s");
        //获取权限数据
        $access_ids = $this->post('access_ids', []);
        $isExist = Role::find()->where(['name' => $name])->andWhere(['!=', 'id', $id])->one();
        //判断数据是否存在吗， 存在就报错
        if ($isExist) {
            return $this->returnJson('此角色名已经存在，另取他名', '此角色名已经存在，另取他名', 400);
        }

        $role_model = Role::find()->where(['id' => $id])->one();

        $add_role_access = [];
        if (!$role_model) {
            //不存在  添加数据
            $role_model = new Role();
            $role_model->created_time = $time;
            $add_role_access = $access_ids;
        } else {
            $role_accesss = $this->RoleAccess($id);
            $add_role_access = array_diff($access_ids, $role_accesss);
            $rm_role_access = array_diff($role_accesss, $access_ids);
        }
        //存在  修改
        $role_model->name = $name;
        $role_model->updated_time = $time;
        // var_dump($add_role_access);exit();
        if ($role_model->save(0)) {
            //获取最后插入的ID
            $id = $id ? $id : $role_model->attributes['id'];
            if (!empty($rm_role_access)) {
                RoleAccess::deleteAll(
                    [
                        'role_id' => $id,
                        'access_id' => $rm_role_access  // 这里传递的是一个数组，相当于 in
                    ]
                );
            }
            //直接添加新添加的权限选项
            foreach ($add_role_access as $access_id) {
                $role_accesss = new  RoleAccess();
                $role_accesss->role_id = $id;
                $role_accesss->access_id = $access_id;
                $role_accesss->created_time = $time;
                $role_accesss->save(0);
            }
        }
        return $this->returnJson([], "操作成功~~", 200);
    }

    //获取权限数据
    protected function RoleAccess($id)
    {
        $role_accesss = RoleAccess::find()
            ->where(['role_id' => $id])
            ->indexBy('access_id')
            ->asArray()
            ->all();

        return array_keys($role_accesss);
    }
}