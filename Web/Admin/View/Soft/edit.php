<p><a href="/admin/soft/" style="color: #8FA2D5;font-weight: bold;">《返回列表</a></p>
<form class="form-horizontal" action="<?=$bEdit ? '/admin/soft/edit_post' : '/admin/soft/add_post'?>" method="post" onsubmit="return LianMeng.form_post(this, '/admin/soft/')">
    <?php if ($bEdit):?>
    <input name="id" value="<?= $Item->id ?>" type="hidden">
    <?php endif;?>
    <div class="control-group">
        <label class="control-label">软件ID:</label>
        <div class="controls">
            <?=\Common\Helper\Form::input('id', $bEdit ? $Item->id : '', array('placeholder' => '不填系统自动分配', ($bEdit ? 'disabled' : '') => true))?>
            <span class="help-inline"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">软件名称:</label>
        <div class="controls">
            <input type="text" class="input-large" name="name" placeholder="" value="<?=$bEdit ? $Item->name : ''?>">
            <span class="help-inline"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">原始包名称:</label>
        <div class="controls">
            <input type="text" disabled id="uploadUrl_post" class="input-large" value="<?=$bEdit ? $Item->package : ''; ?>">
            <input type="hidden" id="uploadUrl_post_hidden" name="package" value="<?=$bEdit ? $Item->package : ''; ?>">
            <span class="btn btn-success fileinput-button">
                <span>
                    <span id="uploadUrl_tag">选择文件</span>
                    <input id="uploadUrl" type="file" name="uploadUrl" class="uploadfile_clz">
                </span>
            </span>
            <div id="uploadUrl_show"></div>
            <input type="hidden" id="uploadUrl_md5" name="md5" value="<?=$bEdit ? $Item->md5 : ''; ?>">
            <input type="hidden" id="uploadUrl_size" name="filesize" value="<?=$bEdit ? $Item->filesize : ''; ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">组件包名称:</label>
        <div class="controls">
            <input type="text" disabled id="uploadUrlZuJian_post" class="input-large" value="<?=$bEdit ? $Item->package_zujian : ''; ?>">
            <input type="hidden" id="uploadUrlZuJian_post_hidden" name="package_zujian" value="<?=$bEdit ? $Item->package_zujian : ''; ?>">
            <span class="btn btn-success fileinput-button">
                <span><span id="uploadUrlZuJian_tag">选择文件</span><input id="uploadUrlZuJian" type="file" name="uploadUrlZuJian" class="uploadfile_clz"></span>
            </span>
            <input type="hidden" id="uploadUrlZuJian_size" name="filesize_zujian" value="<?=$bEdit ? $Item->filesize_zujian : ''; ?>">
            <div id="uploadUrlZuJian_show"></div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">首页简介:</label>
        <div class="controls">
            <textarea name="index_intro" class="input-large" row="3" placeholder=""><?=$bEdit ? $Item->index_intro : ''?></textarea>
            <span class="help-inline"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">价格:</label>
        <div class="controls">
            <input type="text" class="input-large" name="price" placeholder="" value="<?=$bEdit ? $Item->price : ''?>">
            <span class="help-inline"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">简介:</label>
        <div class="controls">
            <input type="text" class="input-large" name="summary" placeholder="" value="<?=$bEdit ? $Item->summary : ''?>">
            <span class="help-inline"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">详细信息:</label>
        <div class="controls">
            <textarea name="introduce" class="input-large" row="3" placeholder=""><?= $bEdit ? $Item->introduce : '' ?></textarea>
            <span class="help-inline"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">版本号:</label>
        <div class="controls">
            <input type="text" class="input-large" name="version" placeholder="" value="<?=$bEdit ? $Item->version : ''?>">
            <span class="help-inline"></span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">LOGO上传:</label>
        <div class="controls">
            <input type="text" disabled id="uploadlogo_post" class="input-large" value="<?=$bEdit ? $Item->logo : '' ?>">
            <input type="hidden" id="uploadlogo_post_hidden" name="logo" value="<?=$bEdit ? $Item->logo : ''; ?>">
            <span class="btn btn-success fileinput-button">
                <span><span id="uploadlogo_tag">选择Logo</span><input id="uploadlogo" type="file" name="uploadlogo" class="uploadimg_clz"></span>
            </span>
            <div id="uploadlogo_show">
                <?php if ($bEdit):?>
                <p></p><img src="<?=$Item->logo?>" width="50px" height="50px">
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">ICON上传:</label>
        <div class="controls">
            <input type="text" disabled id="uploadicon_post" class="input-large" value="<?=$bEdit ? $Item->icon : ''?>">
            <input type="hidden" id="uploadicon_post_hidden" name="icon" value="<?=$bEdit ? $Item->icon : ''?>">
            <span class="btn btn-success fileinput-button">
                <span><span id="uploadicon_tag">选择Icon</span><input id="uploadicon" type="file" name="uploadicon" class="uploadimg_clz"></span>
            </span>
            <div id="uploadicon_show">
                <?php if ($bEdit):?>
                    <img src="<?=$Item->icon; ?>" width="50px" height="50px">
                <?php endif;?>
            </div>
        </div>
    </div>



    <div class="control-group">
        <label class="control-label">配置:</label>
        <div class="controls">
            <div id="config_div">

            </div>
            <input type="button" data-rule="rule6" value="点击添加" style="margin:4px 0;" class="config_add" />
            <span style="color: #ff0000;">具体配置，请联系客户端同学</span>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label">上线时间:</label>
        <div class="controls">
            <?=\Common\Helper\Form::input_date('online_time', $Item->online_time)?>
            <span class="help-inline"></span>
        </div>
    </div>




    <div style="display:none;" class="control-group">
        <label class="control-label">排序:</label>
        <div class="controls">
        <?php if ($bEdit):?>
        <input type="hidden" name="old_show_order" value="<?=$Item->show_order?>">
        <?php endif;?>
        <input type="text" name="show_order" class="input-large" value="<?=$bEdit ? $Item->show_order : '1'?>">
            <span class="help-inline">(越小越靠前)</span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">状态:</label>
        <div class="controls">
            <?=\Common\Helper\Form::select('status', $aStatus, $Item->status)?>
            <span class="help-inline"></span>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label">类型:</label>
        <div class="controls">
            <?=\Common\Helper\Form::select('type', $aType, $Item->type)?>
            <span class="help-inline"></span>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label">有效安装率:</label>
        <div class="controls">
            <input type="text" name="effect_ratio" class="input-large" value="<?=$bEdit ? $Item->effect_ratio : null?>">
            <span class="help-inline"></span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">有效安装率内容:</label>
        <div class="controls">
            <input type="text" name="effect_ratio_comment" class="input-large" value="<?=$bEdit ? $Item->effect_ratio_comment : null?>">
            <span class="help-inline"></span>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label">软件介绍内容:</label>
        <div class="controls">
            <script id="sub_editor" name="content" type="text/plain"><?=$bEdit ? $Item->content : ''?></script>
            <span class="help-inline"></span>
        </div>
    </div>



    <div class="form-actions">
        <input class="btn btn-primary" type="submit" value="提交"/>
    </div>
