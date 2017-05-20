<?php

?>
<div class="table-responsive">
    <p class="pull-right"><a href="<?= \app\services\UrlSrevice::buildUrl(['/access/showadd']); ?>">添加权限</a>
    </p>
    <table class="table">
        <tr>
            <th colspan="4" >权限列表展示</th>
        </tr>
        <?php if (!empty($data)): ?>
            <tr>
                <td>ID</td>
                <td>权限</td>
                <td>操作</td>
            </tr>
            <?php foreach ($data as $datum): ?>
                <tr>
                    <td> <?= $datum['id'] ?></td>
                    <td> <?= $datum['title'] ?></td>
                    <td>
                        <a href="<?= \app\services\UrlSrevice::buildUrl(['/access/showadd'], ['id' => $datum['id']]) ?>">修改</a>
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