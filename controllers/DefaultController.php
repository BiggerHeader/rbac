<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017-05-11
 * Time: 20:51
 */

namespace app\controllers;


use app\behaviors\Behavior2;
use app\controllers\common\BaseController;
use app\models\Man;
use yii\web\Controller;

class DefaultController extends  Controller
{
    //我才是默认首页
    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionError()
    {
        return $this->render('error');
    }

    public function actionTest()
    {
         //获取子模块
      //  $user_module = \Yii::$app->getModule('user');
       // $user_module->runAction('default/index');
        $man = new Man();
        //这是第二种方法在运行时直接添加（对象的混合）
        $behavior2 = new Behavior2();
        $man->attachBehavior('behavior2',$behavior2);
        //调用行为里方法
        $man->eat();
        $man->trigger('shout_sleep');

    }
}