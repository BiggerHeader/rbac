<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017-05-11
 * Time: 15:54
 */

namespace app\services;

//统一管理链接
use yii\helpers\Url;

class UrlSrevice
{
    //返回一个链接
    public static function buildUrl(array  $url, $params =[])
    {
        return Url::toRoute(array_merge($url, $params));
    }

    //返回一个空链接
    public  static function buildNullUrl()
    {
        return "javascript:void(0);";
    }
}