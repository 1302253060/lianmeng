<div class="main-content-body exchange-niubi-page">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab chosen" href="/Home/money/">兑换流量</a>
            <a class="dt-tab" href="/Home/money/list_detail">收支明细</a>
            <a class="dt-tab" href="/Home/money/salary">提现记录</a>
        </div>
    </div>

    <div class="exchange-form form-area">
        <div class="form-group size-medium">账户余额：<span id="accountRemain" class="color-strong"><?=number_format($point)?></span> 流量</div>
        <input class="input-mobile" type="hidden" value="<?=$User->mobile?>">
        <div class="form-group has-label error-tip error-tip-1001 error-tip-3002 error-tip-3003 hide">系统繁忙，请稍候再试！</div>
        <div class="form-group has-label error-tip error-tip-2001 hide">您已被冻结</div>
        <div class="form-group has-label error-tip error-tip-2004 hide"></div>
        <div class="form-group has-label error-tip error-tip-2999 hide">您没有流量兑换权限</div>
        <div class="form-group has-label error-tip error-tip-general hide"></div>
        <div class="form-group has-label exchange-confirm-tip">
            <div class="well well-default hidden">兑换流量数：<strong class="point-num size-base color-blue-b"></strong></div>
        </div>
        <div class="form-group has-label relative" style="margin-bottom: 15px;">
            <span class="label">兑换流量</span>
            <input id="inputPoint" class="input-text input-text-xnarrow text-right" name="point" data-check="required" data-check-type="number_positive"> 000个
            <span class="error-tip error-tip-front hide">请填写正确的流量数</span>
            <span class="error-tip error-tip-remain-a hide">账户余额小于1000流量无法兑换，请加油推广哦</span>
            <span class="error-tip error-tip-remain-b hide">兑换流量数额大于账户余额请重新输入</span>
            <span class="error-tip error-tip-3001 hide">您的账户余额不足</span>
            <span class="error-tip error-tip-2002 hide"></span>
        </div>
        <div class="form-group has-label" style="margin-bottom: 15px;">
            <span class="label">短信验证</span>
            <input class="input-text input-text-xnarrow text-center" name="captcha" data-check="required" data-check-type="verify_code">
            &nbsp;
            <a class="btn btn-medium btn-captcha <?php if(!$bCheckAuth) echo 'btn-disabled';?>" href="" data-get-code="sms">获取验证码</a>
            <span class="error-tip error-tip-front error-tip-1003 hide">请填写正确的验证码</span>
            <div class="well well-default get-code-well margin-top-10 hide">

            </div>
            <div class="mobile-number" style="display: none;">11111111</div>
        </div>
        <div class="form-btns">
            <a id="exchangeLLBtn" class="btn btn-big form-submit <?php if(!$bCheckAuth) echo 'btn-disabled';?>" href="" data-loading-text="兑换中...">立即兑换</a>
            <?php if (\Admin\Model\UserModel::isFreeze($User->status)) { ?>
                <span style="color: #ff0000">账号冻结，不能提现，请联系管理员。</span>
            <?php } ?>
        </div>
    </div>

    <div class="get-rule">
        <p>领取规则</p>
        <p>
            1. 绑定身份证账户后才可以兑换
            &nbsp;&nbsp;&nbsp;
            <?php if(\Admin\Model\UserModel::isIdcardOk($User->idcard_ok)):?>
                &nbsp;
                绑定身份证：<?=substr($User->idcard,0,3).'***********'.substr($User->idcard, -4,4);?>
            <?php else:?>
                绑定身份证：未绑定
                &nbsp;
                <a href="/Home/account/card">立即绑定&gt;</a>
            <?php endif;?>
        </p>
        <p>
            2. 绑定银行卡后才可以兑换。
            <?php if($User->subbranch && $User->bankcard && $User->payee) :?>
                &nbsp;
                绑定银行卡：<?=substr($User->bankcard,0,3).'***********'.substr($User->bankcard, -4,4);?>
            <?php else:?>
                绑定银行卡：未绑定
                &nbsp;
                <a href="/Home/account/">立即绑定&gt;</a>
            <?php endif;?>
        </p>
        <p>3. 每次兑换，最少兑换1000流量。</p>
        <p>4. 兑现申请提交成功后5个工作日内完成审核发放；周末、国家法定假日顺延至工作日进行。</p>
    </div>
</div>
<input type="hidden" value="<?=$bSelfHelpPerm?>"/>

<div style="display: none;">
    <div id="exchangeSuccessPopup">
        <div class="size-large text-center">
            兑换申请成功！
        </div>
        <p class="text-center line-height-2 margin-top-15">
            本次兑换流量：<span class="point-num">1000</span>个<br>
            兑现申请提交成功后5个工作日内完成审核发放；<br>周末、国家法定假日顺延至工作日进行~
        </p>
        <div class="text-center margin-top-15">
            <a class="btn btn-medium" href="#" target="_blank">关闭</a>
        </div>
    </div>
</div>