</form>

<script type="text/javascript" src="/Public/statics/fileupload/jquery.fileupload.js"></script>
<script type="text/javascript" src="/Public/statics/fileupload/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/Public/statics/fileupload/jquery.ui.widget.js"></script>

<script type="text/javascript" src="/Public/statics/assets/js/upload_img.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/upload_file.js"></script>

<div id="config_replace" style="display:none;" >
    <div class="" id="config_list_num" style="display:none; margin-bottom: 10px;">
        key :
        <?=\Common\Helper\Form::input('config[num][0]', '', array('style' => 'width: 100px; position: relative; top: 5px;'))?>
        value :
        <?=\Common\Helper\Form::input('config[num][1]', '', array('style' => 'width: 500px; position: relative; top: 5px;'))?>
        <input style="margin-left:10px;" type="button" value="删除" >
    </div>
</div>

<script type="text/javascript">
    $(function() {
        var click = 0;
        $("#config_div").each(function(e) {
            click += $(e).find('div').length;
        })

        function rm(obj)
        {
            $(obj).parent().hide(800,function(){
                $(this).remove();
//                if( $("#rule1_list  div").length == 0)
//                {
//                    $("#config_div").html('');
//                }
            });
        }

        $(".rule_list div > :button[value='删除']").click(function(){rm(this);});

        $(".config_add").click(function(){
            var tmp = $("#config_replace").html().replace(/num/g, click);

            if( $("#config_div > div").length == 0)
            {
                $("#config_div").html('');
            }

            $("#config_div").append(function(n){ return tmp; });

            var id = $("#config_div div#" + "config_list_"+click).attr('id');

            $("#config_div #"+id).show(800);

            click++;
            $("#config_div div > :button[value='删除']").click(function(){rm(this);});
        });

        //加载配置
        var config = <?=json_encode($bEdit ? json_decode($Item->config) : array());?>;

        for (var k in config) {
            $('.config_add').click();
            $('input[name="config['+(click-1)+'][0]"]').attr('value', k);
            $('input[name="config['+(click-1)+'][1]"]').attr('value', config[k]);
        }

    });
</script>


<script type="text/javascript" src="/Public/statics/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/statics/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Public/statics/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    window.UEDITOR_CONFIG.savePath = ['/home/work/web_uploads/uploads/img/LianMeng'];
    var editor = UE.getEditor('sub_editor');
</script>