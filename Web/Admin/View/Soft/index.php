<?php
$iOnline = \Admin\Model\SoftModel::STATUS_ONLINE;
$iOffline = \Admin\Model\SoftModel::STATUS_OFFLINE;
/** @var \Admin\Model\Item_Soft[] $aList */

?>
<p><a href="/admin/soft/add">》添加新条目</a></p>
<p>
<form method="get">
    搜索软件：<?=\Common\Helper\Form::input('kw', $kw, array('placeholder' => '关键字'))?>
    状态：<?=\Common\Helper\Form::select('status', $aStatus, $status)?>
    </select>
    <?=\Common\Helper\Form::submit('', '查询')?>
</form>
<hr>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>LOGO</th>
        <th>软件名称</th>
        <th>版本</th>
        <th>价格</th>
        <th>状态</th>
        <th>软件类型</th>
        <th>创建时间</th>
        <th>更新时间</th>
        <th style="width:80px;">排序</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($aList as $Item): ?>
        <tr>
            <td><?=$Item['id']?></td>
            <td><img alt="未设置" style="width:40px;height:40px;" src="<?=$Item['logo']?>" /></td>
            <td><?=$Item['name'] ?></td>
            <td><?=$Item['version'] ?></td>
            <td><?=$Item['price'] ?></td>
            <td style="color:<?=$Item['status']==$iOnline ? 'green' : 'red'?>"><?=$Item['status']==$iOnline ? '在线' : '下线'?></td>
            <td style="color:<?=$Item['status']==$iOnline ? 'green' : 'red'?>"><?=$Item['type']==\Admin\Model\SoftModel::TYPE_PC ? 'PC端' : 'APP端'?></td>
            <td><?=$Item['create_time'] ?></td>
            <td><?=$Item['update_time'] ?></td>
            <td><?=mEditableFunc($Item['id'], 'show_order', $Item['show_order'])?>
            </td>
            <td><a href="/admin/soft/edit?id=<?=$Item['id']?>">编辑</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="page">
    <?=$sPagination?>
</div>
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