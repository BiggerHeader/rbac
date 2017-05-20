<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017-05-16
 * Time: 16:27
 */

namespace app\models;


use app\behaviors\Behavior2;
use yii\base\Component;

class Man extends  Component
{
    //第一种方法直接在模型里面进行注入 （类的混合）。第二种方法在运行时直接添加
    public function  behaviors(){
           return [
                  Behavior2::className(),//把对象behavior2的对象注入到主件中
           ];
    }
}