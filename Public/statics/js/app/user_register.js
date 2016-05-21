seajs.use(['yqFormCheck', 'yqDialog', 'yqTypeCheck'], function(yqFormCheck, yqDialog, yqTypeCheck){

    $('body').on('blur', '[name="inv_code"]', function(){
        if ($('[name="reg_type"]:checked').val() == 1) {
            return false;
        }
        var inv_code = $(this).val();
        var form = $(this).closest('.form-area');
        if(yqTypeCheck.check(inv_code, 'char_or_number')){
            $.ajax({
                url: '/Home/user/check_inv_code_post',
                data: {
                    inv_code: inv_code
                },
                type: 'post',
                dataType: 'json'
            }).done(function(data){
                if(data.errCode != 0){
                    var error_tip = form.find('.error-tip-' + data.errCode);
                    if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
                }
            });
        }
    });


    $('body').on('blur', '[name="mobile"]', function(){
        var inv_code = $('input[name="inv_code"]').val();
        var mobile   = $(this).val();
        var reg_type = $('[name="reg_type"]:checked').val();
        var form = $(this).closest('.form-area');
        if(yqTypeCheck.check(mobile, 'mobile')){
            $.ajax({
                url: '/Home/user/check_mobile_post',
                data: {
                    mobile: mobile,
                    inv_code: inv_code,
                    reg_type: reg_type
                },
                type: 'post',
                dataType: 'json'
            }).done(function(data){
                if(data.errCode != 0){
                    var error_tip = form.find('.error-tip-' + data.errCode);
                    if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
                }
            });
        }
    });

    $('body').on('click', '#submitRegBtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        if(!yqFormCheck.frontCheck.apply(form.get(0))) return;

        $.ajax({
            url: '/Home/user/register_post',
            data: {
                inv_code: form.find('[name="inv_code"]').val(),
                mobile: form.find('[name="mobile"]').val(),
                mobile_captcha: form.find('[name="captcha"]').val(),
                name: form.find('[name="name"]').val(),
                qq: form.find('[name="qq"]').val(),
                email: form.find('[name="email"]').val(),
                province: form.find('[name="province"]').val(),
                city: form.find('[name="city"]').val(),
                county: form.find('[name="county"]').val(),
                address: form.find('[name="address"]').val(),
                password: form.find('[name="password"]').val(),
                confirm_password: form.find('[name="confirm_password"]').val(),
                reg_type: form.find('[name="reg_type"]:checked').val(),
                code: form.find('[name="code"]').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            yqFormCheck.reset.apply(form.get(0));
            if(data.errCode == 0){
                window.location.href = '/';
            }else{
                var error_tip = form.find('.error-tip-' + data.errCode);
                if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
            }
        });
    });

});
