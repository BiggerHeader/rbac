<?php

\app\services\ResourceService::includeAppJsStatic('/js/user/user.js', \app\assets\AppAsset::className());

?>
<form class="form-horizontal user_set_wrap">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="name"
                   value="<?= $data ? $data['name'] : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail3" name="email"
                   value="<?= $data ? $data['email'] : ''; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">选择角色</label>
        <div class="col-sm-10">
            <div class="checkbox">
                <?php foreach ($roles as $role): ?>
                    <label>
                        <input type="checkbox" name="roles[]" value="<?= $role['id'] ?>" <?php
                        if ($roles) {
                            if (in_array($role['id'], $user_roles)) {
                                echo 'checked="checked"';
                            }
                        }
                        ?>><?= $role['name'] ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="id" value="<?= $data ? $data['id'] : ''; ?>">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="button" class="btn btn-default save">提交</button>
        </div>
</form>