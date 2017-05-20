<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use app\services\UrlSrevice;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = "@webroot";
    public $baseUrl = "@web";

    /* public $css = [
         "css/site.css",
     ];
     public $js = [
     ];
     public $depends = [
         "yii\web\YiiAsset",
         "yii\bootstrap\BootstrapAsset",
     ];*/
    public function registerAssetFiles($view)
    {
        //添加版本号
        $release = 1.0;
        $buildUrl = new UrlSrevice();
        $this->css = [
            $buildUrl->buildUrl(["/bootstrap/css/bootstrap.css"], ['version'=>$release]),
            $buildUrl->buildUrl(["/css/app.css"],  ['version'=>$release]),
        ];
        $this->js = [
            $buildUrl->buildUrl(["/jQuery/jquery-3.2.0.min.js"],  ['version'=>$release]),
            $buildUrl->buildUrl(["/bootstrap/js/bootstrap.js"],  ['version'=>$release])
        ];
        parent::registerAssetFiles($view);
    }
}
