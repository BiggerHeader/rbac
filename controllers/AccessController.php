<?php
/**
 * Created by PhpStorm.
 * Access: ASUS
 * Date: 2017-05-11
 * Time: 18:42
 */

namespace app\controllers;


use app\controllers\common\BaseController;
use app\models\Role;
use app\models\Access;
use app\models\AccessRole;
use app\services\UrlSrevice;
use yii\db\Connection;

//用户实现伪登录
class AccessController extends BaseController
{
    public function actionIndex()
    {
        $data = Access::find()->where(['status' => 1])->all();
        return $this->render('index', ['data' => $data]);
    }

    /*
     * 处理get和post请求
     * get 展示角色
     * post添加叫角色 或 编辑角色
     */
    public function actionShowadd()
    {

        if (\Yii::$app->request->isGet) {
            $id = $this->get('id', 0);
            $data = [];
            if ($id) {
                //查询单个数据进行编辑
                $data = Access::find()->where(['id' => $id])->one();

            }
            return $this->render('add', ['data' => $data]);
        }
    }

    //处理添加权限程序
    public function actionAccessadd()
    {
        if (\Yii::$app->request->isPost) {
            $access_id = $this->post('id', '');
            $access_model = Access::find()->where(['id' => $access_id])->one();
            $title = trim($this->post('title', ''));
            $urls = trim($this->post('urls', ''));
            $date_time = date('Y-m-d H:i:s');

            if (mb_strlen($title, 'utf-8') < 1 && mb_strlen($title, 'utf-8') > 20) {
                return $this->returnJson([], '权限标题长度有误', 300);
            }

            if (!$urls) {
                $this->returnJson([], '路由不能为空', 300);
            }

            $urls_array = explode("\n", $urls);
            if (!$urls_array) {
                $this->returnJson([], '输入合法的的路由', 300);
            }

            $title_some = Access::find()->where(['title' => $title])->count();
            if ($title_some) {
                $this->returnJson([], '改标题已存在', -1);
            }

            if (!$access_model) {
                //不存在 就创建
                $access_model = new Access();
                $access_model->created_time = $date_time;
                $access_model->status = 1;
            }
            $access_model->title = $title;
            $access_model->urls = json_encode($urls_array);//json 格式保存
            $access_model->updated_time = $date_time;

            $access_model->save(0);
            return $this->returnJson([],'操作成功',200);
        }
    }
}