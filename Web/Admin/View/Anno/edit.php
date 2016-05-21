<p><a href="/admin/anno/" style="color: #8FA2D5;font-weight: bold;">《返回列表</a></p>
<form action="<?=$bEdit ? '/admin/anno/edit_post' : '/admin/anno/add_post'?>" method="post" class="form-horizontal" onsubmit="return LianMeng.form_post(this, '/admin/anno/')">
    <?php if ($bEdit):?>
        <input name="id" value="<?= $Item->id ?>" type="hidden">
    <?php endif;?>
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
                <option value="0" <?=($bEdit && $Item->status==0) ? 'selected="selected"' : ''?>>隐藏</option>
                <option value="1" <?=($bEdit && $Item->status==1) ? 'selected="selected"' : ''?>>普通</option>
                <option value="2" <?=($bEdit && $Item->status==2) ? 'selected="selected"' : ''?>>最新</option>
            </select>
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
    window.UEDITOR_CONFIG.savePath = ['/home/work/web_uploads/uploads/img/LianMeng'];
    var editor = UE.getEditor('sub_editor');
</script>