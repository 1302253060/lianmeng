<div class="main-content-body">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab" href="/Home/money/">兑换流量</a>
            <a class="dt-tab" href="/Home/money/list_detail">收支明细</a>
            <a class="dt-tab chosen" href="/Home/money/salary">提现记录</a>
        </div>
    </div>

    <div class="query-form">
        <form action="" method="get" id="selectForm">
            <label>日期</label>
            &nbsp;
            <span class="datepicker-area">
                <input style="height: 15px;" class="input-text datepicker" name="start_date" value="<?=$start_date?>">
                <span class="icon icon-calendar"></span>
            </span>
            &nbsp;
            至
            &nbsp;
            <span class="datepicker-area">
                <input style="height: 15px;" class="input-text datepicker" name="end_date" value="<?=$end_date?>">
                <span class="icon icon-calendar"></span>
            </span> &nbsp;&nbsp;
            <a class="btn btn-medium" id="btn-submit" href="#">查询</a>
        </form>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th style="width: 20%;"></th>
            <th style="width: 20%;"></th>
            <th style="width: 30%;"></th>
            <th style="width: 30%;"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>订单号</td>
            <td>申请提款流量数</td>
            <td>状态</td>
            <td>申请时间</td>
        </tr>
        <?php if (!empty($aList)) foreach ($aList as $aVal) { ?>
            <tr>
                <td><?=$aVal['order_bid']?></td>
                <td><?=number_format($aVal['point'])?></td>
                <td>
                    <?php
                        switch($aVal['status']) {
                            case \Admin\Model\UserOrderModel::ORDER_ING:
                                echo "提现中";
                                break;
                            case \Admin\Model\UserOrderModel::ORDER_SUCC:
                                echo "提现成功";
                                break;
                            case \Admin\Model\UserOrderModel::ORDER_FAIL:
                                echo "提现成功";
                                break;
                            default:
                                echo "-";
                                break;
                        }
                    ?>
                </td>
                <td><?=$aVal['create_time']?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="pagination">
        <?=$sPagination?>
    </div>
</div>

<script>
    $('#btn-submit').click(function(){
        $('#selectForm').submit();
    });
</script>