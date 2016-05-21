<!DOCTYPE html>
<html>
<include file="./Web/Home/View/__Widget__/Head.php" />
<body>
<div id="page">
    <div class="register-page">
        <div class="layout register-page-top">
            <a href="/"><img style="margin-top: 27px;" src="/Public/statics/img/logo.png" width="144" height="38"></a>
            <p>
                已经注册过，现在登录
                <a href="/"><img src="/Public/statics/img/register_log_button.png"></a>
            </p>

        </div>

    </div>

    <div class="register-page-main layout">
        <div class="layout">
            <div class="register-page-main-top">
                <h2>找回密码</h2>
            </div>
            <div class="three-steps-indicator" style="margin-top: 10px;">
                <div class="step step-a active">1.输入手机号</div>
                <div class="step step-b">2.验证身份</div>
                <div class="step step-c">3.重置密码</div>
            </div>

            <?php /* 第1步 */ ?>
            <div class="change-step-a">
                <p class="margin-bottom-20">通过手机号找回</p>
                <div class="form-area mobile-auth-form">
                    <div class="form-group has-label">
                        <span class="label" style="margin-left: -75px;">手机号</span>
                        <input class="input-text input-mobile-a" id="step0_mobile" data-check="required" data-check-type="mobile">
                        <span class="error-tip error-tip-front error-tip-5004 hide">请填写正确的手机号</span>
                        <span class="error-tip error-tip-8001 hide">该手机号没有注册过平台</span>
                    </div>

                    <div class="form-group has-label">
                        <span class="label" style="margin-left: -75px;">验证码</span>
                        <input style="width: 150px;" class="input-text input-code" data-check="required" data-check-type="code">
                        &nbsp;
                        <img id="img-code" style="vertical-align: middle;cursor: pointer;" class="img-code" src="/Home/code/index" width="94" height="37" onclick="reImg();">
                        <span class="error-tip error-tip-front hide">请填写正确的验证码</span>
                        <span class="error-tip error-tip-5064 hide">请填写正确的验证码</span>
                    </div>
                    <div class="form-btns has-label margin-top-20">
                        <a id="changeStepABtn" class="btn btn-big form-submit" href="">确定</a>
                    </div>
                </div>
            </div>

            <?php /* 第2步 */ ?>
            <div class="change-step-b hide">
                <div class="form-area mobile-auth-form">
                    <input class="input-mobile" type="hidden" value="">
                    <div class="form-group has-label error-tip error-tip-1000 error-tip-1001 hide">系统繁忙，请稍候再试！</div>
                    <div class="form-group has-label">
                        <span class="label" style="margin-left: -75px;">手机号</span>
                        <span id="changeStepMobile"></span>
                    </div>

                    <div class="form-group has-label">
                        <span class="label" style="margin-left: -75px;">验证码</span>
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
                <div class="change-step-c-one">
                    <div class="form-area mobile-auth-form">
                        <input class="input-mobile-c" type="hidden" value="">
                        <div class="form-group has-label error-tip error-tip-1000 error-tip-1001 hide">系统繁忙，请稍候再试！</div>

                        <div class="form-group has-label">
                            <span class="label" style="margin-left: -75px;">新密码</span>
                            <input class="input-text input-password" type="password" data-check="required" data-check-type="password" name="password">
                            <span class="error-tip error-tip-front error-tip-9001 hide">请填写正确的密码（请填写6位密码）</span>
                            <span class="error-tip error-tip-9001 hide">请填写正确的信息</span>
                            <span class="error-tip error-tip-9003 error-tip-1000 hide">非法操作</span>
                        </div>

                        <div class="form-group has-label">
                            <span class="label" style="margin-left: -75px;">确认密码</span>
                            <input class="input-text input-confirm-password" type="password" data-check="required" data-check-type="password" name="confirm_password">
                            <span class="error-tip error-tip-front hide">请填写正确的密码（请填写6-30位密码）</span>
                            <span class="error-tip error-tip-9002 hide">两次输入的密码不一致，请重新输入</span>
                        </div>

                        <div class="form-btns has-label margin-top-20">
                            <a id="changeStepCCtn" class="btn btn-big form-submit" href="">确定</a>
                        </div>
                    </div>
                </div>
                <div class="change-step-c-two hide">
                    <p>重置密码成功，<a href="/">请登录</a></p>
                </div>

            </div>

        </div>
    </div>

    <include file="./Web/Home/View/__Widget__/Foot.php" />
</div>
</body>
</html>
<script type="text/javascript">
    function reImg(){
        var img = document.getElementById("img-code");
        img.src = "/Home/code/index?rnd=" + Math.random();
    }
</script>
<script type="text/javascript" src="/Public/statics/js/app/user_forget.js"></script>