<style type="text/css">
    label{display: inline;}
</style>
<script type="text/javascript">
    var _is_run_ajax = false;
    var now_groups_form = '_';
    function do_next_step()
    {
        if (_is_run_ajax)return;
//        if (!$('#checked_perm_div input')[0])return;
        var checkboxs = $('#checked_perm_div input:checked');
        var group_ids = [];
        for ( var i=0;i<checkboxs.length;i++ )
        {
            if ( checkboxs[i].checked )
            {
                group_ids.push(checkboxs[i].value);
            }
        }
        var groups_form = group_ids.join(',');
        if ( now_groups_form==groups_form )
        {
            //直接切换显示
            $('#mytag_main_1')[0].style.display='none';
            $('#mytag_main_2')[0].style.display='';
            $('#step_tag_1')[0].className='';
            $('#step_tag_2')[0].className='hover';

            change_zdy_parm();
            return ;
        }

        $('input[name="save_direct"]').attr('disabled', 'disabled');

        _is_run_ajax = true;
        $.get(
            '/admin/user/edit_perm_form',
            {
                'id' : '<?=$member->id?>'
            },
            function(data) {
                _is_run_ajax = false;
                $('#step1_loading')[0].style.display='none';
                $('#mytag_main_1')[0].style.display='none';
                $('#mytag_main_2')[0].style.display='';
                $('#step_tag_1')[0].className='';
                $('#step_tag_2')[0].className='hover';
                $('#perm_div')[0].innerHTML = data;

                now_groups_form = groups_form;

                change_zdy_parm();
            },
            "html"
        );
        $('#step1_loading')[0].style.display='';
    }

    function change_zdy_perm(v,c)
    {
        obj_a = $('#zdy_perm_redio_a')[0];
        obj_b = $('#zdy_perm_redio_b')[0];
        obj_1 = $('#zdy_perm_redio_1')[0];
        obj_2 = $('#zdy_perm_redio_2')[0];
        if (obj_1 && obj_2)
        {
            if (v==0)
            {
                obj_1.checked = obj_a.checked = true;
                obj_2.checked = obj_b.checked = false;
            }
            else
            {
                obj_1.checked = obj_a.checked = false;
                obj_2.checked = obj_b.checked = true;
            }
        }
        change_zdy_parm();
    }

    function do_per_step()
    {
        $('#mytag_main_1')[0].style.display='';
        $('#mytag_main_2')[0].style.display='none';
        $('#step_tag_1')[0].className='hover';
        $('#step_tag_2')[0].className='';

        $('input[name="save_direct"]').removeAttr('disabled');
    }
    function change_zdy_parm()
    {
        var zdy_perm_redio = $('#zdy_perm_redio_1')[0];
        var group_perm = false;
        if (zdy_perm_redio)
        {
            group_perm = zdy_perm_redio.checked;
        }

        super_admin();

        if (!$('#perm_checkbox_div')[0])return;
        var objs = $('#perm_checkbox_div')[0].getElementsByTagName('input');
        for(var i=0;i<objs.length;i++)
        {
            if ( objs[i].getAttribute('auto_disabled')=='on' )
            {
                objs[i].disabled = 'disabled';
            }
            else
            {
                if ( objs[i].getAttribute('has_checked')!='yes' )
                {
                    objs[i].checked = false;
                }
                if ( group_perm )
                {
                    objs[i].disabled = 'disabled';
                }
                else
                {
                    objs[i].disabled = false;
                }
            }
        }
    }

    function select_group_perm(obj,ck)
    {
        var objs = obj.getElementsByTagName('INPUT');
        for(var i=0;i<objs.length;i++)
        {
            if (objs[i].disabled)continue;
            objs[i].checked = ck;
        }
    }
    <?php
    $show_edit_perm = 1;
    if ($show_edit_perm)
    {
    ?>



    <?php
    }
    ?>

    function in_array(str,arr)
    {
        for (var i in arr)
        {
            if (arr[i]==i)return true;
        }
        return false;
    }

    function super_admin()
    {
        if ( $('#super_admin_value')[0] )
        {
            var ck = $('#super_admin_value')[0].checked;
        }
        else
        {
            var ck = false;
        }
        var zdy_ck = true;
        if (ck)
        {
            $('#perm_setting_div')[0].style.display = 'none';
        }
        else
        {
            zdy_ck = $('#zdy_perm_redio_1')[0].checked;
            $('#perm_setting_div')[0].style.display = '';
        }
        if (zdy_ck)
        {
            $('#step_tag_2')[0].style.display = 'none';
            $('#step_submit_1')[0].style.display = '';
            $('#step_submit_2')[0].style.display = 'none';
        }
        else
        {
            $('#step_tag_2')[0].style.display = '';
            $('#step_submit_1')[0].style.display = 'none';
            $('#step_submit_2')[0].style.display = '';
        }
    }
    </script>
