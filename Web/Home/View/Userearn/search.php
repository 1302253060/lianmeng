<div class="main-content-body">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab <?php if ($type == 1) { echo "chosen";}?>" href="/Home/userearn/search?type=1">PC端渠道数据</a>
            <a class="dt-tab <?php if ($type == 2) { echo "chosen";}?>" href="/Home/userearn/search?type=2">移动端渠道数据</a>
        </div>
    </div>

    <div class="query-form">
        <form action="" method="get" id="selectForm">
            <label>日期</label>
            &nbsp;
            <span class="datepicker-area">
                <input style="height: 15px;" class="input-text datepicker" name="start_date" value="<?=$sStartDate?>">
                <span class="icon icon-calendar"></span>
            </span>
            &nbsp;
            至
            &nbsp;
            <span class="datepicker-area">
                <input style="height: 15px;" class="input-text datepicker" name="end_date" value="<?=$sEndDate?>">
                <span class="icon icon-calendar"></span>
            </span>
            <br>
            <br>
            <label>筛选</label>
            &nbsp;
            <select class="selectpicker" name="search_key">
                <option value="id" <?php if ($search_key == 'user_id') { echo "selected";} ?> >渠道ID</option>
                <option value="name" <?php if ($search_key == 'name') { echo "selected";} ?> >渠道名</option>
            </select>
            &nbsp;
            <input style="height: 15px;" class="input-text" name="search_text" value="<?=$search_text?>">
            <br>
            <br>
            <label>显示</label>
            &nbsp;
            <select class="selectpicker" name="search_action">
                <option value="date" <?php if ($search_action == 'date') { echo "selected";} ?> >日期维度显示</option>
                <option value="channel" <?php if ($search_action == 'channel') { echo "selected";} ?> >渠道维度显示</option>
            </select>
            <a class="btn btn-medium" id="btn-select" href="#">查询</a>
            <a class="btn btn-medium" id="btn-export" href="#">导出</a>
            <input type="hidden" name="is_export" value="0">
        </form>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th style="width: 30%;"></th>
            <th style="width: 30%;"></th>
            <th style="width: 40%;"></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($search_action == 'date'){ ?>
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
        <?php } ?>


        <?php if ($search_action == 'channel'){ ?>
            <tr>
                <td>渠道号</td>
                <td>推广产品</td>
                <td>有效数</td>
            </tr>
            <?php if (!empty($aList)) foreach ($aList as $aVal) { ?>
                <tr>
                    <td><?=$aVal['channel_id']?></td>
                    <td><?=isset($aSoft[$aVal['soft_id']]['name']) ? $aSoft[$aVal['soft_id']]['name'] : ''?></td>
                    <td><?=$aVal['effect_org']?></td>
                </tr>
            <?php } ?>
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