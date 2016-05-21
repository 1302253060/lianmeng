<div class="main-content-body real-name-page">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab" href="/Home/account/index">基本信息</a>
            <a class="dt-tab" href="/Home/account/mobile">绑定手机号</a>
            <a class="dt-tab" href="/Home/account/card">绑定身份证</a>
            <a class="dt-tab chosen" href="/Home/account/company">公司信息</a>
            <a class="dt-tab" href="/Home/account/install">安装场景</a>
        </div>
    </div>

    <?php if(in_array((int)$User->company_status, array(\Admin\Model\UserModel::COMPANY_NO, \Admin\Model\UserModel::COMPANY_FAIL))):?>
        <div id="realNameForm" class="form-area real-name-form" <?php if((int)$User->company_status == \Admin\Model\UserModel::COMPANY_FAIL): ?> style="display: none;" <?php endif;?> >
            <input type="hidden" name="uid" value="<?=$User->id?>">
            <p>请填写公司真实信息，一经填写无法修改</p>
            <div class="form-group has-label error-tip error-tip-4 hide">您的账号已经变更</div>
            <div class="form-group has-label error-tip error-tip-6 hide"></div>
            <div class="form-group has-label error-tip error-tip-8 error-tip-10 hide">系统繁忙，请稍候再试！</div>
            <div class="form-group has-label error-tip error-tip-4001 hide">你已经通过验证</div>
            <div class="form-group has-label error-tip error-tip-4002 hide">信息填写不完整，请重新填写</div>
            <div class="form-group has-label error-tip error-tip-4003 hide">你已经提交过认证，请等待审核</div>
            <div class="form-group has-label">
                <span class="label" style="margin-left: -140px;">公司名称</span>
                <input class="input-text" name="company_name" data-check="required" data-check-type="address" value="<?=isset($user_idcard_name) ? $user_idcard_name : '';?>">
                <span class="error-tip error-tip-front error-tip-1 hide">请填写公司名称</span>
            </div>
            <div class="form-group has-label">
                <span class="label" style="margin-left: -140px;">公司简称</span>
                <input class="input-text" name="company_abbr" data-check="required" data-check-type="address" value="<?=isset($user_idcard) ? $user_idcard : '';?>">
                <span class="error-tip error-tip-front error-tip-2 error-tip-3 hide">请填写公司简称</span>
                <span class="error-tip error-tip-5 hide">该身份证已被使用</span>
            </div>
            <div class="form-group has-label">
                <span class="label-long">营业执照：</span>
                &nbsp;
                <span class="error-tip error-tip-front hide">请上传营业执照</span>
                <div class="upload-queue clearfix margin-bottom-20">
                    <div class="upload-item">
                        <div class="upload-item-inner">
                            <a class="remove-btn force-hide" href=""></a>
                            <input class="upload-img-info idcard-img-a-info" type="hidden" value="">
                            <span class="upload-cross">+</span>
                            <img class="upload-img-thumbnail idcard-img-a hide" src="" data-check="required" data-check-type="image">
                            <input id="uploadFront" class="upload-input" type="file" accept="image/*" name="idcard_img">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group has-label">
                <span class="label-long">税务登记证副本：</span>
                &nbsp;
                <span class="error-tip error-tip-front hide">请上传税务登记证副本</span>
                <div class="upload-queue clearfix margin-bottom-20">
                    <div class="upload-item">
                        <div class="upload-item-inner">
                            <a class="remove-btn force-hide" href=""></a>
                            <input class="upload-img-info idcard-img-b-info" type="hidden"  value="">
                            <span class="upload-cross">+</span>
                            <img class="upload-img-thumbnail idcard-img-b hide" src="" data-check="required" data-check-type="image">
                            <input id="uploadBack" class="upload-input" type="file" accept="image/*" name="idcard_img">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group has-label">
                <span class="label-long">组织机构代码证：</span>
                &nbsp;
                <span class="error-tip error-tip-front hide">请上传组织机构代码证</span>
                <div class="upload-queue clearfix margin-bottom-20">
                    <div class="upload-item">
                        <div class="upload-item-inner">
                            <a class="remove-btn force-hide" href=""></a>
                            <input class="upload-img-info idcard-img-b-info" type="hidden"  value="">
                            <span class="upload-cross">+</span>
                            <img class="upload-img-thumbnail idcard-img-c hide" src="" data-check="required" data-check-type="image">
                            <input id="uploadBackZuzhi" class="upload-input" type="file" accept="image/*" name="idcard_img">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-btns has-label">
                <a id="submitBtn" class="btn btn-medium form-submit" href="">提交</a>
            </div>
        </div>
    <?php endif;?>

    <?php if((int)$User->company_status === \Admin\Model\UserModel::COMPANY_REVIEW):?>
        <div id="realNameProcessing" style="display: black;">
            <p>实名认证申请已提交</p>
            <p>我们将尽快处理您的申请，处理一般需要3-5个工作日，请耐心等待！</p>
            <p class="has-label margin-top-10"><span class="label name">公司名称：</span><?=$User->company_name?></p>
            <p class="has-label"><span class="label idcard">公司简称：</span><?=$User->company_abbr?></p>
            <p class="has-label"><span class="label idcard">营业执照：</span><img src="<?=$User->business_license?>" height="150"></p>
            <p class="has-label"><span class="label idcard">税务登记证副本：</span><img src="<?=$User->tax_certificate?>" height="150"></p>
            <p class="has-label"><span class="label idcard">组织机构代码证：</span><img src="<?=$User->organization_code?>" height="150"></p>
        </div>
    <?php endif;?>

    <?php if((int)$User->company_status === \Admin\Model\UserModel::COMPANY_FAIL):?>
        <div id="realNameFail" style="display: black;">
            <p>很抱歉！实名认证申请审核不通过</p>
            <?php $aSerialize = unserialize($User->note_info); ?>
            <p class="margin-top-10">原因为：<?=isset($aSerialize['company_reason_fail']) ? $aSerialize['company_reason_fail'] . '，' : ''?>
                <a href="javascript:;" id="appeal_again">再次申请></a></p>
        </div>
    <?php endif;?>

    <?php if((int)$User->company_status === \Admin\Model\UserModel::COMPANY_PASS):?>
        <div id="realNameSuccess" style="display: black;">
            <p>恭喜您！公司认证申请已通过审核</p>
            <p class="has-label margin-top-10"><span class="label name">公司名称：</span><?=$User->company_name?></p>
            <p class="has-label"><span class="label idcard">公司简称：</span><?=$User->company_abbr?></p>
            <p class="has-label"><span class="label idcard">营业执照：</span><img src="<?=$User->business_license?>" height="150"></p>
            <p class="has-label"><span class="label idcard">税务登记证副本：</span><img src="<?=$User->tax_certificate?>" height="150"></p>
            <p class="has-label"><span class="label idcard">组织机构代码证：</span><img src="<?=$User->organization_code?>" height="150"></p>
        </div>
    <?php endif;?>
</div>

<div id="popupConfirmSubmit" class="dialog-content">
    <p class="size-big margin-bottom-10">
        请再次确认信息是否填写正确
    </p>
    <p class="margin-bottom-10">
        公司名称：<span id="popupRealName"></span><br>
        公司简称：<span id="popupIdCard"></span>
    </p>
</div>

<link rel="stylesheet" type="text/css" href="/Public/statics/vendor/fancybox/jquery.fancybox.css">
<link rel="stylesheet" type="text/css" href="/Public/statics/vendor/fileupload/jquery.fileupload.css">
<script type="text/javascript" src="/Public/statics/vendor/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="/Public/statics/vendor/fileupload/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/Public/statics/vendor/fileupload/jquery.fileupload.js"></script>