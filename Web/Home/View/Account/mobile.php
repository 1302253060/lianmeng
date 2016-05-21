<div class="main-content-body mobile-auth-page">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab" href="/Home/account/index">基本信息</a>
            <a class="dt-tab chosen" href="/Home/account/mobile">绑定手机号</a>
            <a class="dt-tab" href="/Home/account/card">绑定身份证</a>
            <?php if ((int)$User->level === \Admin\Model\UserModel::LEVEL_ONE) { ?>
            <a class="dt-tab" href="/Home/account/company">公司信息</a>
            <?php } ?>
            <a class="dt-tab" href="/Home/account/install">安装场景</a>
        </div>
    </div>


    <div class="three-steps-indicator">
        <div class="step step-a active">1.验证已绑定的手机</div>
        <div class="step step-b">2.验证新手机</div>
        <div class="step step-c">3.绑定成功</div>
    </div>

    <?php /* 第1步 */ ?>
    <div class="change-step-a">
        <p class="margin-bottom-20">请用绑定手机：<?=substr_replace($User->mobile, '******', 3, 6);?>获取验证短信，如您因手机丢失等原因无法接收验证码，请致电客服：000-000-0000</p>
        <div class="form-area mobile-auth-form">
            <input class="input-mobile" type="hidden" value="<?=$User->mobile?>">
            <div class="form-group has-label error-tip error-tip-1000 hide">请先登录</div>

            <div class="form-group has-label">
                <span class="label" style="margin-left: -125px;">验证码</span>
                <input class="input-text input-captcha" data-check="required" data-check-type="verify_code">
                &nbsp;
                <a class="btn btn-medium btn-captcha" href="" data-get-code="sms">获取验证码</a>
                <span class="error-tip error-tip-front error-tip-1009 error-tip-1010 hide">请填写正确的验证码</span>
            </div>
            <div class="form-btns has-label margin-top-20">
                <a id="changeStepABtn" class="btn btn-big form-submit" href="">确定</a>
            </div>
        </div>
    </div>

    <?php /* 第2步 */ ?>
    <div class="change-step-b hide">
        <div class="form-area mobile-auth-form">
            <input type="hidden" name="old_mobile" value="<?=$User->mobile?>">
            <div class="form-group has-label error-tip error-tip-1000 error-tip-1001 hide">系统繁忙，请稍候再试！</div>
            <div class="form-group has-label error-tip error-tip-1006 error-tip-1008 hide">请先登录</div>
            <div class="form-group has-label">
                <span class="label" style="margin-left: -125px;">手机号</span>
                <input class="input-text input-mobile" id="step0_mobile" data-check="required" data-check-type="mobile">
                <span class="error-tip error-tip-front error-tip-1003 hide">请填写正确的手机号</span>
                <span class="error-tip error-tip-1007 hide">手机号已被其他账号绑定</span>
            </div>
            <div class="form-group has-label">
                <span class="label" style="margin-left: -125px;">验证码</span>
                <input class="input-text input-captcha" data-check="required" data-check-type="verify_code">
                &nbsp;
                <a class="btn btn-medium btn-captcha" href="" data-get-code="sms">获取验证码</a>
                <span class="error-tip error-tip-front error-tip-1009 error-tip-1010 hide">请填写正确的验证码</span>
            </div>
            <div class="form-btns has-label margin-top-20">
                <a id="changeStepBBtn" class="btn btn-big form-submit" href="">确定</a>
            </div>
        </div>
    </div>

    <?php /* 第3步 */ ?>
    <div class="change-step-c hide">
        <p>绑定成功！</p>
        <p class="margin-top-10" style="padding-left: 24px;">绑定手机<span id="stepCMobile"></span></p>
    </div>



</div>
