<div class="main-content-body basic-info">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab chosen" href="/Home/package/index">已审核</a>
            <a class="dt-tab" href="/Home/package/apply_list">未审核</a>
            <a class="dt-tab" href="/Home/package/cancel_list">审核未通过</a>
        </div>
    </div>


    <div class="basic-info-form form-area">

        <div class="form-group has-label">
            <span class="label">渠道号：</span>
            <?php echo $MUser->id ?>
        </div>
        <div class="form-group has-label">
            <span class="label">姓名：</span>
            <span class="display-info"><?=$MUser->name; ?></span>
            <span class="modify-info">
                <input class="input-text" name="name" value="<?=$MUser->name;?>" data-check-type="address">
                &nbsp;
                <span class="error-tip error-tip-front hide">请填写正确的姓名</span>
            </span>
        </div>
        <div class="form-group has-label">
            <span class="label">备注：</span>
            <?php $aUnSer = unserialize($MUser->note_info); ?>
            <span class="display-info"><?=isset($aUnSer['mark']) ? $aUnSer['mark'] : '';?></span>
            <span class="modify-info">
                <textarea name="mark" cols="50" rows="7"><?=isset($aUnSer['mark']) ? $aUnSer['mark'] : '';?></textarea>
                <input type="hidden" name="channel_id" value="<?=$MUser->id?>">
                &nbsp;
                <span class="error-tip error-tip-front hide">请填写正确的通讯地址</span>
            </span>
        </div>

        <div class="form-btns">
            <span class="display-info">
                <a class="btn btn-medium" href="" data-switch="modify" style="margin-left: 45px;">修改</a>
            </span>
            <span class="modify-info">
                <button id="saveUserInfoBtn" class="btn btn-medium form-submit" style="margin-left: 45px;">保存</button>
                &nbsp;
                <a class="btn btn-medium btn-cancel" href="" data-switch="display">取消</a>
                &nbsp;
                <span class="error-tip error-tip-1001 hide">修改失败，请重新操作</span>
                <span class="error-tip error-tip-1002 hide">数据不能全为空，请重新操作</span>
            </span>
        </div>
    </div>
</div>
