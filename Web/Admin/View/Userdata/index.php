<form class="form-inline" action="" method="get" name="table_form">
    <?=\Common\Helper\Form::select("level", $aLevel, $level)?>
    <?=\Common\Helper\Form::input("userid", $userid, array('placeholder' => '输入渠道号ID'))?>
    <?=\Common\Helper\Form::select("soft", $aSoft, $soft)?>
    <?=\Common\Helper\Form::input_date('start_date', $start_date)?>
    -
    <?=\Common\Helper\Form::input_date('end_date', $end_date)?>
    <?=\Common\Helper\Form::select("is_cut", $aCut, $is_cut)?>
    <?=\Common\Helper\Form::submit('query', '查询')?>
</form>


<table border="1" class="table table-bordered">
    <thead>
    <tr>
        <th>二级渠道ID</th>
        <th>一级渠道ID</th>
        <th>软件</th>
        <th>日期</th>
        <th>原始反量</th>
        <th>最终反量</th>
        <th>虚拟机量</th>
        <th>虚拟机扣除量</th>
        <th>虚拟机是否扣量</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($aList)): foreach ($aList as $item): ?>
        <tr>
            <td><?= $item['channel_id'] ?></td>
            <td><?= $item['user_id'] ?></td>
            <td><?= $item['date'] ?></td>
            <td><?= $aSoft[$item['soft_id']] ?></td>
            <td><?= (int)$item['origin_org'] ?></td>
            <td><?= (int)$item['effect_org'] ?></td>
            <td><?= (int)$item['vm_num'] ?></td>
            <td><?= (int)$item['cut_vm_num'] ?></td>
            <td><?= (int)$item['is_sub'] === \Admin\Model\DailyDataModel::VM_NO_CUT ? '未扣量' : '<font color="red">已扣量</font>' ?></td>
        </tr>
    <?php endforeach; endif; ?>
    </tbody>
</table>
<div class="page"><?= $sPagination ?></div>
