<style>
    label {
        display: inline-block;
        margin-right: 10px;
    }
</style>
<form action="/admin/usercompany/edit_post" method="post" class="form-horizontal" onsubmit="return LianMeng.form_post(this, window.location.href)">
    <?php if ($bEdit):?>
    <input name="id" value="<?= $Item->id ?>" type="hidden">
    <?php endif;?>
    <table class="mainTable">
        <tr>
            <td class="td1 right">ID :</td>
            <td><?=$Item->id?></td>
        </tr>
        <tr>
            <td class="td1 right">用户名 :</td>
            <td><?=$Item->name?></td>
        </tr>
        <tr>
            <td class="td1 right">身份证 :</td>
            <td><?=$Item->idcard?></td>
        </tr>
        <tr>
            <td class="td1 right">身份证认证 :</td>
            <td>
                <?=\Admin\Model\UserModel::isIdcardOk($Item->idcard_ok) ? '通过' : '未通过'?>
            </td>
        </tr>
        <tr>
            <td class="td1 right">通讯地址 :</td>
            <td><?=$Item->province.$Item->city.$Item->county.$Item->address?></td>
        </tr>
        <tr>
            <td class="td1 right">是否冻结 :</td>
            <td>
                <?=\Admin\Model\UserModel::isFreeze($Item->status) ? '是' : '否'?>
            </td>
        </tr>
        <tr>
            <td class="td1 right">是否禁止登录 :</td>
            <td>
                <?=\Admin\Model\UserModel::isAllowLogin($Item->hidden) ? '否' : '是'?>
            </td>
        </tr>
        <tr>
            <td class="td1 right">公司名称 :</td>
            <td>
                <?=$Item->company_name?>
            </td>
        </tr>
        <tr>
            <td class="td1 right">公司简称 :</td>
            <td>
                <?=$Item->company_abbr?>
            </td>
        </tr>
        <tr>
            <td class="td1 right">营业执照 :</td>
            <td>
                <img src="<?=$Item->business_license?>">
            </td>
        </tr>
        <tr>
            <td class="td1 right">税务登记证副本 :</td>
            <td>
                <img src="<?=$Item->tax_certificate?>">
            </td>
        </tr>
        <tr>
            <td class="td1 right">组织机构代码证 :</td>
            <td>
                <img src="<?=$Item->organization_code?>">
            </td>
        </tr>
        <tr>
            <td class="td1 right">当前公司状态 :</td>
            <td>
                <?=\Admin\Model\UserModel::getCompanyStatusName($Item->company_status)?>
            </td>
        </tr>
        <tr>
            <td class="td1 right">操作 :</td>
            <td>
                <label><?=\Common\Helper\Form::radio('company_status', \Admin\Model\UserModel::COMPANY_PASS)?>通过</label>
                <label><?=\Common\Helper\Form::radio('company_status', \Admin\Model\UserModel::COMPANY_FAIL)?>驳回</label>
            </td>
        </tr>
        <tr>
            <td class="td1 right"></td>
            <td><?=\Common\Helper\Form::submit('', '提交')?></td>
        </tr>

    </table>
</form>




