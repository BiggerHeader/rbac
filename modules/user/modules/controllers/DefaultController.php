<?php

namespace app\modules\user\modules\controllers;

use yii\web\Controller;

/**
 * Default controller for the `login` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //http://rbac.dev/user/login/default/index
        echo  "user 的 子模块";
      //  return $this->render('index');
    }
}
