!function(){

    // selectpicker初始化
    initSelect();

}();

seajs.use(['yqOption', 'yqDialog', 'yqFormCheck', 'yqArea', 'yqCalendar', 'yqQueryJsy', 'yqSortTable'],
    function(yqOption, yqDialog, yqFormCheck, yqArea, yqCalendar, yqQueryJsy, yqSortTable){


    // 日期选择框初始化
    if($('.datepicker').length){
        $('.datepicker').datepicker(yqOption.datepicker);
    }
    $('body').on('focus', '.datepicker', function(){
        var _this = this;
        setTimeout(function(){
            $('#ui-datepicker-div .ui-datepicker-calendar td a').one('click', function(){
                setTimeout(function(){
                    $(_this).trigger('blur');
                }, 0);
            });
        }, 0);
    });

    // 表单检查
    yqFormCheck.init();

    // 地区三级下拉框
    yqArea.init();

    // 模糊搜索
    yqQueryJsy.init();

    // 表格排序
    yqSortTable.init();


    // 非活跃链接
    $('body').on('click', 'a.disabled, .btn-disabled, .btn-loading', function(event){
        event.preventDefault();
    });

    // 查询表单
    $('body').on('click', '[data-query-btn]', function(event){
        event.preventDefault();
        $(this).closest('form.query-form').trigger('submit');
    });

    // well框
    $('body').on('click', '.well .close-btn', function(event){
        event.preventDefault();
        $(this).closest('.well').hide();
    });

    // tip提示控件
    var TIP_DIALOG;
    var TIP_TIMEOUT;
    function closeTipDialog(){
        if(TIP_DIALOG){
            TIP_TIMEOUT = setTimeout(function(){
                TIP_DIALOG.close().remove();
                TIP_DIALOG = null;
            }, 30)
        }
    }
    $('body').on('mouseenter', '[data-tip]', function(){
        clearTimeout(TIP_TIMEOUT);
        if($('.yq-tip:visible').length) return;
        var type = $(this).data('tip') || 'default',
            content = $(this).data('tip-content'),
            align = $(this).data('tip-align'),
            width = $(this).data('tip-width');
        if(type === 'custom') content = $(content).html();
        TIP_DIALOG = yqDialog.tip.call(this, type, content, align, width);
    }).on('mouseleave', '[data-tip]', function(){
        closeTipDialog();
    });
    $('body').on('mouseenter', '.yq-tip', function(){
        clearTimeout(TIP_TIMEOUT);
    }).on('mouseleave', '.yq-tip', function(){
        closeTipDialog();
    })

    // Shortcut快捷键
    $('body').on('click', '#go2top', function(event){
        event.preventDefault();
        var scroll_top = $('body').scrollTop() || $('html').scrollTop(),
            scroll_duration = scroll_top * 0.8;
        $('html, body').animate({scrollTop: 0}, scroll_duration);
    });

    // 顶部个人账号、消息下拉框
    var HEAD_COMPONENT_TIP = null;
    var headAccountContent = $('<div></div>').wrapInner($('#headComponentAccount')).html();
    $('#headComponentAccount').remove();
    $('body').on('click', '[data-head-component="account"]', function(event){
        event.preventDefault();
        event.stopPropagation();
        if(HEAD_COMPONENT_TIP){
            HEAD_COMPONENT_TIP.close().remove();
            HEAD_COMPONENT_TIP = null;
        }
        HEAD_COMPONENT_TIP = dialog({
            skin: 'yq-tip head-component-tip',
            align: 'bottom',
            content: headAccountContent
        });
        HEAD_COMPONENT_TIP.width(90);
        HEAD_COMPONENT_TIP.show(this);
    });

    $('body').on('click', function(){
        if(HEAD_COMPONENT_TIP){
            HEAD_COMPONENT_TIP.close().remove();
            HEAD_COMPONENT_TIP = null;
        }
    });



    $('body').on('mouseenter', '#switchToOld', function(){
        $(this).find('.active').show().siblings('.inactive').hide();
    }).on('mouseleave', '#switchToOld', function(){
        $(this).find('.active').hide().siblings('.inactive').show();
    });
    $('body').on('click', '#switchToOld .close-btn', function(event){
        event.preventDefault();
        event.stopPropagation();
        $('#switchToOld').hide();
    });

    // 获取验证码逻辑
    function getCodeCountdown(seconds){
        var form_group = $(this).closest('.form-group');
        if(seconds == 0){
            form_group.find('.btn-captcha').removeClass('btn-disabled').text('获取验证码');
            form_group.find('.wait-seconds').text('');
            form_group.find('[data-get-code="voice"]').removeClass('disabled');
        }else{
            form_group.find('.btn-captcha').text(seconds + '秒后重发');
            form_group.find('.wait-seconds').text(seconds + '秒后');
            seconds--;
            var _this = this;
            setTimeout(function(){
                getCodeCountdown.call(_this, seconds);
            }, 1000);
        }
    }

    $('body').on('click', '[data-get-code]', function(event){
        event.preventDefault();
        if($(this).hasClass('btn-disabled')) return false;
        var form = $(this).closest('.form-area');
        form.find('.input-mobile').trigger('blur');
        if(form.find('.input-mobile').closest('.form-group').find('.error-tip-front').is(':visible')) return false;
        var seconds = 60;
        var lang_type = {'sms': '发短信到'};
        var form_group = $(this).closest('.form-group');
        var type = $(this).data('get-code');
        if(type == 'sms') type = 1;
        else if(type == 'voice') type = 2;
        else return false;
        var mobile_number = form.find('.input-mobile').val();
        var mobile_mask = mobile_number.replace(mobile_number.substr(3, 6), '******');
        form_group.find('.btn-captcha').addClass('btn-disabled');

        getCodeCountdown.call(this, seconds);
        $.ajax({
            url: "/Home/user/get_captcha_post",
            data: {
                'mobile': mobile_number
            },
            type: "post",
            dataType: 'json'
        });
    });

    // 信息、表单切换
    $('body').on('click', '[data-switch]', function(event){
        event.preventDefault();
        var action = $(this).data('switch');
        var actions = ['display', 'modify'];
        if($.inArray(action, actions) !== -1){
            var container_map = {
                'form': '.form-area',
                'group': '.form-group'
            }
            var scope = $(this).data('switch-scope') || 'form';
            var container = $(this).closest(container_map[scope]);
            for(var i in actions){
                if(actions[i] == action){
                    container.find('.' + actions[i] + '-info').show();
                }else{
                    container.find('.' + actions[i] + '-info').hide();
                }
            }
        }
    });

    $.fn.extend({

        // 表单提交暂时冻结按钮
        button: function(status){
            if(!$(this).hasClass('btn')) return false;
            switch(status){
                case 'loading':
                    var default_text = $(this).data('default-text');
                    var loading_text = $(this).data('loading-text');
                    var width = $(this).css('width');
                    if(!default_text) $(this).data('default-text', $(this).text());
                    if(loading_text) $(this).text(loading_text);
                    $(this).addClass('btn-loading');
                    var width2 = $(this).css('width');
                    if(width > width2) $(this).css({'width': width});
                    break;
                case 'reset':
                    var default_text = $(this).data('default-text');
                    if(default_text) $(this).text(default_text);
                    $(this).removeClass('btn-loading');
                    break;
            }
        }

    });


    //当前是否为工作时间
    function isWorkTime() {
        var _h = (new Date()).getHours();
        return _h >= 10 && _h <= 17;
    }


});
