<form id="search_export_form">
    <input type="hidden" value="0" name="export" id="export">
    状态 <?=\Common\Helper\Form::select('status', $aStatus, $status)?>
    <?=\Common\Helper\Form::input('user_id', $user_id, array('placeholder' => '用户ID'))?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <?=\Common\Helper\Form::submit('', '查询', array('onclick' => "$('#export').val(0);$('#search_export_form').submit();return false;"))?>
</form>
<hr>
<table class="mainTable">
    <thead>
    <tr>
        <th>用户ID</th>
        <th>申请软件</th>
        <th>申请包数量</th>
        <th>其他要求</th>
        <th>状态</th>
        <th>注册时间</th>
        <th style="width:80px;">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($aList)) { foreach ($aList as $Item): ?>
        <tr>
            <td><?=$Item['user_id'] ?></td>
            <td>
                <?php
                    $aSoft = explode(',', $Item['soft']);
                    if (!empty($aSoft)) {
                        foreach ($aSoft as $iVal) {
                            echo \Admin\Model\ApplyModel::getSoft($iVal)['name'] . "，";
                        }
                    } else {
                        echo '';
                    }
                ?>
            </td>
            <td><?=$Item['package_num'] ?></td>
            <td><?=$Item['other_info'] ?></td>
            <td>
                <?php
                    if ((int)$Item['status'] === \Admin\Model\ApplyModel::STATUS_ING) {
                        echo "申请中";
                    } elseif ((int)$Item['status'] === \Admin\Model\ApplyModel::STATUS_SUCC) {
                        echo "申请成功";
                    } elseif ((int)$Item['status'] === \Admin\Model\ApplyModel::STATUS_FAIL) {
                        echo "申请失败";
                    }
                ?>
            </td>
            <td><?=$Item['create_time']?></td>
            <td>
                <a href="/admin/apply/edit?id=<?=$Item['id']?>">查看</a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php } else { ?>
        <tr>
            <td colspan="13" class="center">对不起，暂无相应数据</td>
        </tr>
    <?php }?>
    </tbody>
</table>
<div class="page"><?=$sPagination?></div>


<script type="text/javascript" src="/Public/statics/assets/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/plugin/bd.dlg.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/admin/user_manager.js"></script>
<script type="text/javascript" src="/Public/statics/zeroclipboard/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/jquery.table-fixed-sides.js"></script>


