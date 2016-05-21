<form class="form-horizontal" action="/admin/pointflow/add_post" method="post" id="form_add_point">
    <div class="control-group">
        <label class="control-label" for="type">类型</label>
        <div class="controls">
            <?=\Common\Helper\Form::select('type', array('' => '请选择') + $aType)?>
        </div>
    </div>
    <div class="control-group user_ids_point">
        <label class="control-label" for="user_ids_point">用户ID/流量</label>
        <div class="controls">
            <textarea rows="5" placeholder="用户ID,流量数" name="user_ids_point"></textarea>
            <br>
            <span style="color: red;">注：用户ID,流量，一行一条流水记录</span>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label" for="note">备注</label>
        <div class="controls">
            <?=\Common\Helper\Form::input('note', '', array('class' => 'input-large'))?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <label><?=\Common\Helper\Form::checkbox('send_sms', '1') ?> 推送短信</label>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <?=\Common\Helper\Form::submit('', '提交', array('id' => 'button_submit'))?>
        </div>
    </div>
</form>

<script type="text/javascript">
$(function() {
    $("#button_submit").click(function() {
        var type = $('select[name="type"]').find('option:selected').val();
        var msg = '';
        var user_id = $('textarea[name="user_ids_point"]').val();
        var user_id_tidy    = [],
            point           = 0;
        user_id = user_id.split("\n");
        for (var i in user_id) {
            if (!user_id[i]) {
                continue;
            }
            user_id_tidy.push(user_id[i]);
            if (type != 0) {
                var tmp_user = user_id[i].split(',');
                if (tmp_user[1] != parseInt(tmp_user[1])) {
                    LianMeng.alert('用户ID/流量输入有误');
                    return false;
                }
                point += parseInt(tmp_user[1]);
            }
        }

        if (user_id_tidy.length >= 300) {
            LianMeng.error('为了保证效率，一次操作的用户数请限制在 ' + 300 + ' 以内');
            return false;
        }

        msg += '本次需要发放的人数为：' + user_id_tidy.length;
        if (point) {
            msg += "<br>本次需要发放的流量数：" + point;
        }
        LianMeng.confirm(msg + '<br>确定发放吗？', null, null, null, function(btn) {
            if (btn == 'ok') {
                LianMeng.form_post($('#form_add_point')[0], document.location)
            }
        });
        return false;
    });

})
</script>