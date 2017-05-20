<?php

?>
<div class="table-responsive">
    <p class="pull-right"><a href="<?= \app\services\UrlSrevice::buildUrl(['role/set']); ?>">添加角色</a>
    </p>
    <table class="table">
        <tr>
            <th colspan="3" >角色列表展示</th>
        </tr>
        <?php if (!empty($data)): ?>
            <tr>
                <td>ID</td>
                <td>角色名</td>
                <td>操作</td>
            </tr>
            <?php foreach ($data as $datum): ?>
                <tr>
                    <td> <?= $datum['id'] ?></td>
                    <td> <?= $datum['name'] ?></td>
                    <td>
                        <a href="<?= \app\services\UrlSrevice::buildUrl(['/role/set'], ['id' => $datum['id']]) ?>">操作</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">暂无数据</td>
            </tr>
        <?php endif; ?>
    </table>
</div>