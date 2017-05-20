<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017-05-11
 * Time: 20:02
 */

namespace app\controllers;


use app\controllers\common\BaseController;

class TestController extends BaseController
{

    //一下是测试页面
    public function actionPage1()
    {
        return $this->render('page1');
    }

    public function actionPage2()
    {
        return $this->render('page2');
    }

    public function actionPage3()
    {
        return $this->render('page3');
    }

    public function actionPage4()
    {
        return $this->render('page4');
    }
}