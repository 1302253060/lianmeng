<p>
<form method="get">
    提款状态：<?=\Common\Helper\Form::select('apply_status', $aApplyStatus, $apply_status)?>
    渠道类型：<?=\Common\Helper\Form::select('level', $aLevel, $level)?>
    渠道ID：<?=\Common\Helper\Form::textarea('search_text', $search_text, array('placeholder' => '一行一个', 'style' => 'height:35px;width:130px;'))?>
    <?=\Common\Helper\Form::submit('', '查询')?>
</form>
<hr>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th>渠道号</th>
        <th>用户级别</th>
        <th>姓名</th>
        <th>订单号</th>
        <th>申请提款额度(流量)</th>
        <th>状态</th>
        <th>申请时间</th>
        <th>手机号</th>
        <th>收款人</th>
        <th>收款人银行账号</th>
        <th>开户支行名称</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($aList as $Item): ?>
        <tr>
            <td><?=$Item['user_id']?></td>
            <td><?=\Admin\Model\UserModel::getLevelName($Item['level'])?></td>
            <td><?=$Item['name']?></td>
            <td><?=$Item['order_bid']?></td>
            <td><?=$Item['point']?></td>
            <td style="color: #ff0000;"><?=$aApplyStatus[$Item['status']]?></td>
            <td><?=$Item['create_time']?></td>
            <td><?=$Item['mobile']?></td>
            <td><?=$Item['payee']?></td>
            <td><?=$Item['bankcard']?></td>
            <td><?=$Item['subbranch']?></td>
            <td>
                <?php if ($Item['status'] == \Admin\Model\UserOrderModel::ORDER_ING) { ?>
                    <a href="/admin/salary/apply_agree?id=<?=$Item['id']?>">同意</a>
                    <a href="/admin/salary/apply_reject?id=<?=$Item['id']?>">驳回</a>
                <?php } else { ?>
                    -
                <?php } ?>
            </td>
        </tr>
    <?php endforeach; ?>


    </tbody>
</table>




<link href="/public/statics/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/public/statics/jqueryui-editable/js/jqueryui-editable.min.js"></script>
<script type="text/javascript" src="/public/statics/assets/js/jquery.table-fixed-sides.js"></script>
<script type="text/javascript" src="/public/statics/assets/js/jquery.tablesorter.min.js"></script>