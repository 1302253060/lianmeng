<div class="main-content-body">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab <?php if ($type == 1) { echo "chosen"; }?>" href="/Home/userearn/last?type=1">PC端渠道数据</a>
            <a class="dt-tab <?php if ($type == 2) { echo "chosen"; }?>" href="/Home/userearn/last?type=2">移动端渠道数据</a>
        </div>
    </div>

    <div class="margin-top-5">
        <span class="icon-warning margin-right-5"></span>
        各款产品返量时间不同,一般会在第二日24点前返量,请耐心等待
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
                <td>推广产品</td>
                <td>有效数</td>
                <td>反量时间</td>
            </tr>
            <?php if (!empty($aData)) foreach ($aData as $aVal) { ?>
            <tr>
                <td><?=isset($aSoft[$aVal['soft_id']]['name']) ? $aSoft[$aVal['soft_id']]['name'] : ''?></td>
                <td><?=$aVal['effect_org']?></td>
                <td><?=isset($aTimeData[$aVal['soft_id']]) ? $aTimeData[$aVal['soft_id']] : ''?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>