<?php
if ($show_edit_perm)
{

    ?>
    <div class="tag">
        <ul class="ul">
            <li id="step_tag_1" onclick="do_per_step()" class="hover">基本信息</li>
            <li <?php if($member->is_super_admin) echo ' style="display:none;"';?> id="step_tag_2" onclick="do_next_step()">权限设置</li>
        </ul>
    </div>
<?php
}
?>
    <form name="myform" action="/admin/user/edit_post?id=<?php echo $member->id;?>" id="myform" method="post" onsubmit="return LianMeng.form_post(this, location.href)">
    <?php echo \Common\Helper\Form::hidden('edit_perm',$show_edit_perm?'1':'0');?>
    <div id="mytag_main_1">
    <table class="mainTable">
    <tr>
        <td colspan="2" style="text-align: center; font-weight: bold;"><?php echo $title;?> - 基本信息</td>
    </tr>
    <?php
    if (!$member->id>0)
    {
        # 创建新用户
        ?>
        <tr>
            <td width="160" class="td1" align="right">
                用户名：
            </td>
            <td class="td2">
                <input type="text" value="" name="username" style="width:220px;" />
            </td>
        </tr>
        <tr>
            <td class="td1" align="right">
                姓名：
            </td>
            <td class="td2">
                <input type="text" value="" name="nickname" style="width:220px;" />
            </td>
        </tr>
        <tr>
            <td class="td1" align="right">
                密码：
            </td>
            <td class="td2">
                <input autocomplete="off" type="password" value="" name="password" style="width:120px;" />
            </td>
        </tr>
    <?php
    }
    else
    {
        ?>
        <tr>
            <td width="160" class="td1" align="right">
                用户名：
            </td>
            <td class="td2">
                <?php echo \Common\Helper\Form::input('', $member->username, array('style'=>'width:220px;','disabled'=>'disabled'));?>
            </td>
        </tr>
        <tr>
            <td class="td1" align="right">
                姓名：
            </td>
            <td class="td2">
                <?php echo \Common\Helper\Form::input('nickname',$member->nickname,array('style'=>'width:220px;'));?>
            </td>
        </tr>
        <tr>
            <td class="td1" align="right">密码：</td>
            <td colspan="2" class="td2">
                <?=\Common\Helper\Form::input('password', null, array('placeholder' => 'xxxxxx', 'type' => 'password'))?>
            </td>
        </tr>

    <?php
    }
    ?>

        <tr>
            <td class="td1" align="right">登录权限：</td>
            <td colspan="2" class="td2">
                <label>
                    <?=\Common\Helper\Form::radio('shielded', 0, $member->shielded == 0 ? true : false)?>
                    有
                </label>
                <label>
                    <?=\Common\Helper\Form::radio('shielded', 1, $member->shielded == 1 ? true : false)?>
                    无
                </label>
            </td>
        </tr>
    <?php
    if ($show_edit_perm)
    {
        ?>
        <?php
        if (\Common\Helper\Session::instance()->member()->is_super_admin)
        {
            ?>
            <tr>
                <td class="td1" align="right">是否超级管理员：</td>
                <td class="td2">
                    <label><?php echo \Common\Helper\Form::radio('is_super_admin', 1, $member->is_super_admin?true:false, array('onclick'=>'super_admin();','id'=>'super_admin_value'))?>是</label>
                    <label><?php echo \Common\Helper\Form::radio('is_super_admin', 0, $member->is_super_admin?false:true, array('onclick'=>'super_admin();'))?>否</label>
                </td>
            </tr>
        <?php
        }
        ?>

        <tbody id="perm_setting_div"<?php if ($member->is_super_admin)echo ' style="display:none"'?>>


        <tr style="display: none;">
            <td class="td1" align="right">权限设置：</td>
            <td class="td2">
                <label><?php echo \Common\Helper\Form::radio('zdy_perm',0,$member->perm_setting?false:true,array('id'=>'zdy_perm_redio_1','onclick'=>'change_zdy_perm(0,false)'));?>仅使用所在组权限</label>
                <label><?php echo \Common\Helper\Form::radio('zdy_perm',1,$member->perm_setting?true:false,array('id'=>'zdy_perm_redio_2','onclick'=>'change_zdy_perm(1,false)'));?>可自定义权限</label>
            </td>
        </tr>
        </tbody>


    <?php
    }
    ?>
    <tr>
        <td class="td1"> </td>
        <td class="td1">
            <?php
            if ($show_edit_perm)
            {
                ?>
                <?=\Common\Helper\Form::hidden('save_direct', 1)?>
                <input type="submit" class="submit" value="立即保存" />
                <span id="step_submit_1"<?php if (!$member->is_super_admin) echo ' style="display:none;"'?>>
                    <input type="button" onclick="do_next_step()" value="查看权限" />
                </span>
                <input type="button" id="step_submit_2"<?php if ($member->is_super_admin) echo ' style="display:none;"'?> class="submit" onclick="do_next_step()" value="下一步" />
            <?php
            }
            else
            {
                ?>
                <input type="submit" class="submit"  value="立即保存" />
            <?php
            }
            ?>
            <input type="button" value="返回" onclick="window.history.go(-1)" />
            <span id="step1_loading" style="display:none;">请稍等...</span>
        </td>
    </tr>
    </table>
    </div>

    <?php
    ?>

    <div id="mytag_main_2" style="display:none;">
        <table border="0" cellpadding="4" cellspacing="1" align="center" class="mainTable">
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold;"><?php echo $title;?> - 权限设置</td>
            </tr>
            <tr>
                <td width="160" class="td1" align="right">权限设置：</td>
                <td class="td2" id="perm_div">
                </td>
            </tr>
            <tr style="display: none;">
                <td class="td1" align="right">权限设置：</td>
                <td class="td2">
                    <label><?php echo \Common\Helper\Form::radio(null,0,$member->perm_setting?false:true,array('id'=>'zdy_perm_redio_a','onclick'=>'change_zdy_perm(0,true);'));?>仅使用所在组权限</label>
                    <label><?php echo \Common\Helper\Form::radio(null,1,$member->perm_setting?true:false,array('id'=>'zdy_perm_redio_b','onclick'=>'change_zdy_perm(1,true);'));?>可自定义权限</label>
                </td>
            </tr>
            <tr>
                <td class="td1"> </td>
                <td class="td1">
                    <input type="submit" class="submit" value="立即保存" />
                    <input type="button" value="上一步" onclick="do_per_step()" />
                    <input type="button" value="返回" onclick="window.history.go(-1)" />
                </td>
            </tr>
        </table>
    </div>
    </form>

<?php
if ($show_edit_perm)
{
    ?>
    <script type="text/javascript">change_zdy_perm(1,false);</script>
<?php
}
?>