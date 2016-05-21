<style type="text/css">
    .td1 {
        text-align: right;
        width: 20%;
    }
</style>

<?php
if ($bEdit) {
    $aDisabled = array(
        'disabled' => 'disabled'
    );
} else {
    $aDisabled = array();
}
?>
<form method="post" action="/admin/kv/add_post" onsubmit="return LianMeng.form_post(this, '/admin/kv/')">
    <?=\Common\Helper\Form::hidden('edit', $bEdit ? $Item->key : '')?>
    <table class="maintable">
        <tr>
            <td class="td1">配置名</td>
            <td><?=\Common\Helper\Form::input('key_name', $Item->key_name, array('placeholder' => '配置中文名'))?></td>
        </tr>
        <tr>
            <td class="td1">配置key</td>
            <td><?=\Common\Helper\Form::input('key', $Item->key, $aDisabled + array('placeholder' => '全局配置唯一key值'))?></td>
        </tr>
        <tr>
            <td class="td1">有效配置</td>
            <td>
                <label style="display: inline-block;"><?=\Common\Helper\Form::radio('online', 1, $Item->online === null || $Item->online == 1 ? true : false)?>有效</label>
                <label style="display: inline-block;"><?=\Common\Helper\Form::radio('online', 0, $Item->online !== null && $Item->online == 0 ? true : false)?>无效</label>
            </td>
        </tr>
        <tr>
            <td class="td1">配置说明</td>
            <td>
                <?php $aNoteInfo = unserialize($Item->note_info); echo \Common\Helper\Form::textarea('reason', isset($aNoteInfo['reason']) ? $aNoteInfo['reason'] : '', array('placeholder' => '该配置的详细描述，用途，配置规则等'))?>
            </td>
        </tr>
        <tr>
            <td class="td1">配置类型</td>
            <td><?=\Common\Helper\Form::select('type', $aType, $Item->type, $aDisabled)?></td>
        </tr>
        <tr>
            <td class="td1">具体配置</td>
            <td>
                <div id='value_0' style="display: none;">
                    <?=\Common\Helper\Form::textarea('value_0', $Item->value)?>
                </div>
                <div id="value_1" style="display: none;">
                    <div id="value_1_config"></div>
                    <input type="button" value="点击添加" style="margin:4px 0;" class="config_add" />
                </div>
            </td>
        </tr>
        <tr>
            <td class="td1"></td>
            <td><?=\Common\Helper\Form::submit('', '提交')?></td>
        </tr>
    </table>

</form>


<div id="config_replace" style="display:none;" >
    <div class="" id="config_list_num" style="display:none; margin-bottom: 10px;">
        key :
        <?=\Common\Helper\Form::input('config[num][0]', '', array('style' => 'width: 100px; position: relative; top: 5px;'))?>
        value :
        <?=\Common\Helper\Form::input('config[num][1]', '', array('style' => 'width: 400px; position: relative; top: 5px;'))?>
        <input style="margin-left:10px;" type="button" value="删除" >
    </div>
</div>

<script type="text/javascript">
    $(function() {

        $(function() {

            $('select[name="type"]').change(function() {
                var type = $(this).val();
                if (type == 0) {
                    $('#value_1').hide();
                    $('#value_0').show();
                } else {
                    $('#value_0').hide();
                    $('#value_1').show();
                }
            });

            $('select[name="type"]').change();
        });

        var click = 0;
        $("#value_1_config").each(function(e) {
            click += $(e).find('div').length;
        })

        function rm(obj)
        {
            $(obj).parent().hide(800,function(){
                $(this).remove();
            });
        }

        $(".rule_list div > :button[value='删除']").click(function(){rm(this);});

        $(".config_add").click(function(){
            var tmp = $("#config_replace").html().replace(/num/g, click);

            if( $("#value_1_config > div").length == 0)
            {
                $("#value_1_config").html('');
            }

            $("#value_1_config").append(function(n){ return tmp; });

            var id = $("#value_1_config div#" + "config_list_"+click).attr('id');

            setTimeout(function(){$("#value_1_config #"+id).show(800)}, 100);

            click++;
            $("#value_1_config div > :button[value='删除']").click(function(){rm(this);});
        });

        //加载配置
        var config = <?=json_encode($Item->type != 0 ? $Item->value : array());?>;

        for (var k in config) {
            $('.config_add').click();
            $('input[name="config['+(click-1)+'][0]"]').attr('value', k);
            $('input[name="config['+(click-1)+'][1]"]').attr('value', config[k]);
        }

    });
</script>