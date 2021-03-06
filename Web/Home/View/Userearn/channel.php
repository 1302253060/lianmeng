<div class="main-content-body">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab <?php if ($type == 1) { echo "chosen";}?>" href="/Home/userearn/channel?type=1">PC端渠道数据</a>
            <a class="dt-tab <?php if ($type == 2) { echo "chosen";}?>" href="/Home/userearn/channel?type=2">移动端渠道数据</a>
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
            </span>
            <a class="btn btn-medium" id="btn-select" href="#">查询</a>
        </form>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th style="width: 20%;"></th>
            <th style="width: 30%;"></th>
            <th style="width: 30%;"></th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>日期</td>
                <td>推广产品</td>
                <td>有效数</td>
            </tr>
            <?php if (!empty($aList)) foreach ($aList as $aVal) { ?>
            <tr>
                <td><?=$aVal['date']?></td>
                <td><?=isset($aSoft[$aVal['soft_id']]['name']) ? $aSoft[$aVal['soft_id']]['name'] : ''?></td>
                <td><?=$aVal['effect_org']?></td>
            </tr>
            <?php } ?>



        </tbody>
    </table>
    <div class="pagination">
        <?=$sPagination?>
    </div>
</div>

<script>
    $('#btn-select').click(function(){
        $('#selectForm input[name=is_export]').val(0);
        $('#selectForm').submit();
    });
</script>


<script>
    $('#btn-export').click(function(){
        $('#selectForm input[name=is_export]').val(1);
        $('#selectForm').submit();
    });
</script>