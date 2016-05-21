<div class="main-content-body basic-info">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab" href="/Home/account/index">基本信息</a>
            <a class="dt-tab" href="/Home/account/mobile">绑定手机号</a>
            <a class="dt-tab" href="/Home/account/card">绑定身份证</a>
            <?php if ((int)$User->level === \Admin\Model\UserModel::LEVEL_ONE) { ?>
            <a class="dt-tab" href="/Home/account/company">公司信息</a>
            <?php } ?>
            <a class="dt-tab chosen" href="/Home/account/install">安装场景</a>
        </div>
    </div>

    <div class="basic-info-form form-area">

        <?php
            $aUnser = unserialize($User->note_info);
        ?>
        <div class="form-group has-label">
            <span class="label">PC端安装场景：</span>
            <span class="display-info"><?=isset($aUnser['pc_install']) ? $aUnser['pc_install'] : ''?></span>
            <span class="modify-info">
                <span class="inline-block">
                    <select class="area-province selectpicker" name="pc_install" data-check="required" data-check-type="select">
                        <option value="">请选择</option>
                        <?php foreach(\Admin\Model\UserModel::$PCINSTALL as $sVal){?>
                            <option value="<?=$sVal?>"><?=$sVal?></option>
                        <?php } ?>
                    </select>
                </span>
                &nbsp;

                <span class="error-tip error-tip-front error-tip-1002 hide">请填写PC端安装场景</span>
            </span>
        </div>


        <div class="form-group has-label">
            <span class="label">PC端备注：</span>
            <span class="display-info"><?=isset($aUnser['pc_mark']) ? $aUnser['pc_mark'] : ''?></span>
            <span class="modify-info">
                <input class="input-text" name="pc_mark" value="<?=isset($aUnser['pc_mark']) ? $aUnser['pc_mark'] : ''?>">
                &nbsp;
            </span>
            <span style="color: #ff0000">(填写上量位置可以快捷打款)</span>
        </div>

        <div class="form-group has-label">
            <span class="label">APP端安装场景：</span>
            <span class="display-info"><?=isset($aUnser['app_install']) ? $aUnser['app_install'] : ''?></span>
            <span class="modify-info">
                <span class="inline-block">
                    <select class="area-province selectpicker" name="app_install" data-check="required" data-check-type="select">
                        <option value="">请选择</option>
                        <?php foreach(\Admin\Model\UserModel::$APPINSTALL as $sVal){?>
                            <option value="<?=$sVal?>"><?=$sVal?></option>
                        <?php } ?>
                    </select>
                </span>

                &nbsp;
                <span class="error-tip error-tip-front error-tip-1002 hide"></span>
            </span>
        </div>


        <div class="form-group has-label">
            <span class="label">APP端备注：</span>
            <span class="display-info"><?=isset($aUnser['app_mark']) ? $aUnser['app_mark'] : ''?></span>
            <span class="modify-info">
                <input class="input-text" name="app_mark" value="<?=isset($aUnser['app_mark']) ? $aUnser['app_mark'] : ''?>">
                &nbsp;
            </span>
            <span style="color: #ff0000">(填写上量位置可以快捷打款)</span>
        </div>

        <div class="form-btns">
            <span class="display-info">
                <a class="btn btn-medium" href="" data-switch="modify" style="margin-left: 45px;">修改资料</a>
            </span>
            <span class="modify-info">
                <button id="saveInstallBtn" class="btn btn-medium form-submit" style="margin-left: 45px;">保存</button>
                &nbsp;
                <a class="btn btn-medium btn-cancel" href="" data-switch="display">取消</a>
                &nbsp;
                <span class="error-tip error-tip-1003 hide">修改失败，请重新操作</span>
            </span>
        </div>
    </div>
</div>
