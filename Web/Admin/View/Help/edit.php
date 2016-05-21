<p><a href="/admin/help/" style="color: #8FA2D5;font-weight: bold;">《返回列表</a></p>
<form action="<?=$bEdit ? '/admin/help/edit_post' : '/admin/help/add_post'?>" method="post" class="form-horizontal" onsubmit="return LianMeng.form_post(this, '/admin/help/')">
    <?php if ($bEdit):?>
        <input name="id" value="<?= $Item->id ?>" type="hidden">
    <?php endif;?>

    <div class="control-group">
        <label class="control-label">类型:</label>
        <div class="controls">
            <select name="type">
                <?php foreach($aType as $key => $val): ?>
                    <option value="<?=$key?>" <?=($bEdit && $Item->type == $key) ? 'selected="selected"' : ''?>><?=$val?></option>
                <?php endforeach;?>
            </select>
            <span class="help-inline"></span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">标题:</label>
        <div class="controls">
            <input type="text" class="input-large" name="title" placeholder="" value="<?=$bEdit ? $Item->title : ''?>">
            <span class="help-inline"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">内容:</label>
        <div class="controls">
            <script id="sub_editor" name="content" type="text/plain"><?=$bEdit ? $Item->content : ''?></script>
            <span class="help-inline"></span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">状态:</label>
        <div class="controls">
            <select name="status">
                <option value="1" <?=($bEdit && $Item->status==\Admin\Model\HelpModel::STATUS_ONLINE) ? 'selected="selected"' : ''?>>显示</option>
                <option value="0" <?=($bEdit && $Item->status==\Admin\Model\HelpModel::STATUS_OFFLINE) ? 'selected="selected"' : ''?>>隐藏</option>
            </select>
            <span class="help-inline"></span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">排序:</label>
        <div class="controls">
            <input type="text" class="input-large" name="sort" placeholder="" value="<?=$bEdit ? $Item->sort : ''?>">
            <span class="help-inline"></span>
        </div>
    </div>

    <div class="form-actions">
        <input class="btn btn-primary" type="submit" value="提交"/>
    </div>
</form>
<script type="text/javascript" src="/Public/statics/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/statics/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Public/statics/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    window.UEDITOR_CONFIG.savePath = ['D:\\project\\lianmeng\\Public\\Uploads\\u_image'];
    var editor = UE.getEditor('sub_editor');
</script>