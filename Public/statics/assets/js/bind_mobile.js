
window.YQ_BindMobile = {

    old_mobile : '',
    obj_dlg : null,
    now_step : 0,
    is_init_event : 0,

    init_event : function() {
        var _this = this;
        $("#step0_btn_ok").click(function() {
            var mobile = _this._check_step0_mobile();
            if(!mobile) return false;
            var mobile_captcha = $("#step0_mobile_captcha").val() || 0;
            if(!mobile_captcha.length || isNaN(mobile_captcha)) {
                _this.set_div_error('step0_div_error','手机验证码格式错误');
                return false;
            }
            _this.now_step = 0;
            _this.check_captcha(mobile,mobile_captcha);

        });

        $("#step0_get_captcha").click(function() {
            var attr = $(this).attr('attr');
            if(attr == 'disable') return;
            var mobile = _this._check_step0_mobile();
            if(!mobile) return false;
            _this.now_step = 0;
            $('#step0_get_captcha').attr('attr','disable');
            _this.get_captcha(mobile);
        });

        $("#step1_btn_ok").click(function() {
            var mobile = $.trim($("#step1_mobile").val()) || 0;
            if(!check_mobile(mobile)) {
                _this.set_div_error('step1_div_error','请输入正确手机号');
                return false;
            }
            _this.check_same_mobile(mobile);
        });

        $("#step2_btn_ok").click(function() {
            if(!_this.old_mobile || !check_mobile(_this.old_mobile)) {
                return false;
            }
            var mobile = _this._check_step2_mobile();
            if(!mobile) return false;
            var mobile_captcha = $("#step2_mobile_captcha").val() || 0;
            if(!mobile_captcha.length || isNaN(mobile_captcha)) {
                _this.set_div_error('step2_div_error','手机验证码格式错误');
                return false;
            }
            _this.now_step = 2;
            _this.check_captcha(mobile,mobile_captcha);
        });
        
        $("#step2_get_captcha").click(function() {
            var attr = $(this).attr('attr');
            if(attr == 'disable') return;
            var mobile = _this._check_step2_mobile();
            if(!mobile) return false;
            _this.now_step = 2;
            $('#step2_get_captcha').attr('attr','disable');
            _this.get_captcha(mobile);
        });

        $(".mobile_phoneNumberInput,.mobile_proofCodeInput").focus(function() {
            $(".mobile_false").hide();
        });
    },

    set_div_error : function(id,str) {
        $("#"+id).show().find('span').html(str);
    },

    set_get_captcha_gary_btn : function(obj_id) {
        var obj = $("#"+obj_id);
        if(!obj.length) return false;
        obj.attr('attr','disable').css('background','#999');
        var time = 60;
        obj.val(time+'秒后重发');
        var interval_code = setInterval(function() {
            if(time <= 0) {
                time = 60;
                obj.attr('attr' , '').css('background','#3f89ec').val('获取验证码');
                clearInterval(interval_code);
                return;
            }
            time--;
            obj.val(time+'秒后重发');
        } , 1000);
    },

    _check_step2_mobile : function() {
        var mobile = $.trim($("#step2_mobile").val()) || 0;
        if(!check_mobile(mobile)) {
            this.set_div_error('step2_div_error','请输入正确手机号');
            return false;
        }
        return mobile;
    },

    _check_step0_mobile : function() {
        var mobile = $.trim($("#step0_mobile").val()) || 0;
        if(!check_mobile(mobile)) {
            this.set_div_error('step0_div_error','请输入正确手机号');
            return false;
        }
        return mobile;
    },

    show_bind_mobile_layer : function(mobile_step) {
        mobile_step = parseInt(mobile_step,10);
        var dlg_config = {'title':'新手机号绑定','hasTop':true,'confirmTxt':'','cancelTxt':''};
        var obj_step = $("#div_step"+mobile_step);
        if(!obj_step || !obj_step.length) {
            return false;
        }
        obj_step.dtdlg(dlg_config);
        obj_step.dtdlg('open');
        this.obj_dlg = obj_step;
        this.init_event();
        this.set_default_dlg();
    },

    set_default_dlg : function() {
        $(".mobile_false").hide();
        $(".mobile_phoneNumberInput").val('');
        $(".mobile_proofCodeInput").val('');
    },

    check_same_mobile : function(mobile) {
        var _this = this;
        var post_data = {'mobile' : mobile};
        $.ajax({
            type : "post",
            url : "/user/info/check_same_mobile",
            data : post_data,
            success: function(msg){
                msg = eval('('+msg+')');
                if(msg.errno) {
                    _this.set_div_error('step1_div_error','请输入正确手机号!');
                    return;
                } else {
                    _this.old_mobile = msg.msg;
                    if(_this.obj_dlg) {
                        _this.obj_dlg.dtdlg('close');
                    }
                    _this.show_bind_mobile_layer(2);
                }
            },
            error:function() {
                alert('网络异常,发送请求失败!');
                return;
            }
        });
    },

    get_captcha : function(mobile,old_mobile) {
        var _this = this;
        old_mobile = old_mobile || '';
        var post_data = {'mobile' : mobile,
                         'old_mobile' : _this.old_mobile
                        };
        var div_id = 'step'+_this.now_step+'_div_error';
        var btn_id = 'step'+_this.now_step+'_get_captcha';
        $.ajax({
            type : "post",
            url : "/user/get_captcha",
            data : post_data,
            success: function(msg){
                msg = eval('('+msg+')');
                if(msg.errno) {
                    _this.set_div_error(div_id,msg.error);
                    $("#"+btn_id).attr('attr','');
                } else {
                    $("#"+div_id).hide();
                    _this.set_get_captcha_gary_btn(btn_id);
                }
            },
            error:function() {
                alert('网络异常,发送请求失败!');
                $("#"+btn_id).attr('attr','');
                return;
            }
        });
    },

    check_captcha : function(mobile,mobile_captcha) {
        var _this = this;
        var post_data = {'mobile' : $.trim(mobile),
                         'mobile_captcha' : mobile_captcha,
                         'old_mobile' : this.old_mobile
                        };
        $.ajax({
            type : "post",
            url : "/user/check_mobile_captcha_update",
            data : post_data,
            success: function(msg){
                msg = eval('('+msg+')');
                if(msg.errno) {
                    var div_id = 'step'+_this.now_step+'_div_error';
                    _this.set_div_error(div_id,msg.error);
                } else {
                    location.reload()
                }
            },
            error:function() {
                alert('网络异常,发送请求失败!');
                return;
            }
        });
    }
};

