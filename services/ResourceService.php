<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017-05-12
 * Time: 16:51
 */

namespace app\services;


class ResourceService
{
    //使用yii统一加载方法 加载js 或者css
    public static function includeAppStatic($type,$path,$depend)
    {
        //添加版本好解决流浪器缓存问题
        $release_version = defined("RELEASE_VERSION") ? RELEASE_VERSION : "000000";
        if(stripos($path,"?") !==false){
            $path = $path."&v={$release_version}";
        }else{
            $path = $path."?v={$release_version}";
        }
        if($type =="css"){
            \Yii::$app->getView()->registerCssFile($path,['depends'=>$depend]);
        }else{
            \Yii::$app->getView()->registerJsFile($path,['depends'=>$depend]);
        }

    }
    //引入js业务文件
    public static function includeAppJsStatic($path, $depend)
    {
        self::includeAppStatic('js', $path, $depend);
    }
    //引入css业务文件
    public static  function  includeAppCssStatis($path,$depend){
        self::includeAppStatic('css',$path,$depend);
    }
}