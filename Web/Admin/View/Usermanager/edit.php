<style>
    label {
        display: inline-block;
        margin-right: 10px;
    }
</style>
<form action="/admin/usermanager/edit_post" method="post" class="form-horizontal" onsubmit="return LianMeng.form_post(this, '/admin/usermanager/')">
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
            <td><?=\Common\Helper\Form::input('name', $Item->name)?></td>
        </tr>
        <tr>
            <td class="td1 right">手机号 :</td>
            <td><?=\Common\Helper\Form::input('mobile', $Item->mobile)?></td>
        </tr>
        <tr>
            <td class="td1 right">身份证 :</td>
            <td><?=\Common\Helper\Form::input('idcard', $Item->idcard)?></td>
        </tr>
        <tr>
            <td class="td1 right">身份证认证 :</td>
            <td>
                <label><?=\Common\Helper\Form::radio('idcard_ok', '1', \Admin\Model\UserModel::isIdcardOk($Item->idcard_ok) ? true : false)?>是</label>
                <label><?=\Common\Helper\Form::radio('idcard_ok', '0', \Admin\Model\UserModel::isIdcardOk($Item->idcard_ok) ? false : true)?>否</label>
            </td>
        </tr>
        <tr>
            <td class="td1 right">QQ :</td>
            <td><?=\Common\Helper\Form::input('qq', $Item->qq)?></td>
        </tr>
        <tr>
            <td class="td1 right">Email :</td>
            <td><?=\Common\Helper\Form::input('email', $Item->email)?></td>
        </tr>
        <tr>
            <td class="td1 right">通讯地址 :</td>
            <td><?=\Common\Helper\Form::input('address', $Item->address)?></td>
        </tr>
        <tr>
            <td class="td1 right">是否禁止登录 :</td>
            <td>
                <label><?=\Common\Helper\Form::radio('hidden', '1', \Admin\Model\UserModel::isAllowLogin($Item->hidden) ? false : true)?>是</label>
                <label><?=\Common\Helper\Form::radio('hidden', '0', \Admin\Model\UserModel::isAllowLogin($Item->hidden) ? true : false)?>否</label>
            </td>
        </tr>
        <tr>
            <td class="td1 right"></td>
            <td><?=\Common\Helper\Form::submit('', '提交')?></td>
        </tr>

    </table>
</form>




