<p>
<form method="get">
    结算月份<?=\Common\Helper\Form::input_date('date', $sDate)?>
    软件：<?=\Common\Helper\Form::select('soft', $aSelectSoft, $soft)?>
    一级渠道ID：<?=\Common\Helper\Form::textarea('search_text', $search_text, array('placeholder' => '一行一个', 'style' => 'height:35px;width:130px;'))?>
    <?=\Common\Helper\Form::submit('', '查询')?>
</form>
<hr>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th>操作</th>
        <th>一级渠道号</th>
        <th>软件</th>
        <th>结算月份</th>
        <th>结算总价（流量）</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($aList as $Item): ?>
        <tr>
            <td><input type="checkbox" name="pay_user_id" value="<?=$Item['user_id']?>" /></td>
            <td><?=$Item['user_id']?></td>
            <td><?=isset($aSoft[$Item['soft_id']]) ? $aSoft[$Item['soft_id']]['name'] : $Item['soft_id'] ?></td>
            <td><?=$Item['date'] ?></td>
            <td class="total_money_<?=$Item['user_id']?>"><?=$Item['total_final_money']?></td>
        </tr>
    <?php endforeach; ?>

    <tr>
        <td colspan="80" style="text-align:left;">
            <label style="float: left;"><input type="checkbox" name="btn_check_all" style="float:left;" value="全选" />全选</label>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="btn_set_pay" value="发放选中渠道流量" />
        </td>
    </tr>
    </tbody>
</table>

<?php
function mEditableFunc($iId, $sKey, $sValue, $sTitle = '排序:', $sType = 'text') {
    return <<<EOF
            <a href="javascript:void(0);" class="update" data-type="{$sType}" data-pk="{$iId}" data-name="{$sKey}"
            data-url="/admin/salary/update_price" data-title="{$sTitle}">{$sValue}</a>
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


<script type="text/javascript">
    $(function() {
        $("[name='btn_check_all']").on('click',function() {
            if($(this).prop('checked')) {
                $("[name='pay_user_id']").prop('checked','checked');
            } else {
                $("[name='pay_user_id']").removeProp('checked');
            }
        });


        $(function() {

            $("[name='btn_set_pay']").on('click' , function() {
                var array_id = [];
                var sUserID = '';
                var s_date = "<?=$sDate?>";
                var point_total = 0;
                $("[name='pay_user_id']:checked").each(function() {
                    array_id[array_id.length] = $(this).val();
                    sUserID += $(this).val() + ", 发放" + $('.total_money_' + $(this).val()).text() + "流量\n";
                    point_total += parseFloat($('.total_money_' + $(this).val()).text());
                });
                if(array_id.length <= 0) {
                    alert('请选择后再操作');
                    return;
                }
                var s_id = array_id.join(',');

                console.log(s_id);
                sUserID += "一共发放" + point_total + "流量";
                if(!confirm(sUserID))
                {
                    return false;
                }
                var post_data = {'ids':s_id, 's_date':s_date};
                $.post('/admin/salary/pay_post',post_data,function(msg) {
                    if(msg.code != 1) {
                        alert(msg.errMsg);
                        return false;
                    }
                    alert(msg.msg);
                    location.reload();
                },'json');
            });


        });


    });
</script>

<link href="/public/statics/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/public/statics/jqueryui-editable/js/jqueryui-editable.min.js"></script>
<script type="text/javascript" src="/public/statics/assets/js/jquery.table-fixed-sides.js"></script>
<script type="text/javascript" src="/public/statics/assets/js/jquery.tablesorter.min.js"></script>