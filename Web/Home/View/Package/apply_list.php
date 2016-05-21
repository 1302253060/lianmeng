<div class="main-content-body">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab" href="/Home/package/index">已审核</a>
            <a class="dt-tab chosen" href="/Home/package/apply_list">未审核</a>
            <a class="dt-tab" href="/Home/package/cancel_list">审核未通过</a>
        </div>
    </div>


    <table class="table">
        <thead>
        <tr>
            <th style="width: 30%;"></th>
            <th style="width: 30%;"></th>
            <th style="width: 20%;"></th>
            <th style="width: 20%;"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>申请渠道个数</td>
            <td>申请软件</td>
            <td>其他要求</td>
            <td>申请时间</td>
        </tr>

        <?php if (!empty($aList)) foreach ($aList as $aVal) { ?>
            <tr>
                <td><?=$aVal['package_num']?></td>
                <td>
                    <?php
                    $aSoft = explode(',', $aVal['soft']);
                    if (!empty($aSoft)) {
                        foreach ($aSoft as $iVal) {
                            echo \Admin\Model\ApplyModel::getSoft($iVal)['name'] . "，";
                        }
                    } else {
                        echo '';
                    }
                    ?>
                </td>
                <td><?=!empty($aVal['other_info']) ? $aVal['other_info'] : '-'?></td>
                <td><?=$aVal['create_time']?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="pagination">
        <?=$sPagination?>
    </div>
</div>