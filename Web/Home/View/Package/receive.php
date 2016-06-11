<div class="main-content-body">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab chosen" href="/Home/package/index">已审核</a>
            <a class="dt-tab" href="/Home/package/apply_list">未审核</a>
            <a class="dt-tab" href="/Home/package/cancel_list">审核未通过</a>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th style="width: 30%;"></th>
            <th style="width: 30%;"></th>
            <th style="width: 40%;"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>渠道名</td>
            <td>软件名</td>
            <td>操作</td>
        </tr>
        <?php if (!empty($aData)) foreach ($aData as $aVal) { ?>
            <tr>
                <td><?=$iChannelId?></td>
                <td><?=$aVal['name']?></td>
                <td>
                    <a href="<?=$aVal['url']?>">下载</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

