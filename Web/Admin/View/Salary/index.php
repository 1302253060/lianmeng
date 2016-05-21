<p><a href="/admin/salary/channel">》二级渠道工资列表</a></p>
<p>
<form method="get">
    结算月份<?=\Common\Helper\Form::input_date('date', $sDate)?>
    支付状态：<?=\Common\Helper\Form::select('status', $aPayStatus, $status)?>
    用户状态：<?=\Common\Helper\Form::select('user_status', $aUserStatus, $user_status)?>
    软件：<?=\Common\Helper\Form::select('soft', $aSelectSoft, $soft)?>
    一级渠道ID：<?=\Common\Helper\Form::input('user_id', $user_id)?>
    <?=\Common\Helper\Form::submit('', '查询')?>
</form>
<hr>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th>渠道号</th>
        <th>软件</th>
        <th>结算月份</th>
        <th>安装数</th>
        <th>原始单价（流量）</th>
        <th>原始总价（流量）</th>
        <th>结算单价（流量）</th>
        <th>结算总价（流量）</th>
        <th>二级渠道清单</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($aList as $Item): ?>
        <tr>
            <td><?=$Item['user_id']?></td>
            <td><?=isset($aSoft[$Item['soft_id']]) ? $aSoft[$Item['soft_id']]['name'] : $Item['soft_id'] ?></td>
            <td><?=$Item['date'] ?></td>
            <td><?=$Item['install_num'] ?></td>
            <td><?=$Item['avg_org_price'] ?></td>
            <td><?=$Item['total_money'] ?></td>
            <td><?=$Item['avg_limit_price'] ?></td>
            <td><?=$Item['total_final_money'] ?></td>
            <td><a href="/admin/salary/channel?date=<?=$sDate?>&status=<?=$status?>&user_status=<?=$user_status?>&soft=<?=$soft?>&user_id=<?=$Item['user_id']?>">查看</a> </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php
function mEditableFunc($iId, $sKey, $sValue, $sTitle = '排序:', $sType = 'text') {
    return <<<EOF
            <a href="javascript:void(0);" class="update" data-type="{$sType}" data-pk="{$iId}" data-name="{$sKey}"
            data-url="/admin/soft/update_order" data-title="{$sTitle}">{$sValue}</a>
EOF;
};
?>
<script type="text/javascript">
    $(function() {
        $('.update').editable({
            display: function(value)
            {
//                $(this).text(parseInt(value));
            },
            error: function(response, newValue) {
                if(response.status === 500) {
                    return '更新失败';
                } else {
                    return response.responseText;
                }
            },
            success: function(response, newValue) {
                if(response.code == -1) {
                    return response.msg;
                }
//                $(this).text(newValue);
                location.href = location.href;
            },
            ajaxOptions : {dataType : 'json'}
        });
    });
</script>


<link href="/public/statics/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/public/statics/jqueryui-editable/js/jqueryui-editable.min.js"></script>
<script type="text/javascript" src="/public/statics/assets/js/jquery.table-fixed-sides.js"></script>
<script type="text/javascript" src="/public/statics/assets/js/jquery.tablesorter.min.js"></script>