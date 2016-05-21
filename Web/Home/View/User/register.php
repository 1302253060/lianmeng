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
                <h2>用户注册</h2>
            </div>
            <div class="register-form form-area">
                <div class="register-form form-area margin-top-20">
                    <div class="form-group has-label">
                        <span class="label"><span class="color-required">*</span> 真实姓名：</span>
                        <input class="input-text" data-check="required" data-check-type="real_name" name="name">
                        <span class="error-tip error-tip-front hide">请填写真实姓名（2至4个汉字）</span>
                        <span class="error-tip error-tip-5012 hide">用户名不能超过64个字</span>
                    </div>
                </div>

                <div class="register-form form-area margin-top-20">
                    <div class="form-group has-label">
                        <span class="label"><span class="color-required">*</span> 密码：</span>
                        <input class="input-text" type="password" data-check="required" data-check-type="password" name="password">
                        <span class="error-tip error-tip-front hide">请填写正确的密码（请填写6位密码）</span>
                    </div>
                </div>

                <div class="register-form form-area margin-top-20">
                    <div class="form-group has-label">
                        <span class="label"><span class="color-required">*</span> 确认密码：</span>
                        <input class="input-text" type="password" data-check="required" data-check-type="password" name="confirm_password">
                        <span class="error-tip error-tip-front hide">请填写正确的密码（请填写6-30位密码）</span>
                        <span class="error-tip error-tip-5042 hide">两次输入的密码不一致，请重新输入</span>
                    </div>
                </div>

                <div class="form-group has-label margin-top-20">
                    <span class="label"><span class="color-required">*</span> 所在城市：</span>
                    <span class="inline-block" data-area="true">
                        <select class="area-province selectpicker" name="province" data-check="required" data-check-type="select">
                            <option value="">请选择</option>
                        </select>
                        <select class="area-city selectpicker" name="city" data-check="required" data-check-type="select">
                            <option value="">请选择</option>
                        </select>
                        <select class="area-county selectpicker" name="county" data-check="required" data-check-type="select">
                            <option value="">请选择</option>
                        </select>
                    </span>
                    <script type="text/javascript">
                        initSelect();
                    </script>
                    <span class="error-tip error-tip-front error-tip-5009 hide">请选择所在城市</span>
                </div>

                <div class="register-form form-area margin-top-20">
                    <div class="form-group has-label">
                        <span class="label"><span class="color-required">*</span> 详细地址：</span>
                        <input class="input-text" data-check="required" data-check-type="address" name="address">
                        <span class="error-tip error-tip-front hide">请填写详细地址</span>
                    </div>
                </div>

                <div class="register-form form-area margin-top-20">
                    <div class="form-group has-label">
                        <span class="label"><span class="color-required">*</span> QQ：</span>
                        <input class="input-text" data-check="required" data-check-type="qq" name="qq">
                        <span class="error-tip error-tip-front hide">请填写正确的QQ号</span>
                    </div>
                </div>

                <div class="register-form form-area margin-top-20">
                    <div class="form-group has-label">
                        <span class="label"><span class="color-required">*</span> 邮箱：</span>
                        <input class="input-text" data-check="required" data-check-type="email" name="email">
                        <span class="error-tip error-tip-front hide">请填写正确的邮箱</span>
                    </div>
                </div>

                <div class="form-group has-label margin-top-20">
                    <span class="label"><span class="color-required">*</span> 注册类型：</span>
                    <label><input type="radio" name="reg_type" value="1" checked="checked">公司</label>
                    <label><input type="radio" name="reg_type" value="2">个人</label>
                </div>

                <div class="register-form form-area margin-top-20">
                    <div class="form-group has-label">
                        <span class="label"><span class="color-required"></span> 邀请码：</span>
                        <input class="input-text" name="inv_code" data-check="optional" data-check-type="char_or_number">
                        <span class="error-tip error-tip-front hide">请填写正确的邀请码</span>
                        <span class="error-tip error-tip-2001 hide">请填写正确的邀请码</span>
                        <span class="error-tip error-tip-2002 error-tip-2003 hide">此邀请码失效，请联系客服重发邀请码</span>
                        <span class="error-tip error-tip-2004 hide">邀请码输入错误，请重新输入</span>
                    </div>
                </div>

                <div class="register-form form-area margin-top-20">
                    <div class="form-group has-label">
                        <span class="label"><span class="color-required">*</span> 手机号：</span>
                        <input class="input-text input-mobile" data-check="required" data-check-type="mobile" name="mobile">
                        <span class="error-tip error-tip-front hide">请填写正确的手机号</span>
                        <span class="error-tip error-tip-5005 hide">手机号已绑定且验证!</span>
                    </div>
                </div>

                <div class="register-form form-area margin-top-20">
                    <div class="form-group has-label">
                        <span class="label"><span class="color-required">*</span> 图片验证码：</span>
                        <input style="width: 150px;" class="input-text" data-check="required" data-check-type="code" name="code">
                        <img id="img-code" style="vertical-align: middle;cursor: pointer;" class="img-code" src="/Home/code/index" width="94" height="37" onclick="reImg();">
                        <span class="error-tip error-tip-front hide">请填写正确的验证码</span>
                        <span class="error-tip error-tip-5064 hide">图片验证码填写错误</span>
                    </div>
                </div>


                <div class="form-group has-label margin-top-20">
                    <span class="label"><span class="color-required">*</span> 手机验证码：</span>
                    <input class="input-text input-captcha" name="captcha" data-check="required" data-check-type="verify_code">
                    &nbsp;
                    <a class="btn btn-medium btn-captcha" href="" data-get-code="sms">获取验证码</a>
                    <span class="error-tip error-tip-front hide error-tip-1009 error-tip-1010 error-tip-5006 hide">请填写正确的验证码</span>
                </div>



                <div class="form-btns has-label margin-top-20">
                    <a style="margin-left: 50px;" id="submitRegBtn" class="btn btn-medium btn-wide form-submit" href="">提交</a>
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
<script type="text/javascript" src="/Public/statics/js/app/user_register.js"></script>