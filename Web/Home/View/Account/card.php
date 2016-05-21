<div class="main-content-body identity-auth">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab" href="/Home/account/index">基本信息</a>
            <a class="dt-tab" href="/Home/account/mobile">绑定手机号</a>
            <a class="dt-tab chosen" href="/Home/account/card">绑定身份证</a>
            <?php if ((int)$User->level === \Admin\Model\UserModel::LEVEL_ONE) { ?>
            <a class="dt-tab" href="/Home/account/company">公司信息</a>
            <?php } ?>
            <a class="dt-tab" href="/Home/account/install">安装场景</a>
        </div>
    </div>

    <form method="post">
        <div class="form-area identity-auth-form margin-top-10">
            <input type="hidden" name="uid" value="<?=$User->id?>">
            <div class="form-group has-label error-tip error-tip-4 hide">您的账号已经变更</div>
            <div class="form-group has-label error-tip error-tip-6 hide"></div>
            <div class="form-group has-label error-tip error-tip-7 hide">身份证认证失败！</div>
            <p>请填写本人真实信息，一经填写无法修改</p>
            <div class="form-group has-label">
                <span class="label" style="margin-left: -130px;">真实姓名</span>
                <input class="input-text" name="name" data-check="required" data-check-type="real_name">
                <span class="error-tip error-tip-front error-tip-1 hide">请填写真实姓名</span>
            </div>
            <div class="form-group has-label">
                <span class="label" style="margin-left: -130px;">身份证号</span>
                <input class="input-text" name="idcard" data-check="required" data-check-type="idcard">
                <span class="error-tip error-tip-front error-tip-2 error-tip-3 hide">请填写正确的身份证号</span>
                <span class="error-tip error-tip-5 hide">该身份证已被使用</span>
            </div>
            <p class="hide">验证错误，请仔细检查您的身份证信息。</p>
            <div class="form-btns has-label">
                <a id="authIdentityBtn" class="btn btn-big form-submit" href="">立即认证</a>
                <input type="hidden" name="uid" value="<?= $User->id ?>">
            </div>
        </div>
    </form>
</div>
