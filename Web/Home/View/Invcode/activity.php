<div class="main-content-body">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab" href="/Home/invcode/get_code">领取</a>
            <a class="dt-tab chosen" href="/Home/invcode/activity">已激活</a>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>邀请码</th>
            <th>状态</th>
            <th>激活对象</th>
            <th>激活时间</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($aList as $list): ?>
            <tr>
                <td><?= $list['code'] ?></td>
                <td><?=$list['status']==2 ? '已激活/不可使用' : '未激活/可使用'?></td>
                <td><?=isset($aUser[$list['apply_user_id']])?$aUser[$list['apply_user_id']]:'-';?></td>
                <td><?=$list['apply_time']=='0000-00-00 00:00:00' ? '-' : $list['apply_time']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?=$sPagination?>
    </div>
</div>
