<div class="main-content-body basic-info">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab chosen" href="/Home/account/index">基本信息</a>
            <a class="dt-tab" href="/Home/account/mobile">绑定手机号</a>
            <a class="dt-tab" href="/Home/account/card">绑定身份证</a>
            <?php if ((int)$User->level === \Admin\Model\UserModel::LEVEL_ONE) { ?>
            <a class="dt-tab" href="/Home/account/company">公司信息</a>
            <?php } ?>
            <a class="dt-tab" href="/Home/account/install">安装场景</a>
        </div>
    </div>

    <p class="margin-bottom-15">请填写您的真实信息，以便平台在有需要时能第一时间联系到您，我们承诺对您的个人信息进行严格保密</p>

    <div class="basic-info-form form-area">
        <div class="form-group has-label">
            <span class="label">姓名：</span>
            <?php echo $User->name;?>
        </div>
        <div class="form-group has-label">
            <span class="label">渠道号：</span>
            <?php echo $User->id ?>
        </div>
        <div class="form-group has-label">
            <span class="label">手机号：</span>
            <?php if(trim($User->mobile)):?>
                <?=substr($User->mobile,0,3).'******'.substr($User->mobile,9)?>
                &nbsp;
                <a class="modifyUserInfo" id="show_bind_mobile" href="/Home/account/mobile" >更改手机号</a>
            <?php else:?>
                -
                &nbsp;
                <a class="modifyUserInfo" id="show_bind_mobile" href="/Home/account/mobile" >绑定手机号</a>

            <?php endif;?>
        </div>
        <div class="form-group has-label">
            <span class="label">身份证号：</span>
            <?php if(trim($User->idcard) && \Admin\Model\UserModel::isIdcardOk($User->idcard_ok)):?>
                <?=substr($User->idcard,0,3).'******'.substr($User->idcard,9)?>
                &nbsp;
            <?php else:?>
                -
                &nbsp;
                <a class="modifyUserInfo" id="show_bind_mobile" href="/Home/account/card" >绑定身份证号</a>

            <?php endif;?>
        </div>
        <div class="form-group has-label">
            <span class="label">QQ：</span>
            <span class="display-info"><?php echo $User->qq;?></span>
            <span class="modify-info">
                <input class="input-text" name="qq" value="<?php echo $User->qq;?>" data-check="required" data-check-type="qq">
                &nbsp;
                <span class="error-tip error-tip-front error-tip-1001 hide">请填写正确的QQ号</span>
            </span>
        </div>

        <div class="form-group has-label">
            <span class="label">邮箱：</span>
            <span class="display-info"><?php echo $User->email;?></span>
            <span class="modify-info">
                <input class="input-text" name="email" value="<?php echo $User->email;?>" data-check="required" data-check-type="email">
                &nbsp;
                <span class="error-tip error-tip-front error-tip-1004 hide">请填写正确的邮箱</span>
            </span>
        </div>


        <div class="form-group has-label">
            <span class="label">银行账号：</span>
            <span class="display-info"><?php echo $User->bankcard;?></span>
            <span class="modify-info">
                <input class="input-text" name="bankcard" value="<?php echo $User->bankcard;?>" data-check="required" data-check-type="number">
                &nbsp;
                <span class="error-tip error-tip-front error-tip-1007 hide">请填写正确的银行账号</span>
            </span>
        </div>

        <div class="form-group has-label">
            <span class="label">收款人：</span>
            <span class="display-info"><?php echo $User->payee;?></span>
            <span class="modify-info">
                <input class="input-text" name="payee" value="<?php echo $User->payee;?>" data-check="required" data-check-type="address">
                &nbsp;
                <span class="error-tip error-tip-front error-tip-1006 hide">请填写正确的收款人信息</span>
            </span>
        </div>

        <div class="form-group has-label">
            <span class="label">开户行：</span>
            <span class="display-info"><?php echo $User->subbranch;?></span>
            <span class="modify-info">
                <input class="input-text" name="subbranch" value="<?php echo $User->subbranch;?>" data-check="required" data-check-type="address">
                &nbsp;
                <span class="error-tip error-tip-front error-tip-1005 hide">请填写正确的开户行</span>
            </span>
        </div>

        <div class="form-group has-label">
            <span class="label">省份城市：</span>
            <span class="display-info"><?php echo $User->province.' '. $User->city.' '.$User->county?></span>
            <span class="modify-info">
                <span class="inline-block" data-area="true" data-province="<?=$User->province?>" data-city="<?=$User->city?>" data-county="<?=$User->county?>">
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
                &nbsp;
                <span class="error-tip error-tip-front error-tip-1002 hide">请选择省份、城市、区县</span>
            </span>
        </div>
        <div class="form-group has-label">
            <span class="label">通讯地址：</span>
            <span class="display-info"><?=$User->address; ?></span>
            <span class="modify-info">
                <input class="input-text" name="address" value="<?=$User->address;?>" data-check="required" data-check-type="address">
                &nbsp;
                <span class="error-tip error-tip-front hide">请填写正确的通讯地址</span>
            </span>
        </div>
        <div class="form-group has-label">
            <span class="label">注册时间：</span>
            <?=substr($User->create_time, 0, 10);?>
        </div>
        <div class="form-btns">
            <span class="display-info">
                <a class="btn btn-medium" href="" data-switch="modify" style="margin-left: 45px;">修改资料</a>
            </span>
            <span class="modify-info">
                <button id="saveUserInfoBtn" class="btn btn-medium form-submit" style="margin-left: 45px;">保存</button>
                &nbsp;
                <a class="btn btn-medium btn-cancel" href="" data-switch="display">取消</a>
                &nbsp;
                <span class="error-tip error-tip-1003 hide">修改失败，请重新操作</span>
                <span class="color-warning">提示：如果您需要修改姓名，请联系在线客服</span>
            </span>
        </div>
    </div>
</div>
