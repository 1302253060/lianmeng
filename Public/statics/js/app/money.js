seajs.use(['yqFormCheck', 'yqDialog', 'yqHelper'], function(yqFormCheck, yqDialog, yqHelper){

    $('body').on('keyup', '#inputPoint', function(event){
        var value = parseInt($(this).val());
        var confirmTip = $('.exchange-confirm-tip .well');
        if(!isNaN($(this).val()) && value){
            value = yqHelper.formatNumber(value * 1000);
            confirmTip.find('.point-num').text(value);
            confirmTip.removeClass('hidden');
        }else{
            confirmTip.addClass('hidden');
        }
    }).on('blur', '#inputPoint', function(event){
        $('.exchange-confirm-tip .well').addClass('hidden');
        if(isNaN($(this).val())) return;
        var value = parseInt($(this).val());
        var pointRemain = parseInt($('#accountRemain').text().replace(/,/g, ''));
        var error_tip = '';
        if(pointRemain < 1){
            error_tip = $('.error-tip-remain-a');
        }else if(value > pointRemain){
            error_tip = $('.error-tip-remain-b');
        }
        if(error_tip){
            setTimeout(function(){
                yqFormCheck.backendCheckError.apply(error_tip.get(0));
            }, 0);
        }
    })

    $('body').on('click', '#exchangeLLBtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        if(!yqFormCheck.frontCheck.call(form.get(0))) return;
        $(this).button('loading');
        var _this = this;
        $.ajax({
            url: '/Home/money/award_post',
            data: {
                point: form.find('[name="point"]').val(),
                captcha: form.find('[name="captcha"]').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            yqFormCheck.reset.call(form.get(0));
            if(data.errCode == 0){
                $('#exchangeSuccessPopup .point-num').text(String(form.find('[name="point"]').val() * 1000));
                var d = yqDialog.standardDialog({
                    title: '兑换成功',
                    content: '#exchangeSuccessPopup'
                });
            }else{
                var content;
                switch(parseInt(data.errCode, 10)){
                    case 1002:
                        content = '用户已冻结或未审核,请联系管理员';
                        break;
                    case 1001:
                        content = '请完成身份证绑定后再提款 <a href="/Home/account/card">去身份证绑定&gt;</a>';
                        break;
                    case 1003:
                        content = '请完成银行卡绑定后再提款 <a href="/Home/account/">去银行卡绑定&gt;</a>';
                        break;
                    case 2001:
                        content = '输入的验证码不正确';
                        break;
                    case 3001:
                        content = '账户余额少于1000流量无法兑换';
                        break;
                    case 3002:
                        content = data.msg;
                        break;
                    default :
                        content = '兑换失败';
                        break;
                }
                if(content){
                    yqDialog.commonDialog({
                        title: '提示',
                        icon: 'alert',
                        content: content,
                        okValue: '确定',
                        ok: function(){},
                        cancelValue: ''
                    });
                }else{
                    var error_tip = form.find('.error-tip-' + data.errCode);
                    yqFormCheck.backendErrorGeneral.call(form, data.errCode, data.msg);
                }
            }
        }).always(function(){
            $(_this).button('reset');
        });
    });

});