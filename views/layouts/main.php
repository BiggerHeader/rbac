<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use \app\services\UrlSrevice;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!--导航-->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Rbac权限管理</a>
        </div>
        <div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?= UrlSrevice::buildUrl(['/']) ?>">首页</a></li>
            </ul>
            <?php if(isset($this->params['current_user'])){ ?>
            <p class="navbar-text navbar-right">Hi <a href="#" class="navbar-link"><?=$this->params['current_user'] ?> </a></p>
           <?php } ?>
        </div>
    </div>
</nav>
<!--主题-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <h2>测试页面</h2>
            <ul class="nav nav-sidebar">
                <li><a href="<?=UrlSrevice::buildUrl(['/test/page1']) ?>">page1</a></li>
                <li><a href="<?=UrlSrevice::buildUrl(['/test/page2']) ?>">page2</a></li>
                <li><a href="<?=UrlSrevice::buildUrl(['/test/page3']) ?>">page3</a></li>
                <li><a href="<?=UrlSrevice::buildUrl(['/test/page4']) ?>">page4</a></li>
            </ul>
            <h2>角色</h2>
            <ul class="nav nav-sidebar">
                <li><a href="<?=UrlSrevice::buildUrl(['/role/index']) ?>">角色管理</a></li>
                <li><a href="<?=UrlSrevice::buildUrl(['/user/index']) ?>">用户管理</a></li>
                <li><a href="<?=UrlSrevice::buildUrl(['/access/index']) ?>">权限管理</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?=$content; ?>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
