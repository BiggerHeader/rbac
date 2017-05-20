<?php

?>
<div class="panel panel-primary">
    你没有此操作的权限，请重新登录  <strong>   <a href="<?php
    echo \app\services\UrlSrevice::buildUrl(['/user/vlogin','uid'=>1]);
    ?>">登录</a></strong>
</div>