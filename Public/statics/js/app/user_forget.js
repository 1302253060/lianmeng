seajs.use(['yqFormCheck','yqDialog'], function(yqFormCheck, yqDialog){

    $('body').on('click', '#changeStepABtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        if(!yqFormCheck.frontCheck.apply(form.get(0))) return;
        $.ajax({
            url: '/Home/user/check_mobile_code_post',
            data: {
                mobile: form.find('.input-mobile-a').val(),
                code: form.find('.input-code').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            if(data.errCode == 0){
                $('.three-steps-indicator .step-b').addClass('active');
                $('.change-step-a').addClass('hide').siblings('.change-step-b').removeClass('hide');
                $('#changeStepMobile').html(form.find('.input-mobile-a').val().substr(0, 3) + '*****' + form.find('.input-mobile-a').val().substr(-3, 3));
                $('.input-mobile').val(form.find('.input-mobile-a').val());
            }else{
                var error_tip = form.find('.error-tip-' + data.errCode);
                if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
            }
        })
    });


    $('body').on('click', '#changeStepBBtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        if(!yqFormCheck.frontCheck.apply(form.get(0))) return;
        $.ajax({
            url: '/Home/user/check_forget_captcha_post',
            data: {
                mobile_captcha: form.find('.input-captcha').val(),
                mobile: form.find('.input-mobile').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            if(data.errCode == 0){
                $('.three-steps-indicator .step-c').addClass('active');
                $('.change-step-b').addClass('hide').siblings('.change-step-c').removeClass('hide');
                $('.input-mobile-c').val(form.find('.input-mobile').val());
            }else{
                var error_tip = form.find('.error-tip-' + data.errCode);
                if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
            }
        })
    });

    $('body').on('click', '#changeStepCCtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        yqFormCheck.frontCheck.apply(form.get(0));
        $.ajax({
            url: '/Home/user/set_password_post',
            data: {
                password: form.find('.input-password').val(),
                mobile: form.find('.input-mobile-c').val(),
                confirm_password: form.find('.input-confirm-password').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            if(data.errCode == 0){
                $('.change-step-c-one').addClass('hide').siblings('.change-step-c-two').removeClass('hide');
            }else{
                var error_tip = form.find('.error-tip-' + data.errCode);
                if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
            }
        })
    });

});