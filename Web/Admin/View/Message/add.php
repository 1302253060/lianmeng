<form id='message_form' action="/admin/message/add_post" class="form-horizontal" method="post" onsubmit="return LianMeng.form_post(this, document.location)">
    <div class="control-group user_ids">
        <label class="control-label" for="user_ids">收件人</label>
        <div class="controls" style="line-height:28px;">
            <?=\Common\Helper\Form::select("channel", $aChannel, $channel, array('id' => 'channel_type')); ?>&nbsp;&nbsp;&nbsp;(注：如选中上面的特殊人群,发送完一般需要2-5分钟左右,请耐心等待)
        </div>
        <p></p>
        <div class="controls" id="other_id" style="display: none;">
            <textarea rows="5" placeholder="其他用户ID" name="other_user"></textarea>
            <br>
            <span style="color: red;">注：用户ID，一行一个ID</span>
        </div>
    </div>

    <div class="control-group user_ids">
        <label class="control-label" for="user_ids">收件人</label>
        <div class="controls" style="line-height:28px;">
            <?=\Common\Helper\Form::select("type", $aType, $type); ?>
        </div>
        <p></p>
    </div>


    <div class="control-group">
        <label class="control-label" for="title">站内信标题</label>
        <div class="controls">
            <input style="width: 500px;" type="text" name="title" value="" class="input-large" >(当为手机短信)
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="content">站内信内容</label>
        <div class="controls">
            <script id="sub_editor" style="width:800px;" name="content" type="text/plain"></script>
            <span class="help-inline"></span>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <?=\Common\Helper\Form::submit('submit', '提交');?>
        </div>
    </div>
</form>

<script type="text/javascript" src="/Public/statics/assets/js/plugin/jquery-ui.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/plugin/bd.dlg.js"></script>
<script type="text/javascript" src="/Public/statics/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/statics/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Public/statics/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    window.UEDITOR_CONFIG.savePath = ['/home/work/web_uploads/uploads/img/LianMeng'];
    var editor = UE.getEditor('sub_editor');
</script>

<script type="text/javascript">
$(function() {
    $("#channel_type").change('change',function() {
        if (this.value == 3) {
            $("#other_id").show();
        } else {
            $("#other_id").hide();
        }
    });
});
</script>


