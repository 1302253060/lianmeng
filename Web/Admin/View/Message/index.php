<table class="mainTable">
    <thead>
        <tr>
            <th>接收人群</th>
            <th>其他人群</th>
            <th>类型</th>
            <th>标题</th>
            <th>发送时间</th>
            <th>发送状态</th>
            <th>操作</th>
        </tr>
    </thead>
    <?php foreach($aList as $aVal):?>
    <tr>
        <td>
            <?php
                if ($aVal['channel_type'] == \Admin\Model\MessageModel::CHANNEL_TYPE_ALL) {
                    echo "全部渠道";
                } else if ($aVal['channel_type'] == \Admin\Model\MessageModel::CHANNEL_TYPE_ONE) {
                    echo "一级渠道";
                } else if ($aVal['channel_type'] == \Admin\Model\MessageModel::CHANNEL_TYPE_TWO) {
                    echo "二级渠道";
                } else if ($aVal['channel_type'] == \Admin\Model\MessageModel::CHANNEL_TYPE_OTHER) {
                    echo "其他渠道";
                }
            ?>
        </td>
        <td>
            <div class="" style="max-height: 5em; overflow: auto;">
                <?php
                if ($aVal['channel_type'] == \Admin\Model\MessageModel::CHANNEL_TYPE_OTHER) {
                    echo $aVal['channel_list'];
                } else {
                    echo "-";
                }
                ?>
            </div>
        </td>
        <td><?php
            if ($aVal['type'] == \Admin\Model\MessageModel::TYPE_MESSAGE) {
                echo "站内信";
            } else if ($aVal['type'] == \Admin\Model\MessageModel::TYPE_MOBILE) {
                echo "手机短信";
            } else if ($aVal['type'] == \Admin\Model\MessageModel::TYPE_EMAIL) {
                echo "邮箱";
            }
            ?>
        </td>
        <td><?=$aVal['title']?></td>
        <td><?=$aVal['create_time']?></td>
        <td>
            <?php
                if ($aVal['status'] == \Admin\Model\MessageModel::STATUS_SEND_NO) {
                    echo "等待发送";
                } else if ($aVal['status'] == \Admin\Model\MessageModel::STATUS_SEND_SUCC) {
                    echo "发送成功";
                } else if ($aVal['status'] == \Admin\Model\MessageModel::STATUS_SEND_FAIL) {
                    echo "发送失败";
                } else if ($aVal['status'] == \Admin\Model\MessageModel::STATUS_SEND_ING) {
                    echo "正在发送中";
                }
            ?>
        </td>
        <td><a href="/admin/message/detail?msg_id=<?=$aVal['id']?>">查看</a></td>
    </tr>
    <?php endforeach;?>
</table>

<div class="page"><?=$sPagination;?></div> 
