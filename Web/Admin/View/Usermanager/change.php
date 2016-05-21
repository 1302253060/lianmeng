

<form class="form-horizontal" method="post" action="/admin/usermanager/change_post" onsubmit="return LianMeng.form_post(this, document.location);">
    <div class="control-group">
        <label class="control-label" for="inputEmail">用户列表</label>
        <div class="controls">
            <textarea rows="5" placeholder="输入用户ID" name="user_ids"></textarea>
            <br>
            <span style="color: red;">注：一行一个用户ID</span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="status">状态</label>
        <div class="controls">
            <select id="status" name="status" class="input-medium">
                <option value="0">请选择</option>
                <?php foreach ($aAllStatus as $iKey => $sValue): ?>
                    <option value="<?= $iKey ?>" ><?= $sValue ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="control-group" id="div_safe" style="display: none;">
        <label class="control-label" for="safe">是否考虑冻结安全期</label>
        <div class="controls">
            <label style="display: inline;"><input type="radio" name="safe" value="1" checked>是</label>
            <label style="display: inline; margin-left: 20px;"><input type="radio" name="safe" value="0">否</label>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputPassword">操作原因</label>
        <div class="controls">
            <input name="reason" placeholder="" type="text" />
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <span style="color: #ff0000;">注：不合法的USERID,不符合的状态自动过滤</span>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function () {
        var es = $('.form_date_input');
        es.datepicker({showButtonPanel: true});
        es.datepicker({
            showSecond: true,
            showMinutes: true,
            showHours: true,
            timeFormat: 'hh:mm:ss',
            stepMinute: 10,
            stepSecond: 10
        });
        es.datepicker($.datepicker.regional[ "zh-CN" ]);
        es.datepicker("option", "dateFormat", "yy-mm-dd");
    });
</script>