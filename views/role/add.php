<?php

\app\services\ResourceService::includeAppJsStatic('/js/role/set.js', \app\assets\AppAsset::className());

?>
<form class="form-horizontal role_set_wrap">
    <label for="inputEmail3" class="col-sm-2 control-label">添加角色</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="inputEmail3" name="name"
               value="<?= $data ? $data['name'] : ''; ?>">
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">选择权限</label>
        <div class="col-sm-10">
            <div class="checkbox">
                <?php foreach ($access_list as $item): ?>
                    <label>
                        <input type="checkbox" name="access_ids[]" value="<?= $item['id'] ?>" <?php
                        if ($role_accesss) {
                            if (in_array($item['id'], $role_accesss)) {
                                echo 'checked="checked"';
                            }
                        }
                        ?>>
                        <?= $item['title'] ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="id" value="<?= $data ? $data['id'] : ''; ?>">
    <button type="button" class="btn btn-default pull-right save">提交</button>
</form>