<style>
    label {
        display: inline-block;
        margin-right: 10px;
    }
</style>
<form action="/admin/apply/edit_post" method="post" class="form-horizontal" onsubmit="return LianMeng.form_post(this, window.location.href)">
    <?php if ($bEdit):?>
    <input name="id" value="<?= $Item->id ?>" type="hidden">
    <?php endif;?>
    <table class="mainTable">
        <tr>
            <td class="td1 right">ID :</td>
            <td><?=$Item->user_id?></td>
        </tr>
        <tr>
            <td class="td1 right">软件 :</td>
            <td>
                <?php
                $aSoft = explode(',', $Item->soft);
                if (!empty($aSoft)) {
                    $i = 0;
                    foreach (\Admin\Model\SoftModel::getAllSoft() as $iSoft => $aVal) {
                        if ($i > 0 && $i % 4 == 0) {
                            echo "<br>";
                        }
                        echo '<span style="width:150px;display:inline-block;">' . \Common\Helper\Form::checkbox('soft_id[]', $iSoft, in_array($iSoft, $aSoft) ? true : false) . $aVal['name'] . ' ' . '</span>';
                        ++$i;

                    }
                } else {
                    echo '';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="td1 right">申请数量 :</td>
            <td><?=\Common\Helper\Form::input('package_num', $Item->package_num)?></td>
        </tr>
        <tr>
            <td class="td1 right">其他要求 :</td>
            <td><?=$Item->other_info?></td>
        </tr>
        <tr>
            <td class="td1 right">是否通过审核 :</td>
            <td>
                <?php
                    if ($Item->status == \Admin\Model\ApplyModel::STATUS_ING) {
                ?>
                    <label><?=\Common\Helper\Form::radio('status', \Admin\Model\ApplyModel::STATUS_SUCC, $Item->status == \Admin\Model\ApplyModel::STATUS_SUCC ? true : false)?>是</label>
                    <label><?=\Common\Helper\Form::radio('status', \Admin\Model\ApplyModel::STATUS_FAIL, $Item->status == \Admin\Model\ApplyModel::STATUS_FAIL ? true : false)?>否</label>
                <?php
                    } elseif ($Item->status == \Admin\Model\ApplyModel::STATUS_SUCC) {
                        echo "已经申请成功";
                    } elseif ($Item->status == \Admin\Model\ApplyModel::STATUS_FAIL) {
                        echo "申请失败";
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td class="td1 right">原因 :</td>
            <td><?=\Common\Helper\Form::textarea('mark', $Item->mark)?></td>
        </tr>
        <tr>
            <td class="td1 right">申请时间 :</td>
            <td><?=$Item->create_time?></td>
        </tr>
        <tr>
            <td class="td1 right">最后更新时间 :</td>
            <td><?=$Item->update_time?></td>
        </tr>
        <tr>
            <td class="td1 right"></td>
            <td><?=\Common\Helper\Form::submit('', '提交')?></td>
        </tr>

    </table>
</form>




