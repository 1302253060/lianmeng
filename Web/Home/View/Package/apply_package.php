<div class="main-content-body">

    <div class="form-area">
        <div class="register-form form-area margin-top-20">
            <div class="form-group has-label">
                <span class="label"><span class="color-required">*</span> 申请渠道个数：</span>
                <input class="input-text" data-check="required" data-check-type="number" name="num">
                <span class="error-tip error-tip-front">可申请1-100个</span>
                <span class="error-tip error-tip-1002 hide">可申请1-100个</span>
            </div>
        </div>

        <div class="register-form form-area margin-top-20">
            <div class="form-group has-label">
                <span class="label">其他要求：</span>
                <textarea class="input-textarea" name="other"></textarea>
            </div>
        </div>

        <div class="register-form form-area margin-top-20">
            <div class="form-group has-label">
                <span class="label"><span class="color-required">*</span> 推广软件：</span>
                <span style="display: inline-table;width: 500px;">
                    <?php if (!empty($aSoft)) foreach ($aSoft as $key => $val) { ?>
                        <label class="margin-left-15 apply-label-width"><input type="checkbox" name="soft" value="<?=$key?>"><?=$val?></label>
                    <?php } ?>
                </span>

            </div>
        </div>

        <div class="form-btns has-label margin-top-20">
            <a style="margin-left: 50px;" id="submitApplyBtn" class="btn btn-medium btn-wide form-submit" href="">提交</a>
            <span class="error-tip error-tip-9999 hide">申请失败，请重新提交</span>
            <span class="error-tip error-tip-1001 hide">填写信息有误，请重新输入</span>
        </div>
    </div>
</div>

