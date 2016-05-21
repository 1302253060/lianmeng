<h3>站内信详情</h3>
<a href="/admin/message/">返回列表页</a>
<table class="mainTable">
    <tr>
        <td style="width: 150px;" align="right">ID</td>
        <td><?=$MF->id?></td>
    </tr>
    <tr>
        <td align="right">标题</td>
        <td><?=$MF->title?></td>
    </tr>
    <tr>
        <td align="right">内容</td>
        <td><?=$MF->content?></td>
    </tr>
    <tr>
        <td align="right">创建时间</td>
        <td><?=$MF->create_time?></td>
    </tr>
    <tr>
        <td align="right">发送人数</td>
        <td><?=$iTotal?></td>
    </tr>
    <tr>
        <td align="right">打开人数</td>
        <td><?=$iReadTotal?></td>
    </tr>
    <tr>
        <td align="right">接收人群</td>
        <td>
            <?php
            if ($MF->channel_type == \Admin\Model\MessageModel::CHANNEL_TYPE_ALL) {
                echo "全部渠道";
            } else if ($MF->channel_type == \Admin\Model\MessageModel::CHANNEL_TYPE_ONE) {
                echo "一级渠道";
            } else if ($MF->channel_type == \Admin\Model\MessageModel::CHANNEL_TYPE_TWO) {
                echo "二级渠道";
            } else if ($MF->channel_type == \Admin\Model\MessageModel::CHANNEL_TYPE_OTHER) {
                echo "其他渠道";
            }
            ?><br>
            <?php
            if ($MF->channel_type == \Admin\Model\MessageModel::CHANNEL_TYPE_OTHER) {
                echo $MF->channel_list;
            } else {
                echo "-";
            }
            ?>
        </td>
    </tr>
</table>