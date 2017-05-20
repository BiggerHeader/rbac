<?php

\app\services\ResourceService::includeAppJsStatic('/js/access/access.js', \app\assets\AppAsset::className());

?>
<form class="form-horizontal access_set_wrap">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">权限名</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="title"
                   value="<?= $data ? $data['title'] : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">阻止路由</label>
        <div class="col-sm-10">
            <textarea class="form-control"  name="urls"><?php
                 if($data){
                     foreach (json_decode($data['urls']) as $item){
                         echo $item."\n";
                     }
                 }
                ?></textarea>
        </div>
    </div>

    <input type="hidden" name="id" value="<?= $data ? $data['id'] : ''; ?>">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="button" class="btn btn-default save">提交</button>
        </div>
    </div>
</form>