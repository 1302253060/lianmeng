<div class="main-content-body">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab chosen" href="/Home/package/index">已审核</a>
            <a class="dt-tab" href="/Home/package/apply_list">未审核</a>
            <a class="dt-tab" href="/Home/package/cancel_list">审核未通过</a>
        </div>
    </div>

    <div class="query-form">
        <form action="" method="get" id="selectForm">
            <label>渠道</label>
            &nbsp;
            <select class="selectpicker" name="search_key">
                <option value="id" <?php if ($aGet['search_key'] == 'id') { echo "selected"; } ?> >渠道ID</option>
                <option value="name" <?php if ($aGet['search_key'] == 'name') { echo "selected"; } ?> >渠道名</option>
            </select>
            &nbsp;
            <input style="height: 15px;" class="input-text" name="search_text" value="<?=$aGet['search_text']?>">
            &nbsp;
            <a class="btn btn-medium" id="btn-search" href="#">查询</a>
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
            <td>渠道号</td>
            <td>渠道名</td>
            <td>备注</td>
            <td>操作</td>
        </tr>
        <?php if (!empty($aList)) foreach ($aList as $aVal) { ?>
            <tr>
                <td><?=$aVal['id']?></td>
                <td><?=$aVal['name']?></td>
                <td>
                    <?php
                        $aNote = unserialize($aVal['note_info']);
                        echo isset($aNote['mark']) ? $aNote['mark'] : '';
                    ?>
                </td>
                <td>
                    <a href="/Home/package/receive?channel_id=<?=$aVal['id']?>">领取渠道包</a>&nbsp;&nbsp;
                    <a href="/Home/package/channel?channel_id=<?=$aVal['id']?>">查看推广数据</a>&nbsp;&nbsp;
                    <a href="/Home/package/edit?channel_id=<?=$aVal['id']?>" class="packageMark">编辑用户</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="pagination">
        <?=$sPagination?>
    </div>


</div>


<script>
    $('#btn-search').click(function(){
        $('#selectForm').submit();
    });
</script>

