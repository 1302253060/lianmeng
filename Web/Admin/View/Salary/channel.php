<p><a href="/admin/salary/">》一级渠道工资列表</a></p>
<p>
<form method="get">
    结算月份<?=\Common\Helper\Form::input_date('date', $sDate)?>
    支付状态：<?=\Common\Helper\Form::select('status', $aPayStatus, $status)?>
    用户状态：<?=\Common\Helper\Form::select('user_status', $aUserStatus, $user_status)?>
    软件：<?=\Common\Helper\Form::select('soft', $aSelectSoft, $soft)?>
    一级渠道ID：<?=\Common\Helper\Form::input('user_id', $user_id, array('style' => 'width:100px;'))?>
    二级渠道ID：<?=\Common\Helper\Form::textarea('search_text', $search_text, array('placeholder' => '一行一个', 'style' => 'height:35px;width:130px;'))?>
    <?=\Common\Helper\Form::submit('', '查询')?>
</form>
<hr>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th>操作</th>
        <th>二级渠道号</th>
        <th>一级渠道号</th>
        <th>软件</th>
        <th>结算月份</th>
        <th>安装数</th>
        <th>原始单价（流量）</th>
        <th>原始总价（流量）</th>
        <th>结算单价（流量）</th>
        <th>结算总价（流量）</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($aList as $Item): ?>
        <tr>
            <td><input type="checkbox" name="month_price_id" value="<?=$Item['id']?>" /></td>
            <td><?=$Item['channel_id']?></td>
            <td><?=$Item['user_id']?></td>
            <td><?=isset($aSoft[$Item['soft_id']]) ? $aSoft[$Item['soft_id']]['name'] : $Item['soft_id'] ?></td>
            <td><?=$Item['date'] ?></td>
            <td><?=$Item['install_num'] ?></td>
            <td><?=$Item['avg_org_price'] ?></td>
            <td><?=$Item['total_money'] ?></td>
            <td><?=mEditableFunc($Item['id'], 'avg_limit_price', $Item['avg_limit_price'])?></td>
            <td><?=$Item['total_final_money'] ?></td>
        </tr>
    <?php endforeach; ?>

    <tr>
        <td colspan="80" style="text-align:left;">
            <input type="checkbox" name="btn_check_all" value="全选" />全选
            <br />
            <select name="set_is_pay">
                <?php
                $aPayStatus = array(
                    0 => '未支付',
                    2 => '待支付',
                );
                foreach ($aPayStatus as $iKey => $sVal): ?>
                    <option value="<?=$iKey?>"><?=$sVal?></option>
                <?php endforeach;?>
            </select>
            <input type="text" name="mark" placeholder="必填;请填写修改的理由or备注" value=""/>
            <input type="text" name="rate" placeholder="请填写打折的折扣，留空不打折" value=""/>
            <input type="button" name="btn_set_pay_status" value="将选中的数据更新" />
            <input type="button" name="btn_set_all_pay_status" value="将该查询的所有数据更新">
        </td>
    </tr>
    </tbody>
</table>
<div class="page">
    <?=$sPagination?>
</div>
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
                $("[name='month_price_id']").prop('checked','checked');
            } else {
                $("[name='month_price_id']").removeProp('checked');
            }
        });

        $("[name='btn_set_pay_status']").on('click' , function() {
            var mark = $("[name='mark']").val();
            var array_id = [];
            if(!mark.length) {
                alert('请先填写备注');
                $("[name='mark']").focus();
                return false;
            }
            var rate = $("[name='rate']").val();
            if (!rate.length || isNaN(rate)) {
                alert('请先填写数字');
                $("[name='rate']").focus();
                return false;
            }
            if (rate.length && (rate > 1 || rate < 0)) {
                alert('比例范围[0,1]');
                $("[name='rate']").focus();
                return false;
            }

            $("[name='month_price_id']:checked").each(function() {
                array_id[array_id.length] = $(this).val();
            });
            if(array_id.length <= 0) {
                alert('请选择后再操作');
                return;
            }
            var s_id = array_id.join(',');
            var status = $("[name='set_is_pay']").val();
            var post_data = {'ids':s_id,'status':status,'mark':mark, 'rate':rate};
            $.post('/admin/salary/update_pay_status',post_data,function(msg) {
                if(msg.code != 1) {
                    alert(msg.msg);
                    return false;
                }
                alert('更新成功');
                location.reload();
            },'json');
        });

        $("[name='btn_set_all_pay_status']").on('click' , function() {
            var mark = $("[name='mark']").val();
            if(!mark.length) {
                alert('请先填写备注');
                $("[name='mark']").focus();
                return false;
            }
            var rate = $("[name='rate']").val();
            if (rate.length && isNaN(rate)) {
                alert('请先填写数字');
                $("[name='rate']").focus();
                return false;
            }
            if (rate.length && (rate > 1 || rate < 0)) {
                alert('比例范围[0,1]');
                $("[name='rate']").focus();
                return false;
            }
            var status = $("[name='set_is_pay']").val();
            location.href = location.href + '&action=update_all&update_status='+status+'&mark='+mark+'&rate='+rate;
        });

    });
</script>

<link href="/public/statics/jqueryui-editable/css/jqueryui-editable.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/public/statics/jqueryui-editable/js/jqueryui-editable.min.js"></script>
<script type="text/javascript" src="/public/statics/assets/js/jquery.table-fixed-sides.js"></script>
<script type="text/javascript" src="/public/statics/assets/js/jquery.tablesorter.min.js"></script>