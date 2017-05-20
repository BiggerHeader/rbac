<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017-05-16
 * Time: 16:26
 */

namespace app\behaviors;


use yii\base\Behavior;

class Behavior2 extends  Behavior
{
    public function  sleep($event){
        echo '我在睡觉~~~<br/>';
    }

    //监听事件
    public function events(){
        return [
            'shout_sleep'=>'sleep',//shout_sleep事件，对应的方法
        ];
    }
    public function eat(){
        echo '人要吃饭';
    }
}