seajs.use(['yqFormCheck','yqDialog'], function(yqFormCheck, yqDialog){

    $('body').on('click', '#saveInstallBtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        yqFormCheck.frontCheck.apply(form.get(0));
        $.ajax({
            url: '/Home/account/install_update_post',
            data: {
                'pc_install': form.find('[name="pc_install"]').val(),
                'pc_mark': form.find('[name="pc_mark"]').val(),
                'app_install': form.find('[name="app_install"]').val(),
                'app_mark': form.find('[name="app_mark"]').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            yqFormCheck.reset.apply(form.get(0));
            if(data.errCode == 0){
                window.location.reload();
            }else{
                var error_tip = form.find('.error-tip-' + data.errCode);
                if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
            }
        });
    });


    $('body').on('click', '#saveUserInfoBtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        yqFormCheck.frontCheck.apply(form.get(0));
        $.ajax({
            url: '/Home/account/update_post',
            data: {
                'qq': form.find('[name="qq"]').val(),
                'email': form.find('[name="email"]').val(),
                'bankcard': form.find('[name="bankcard"]').val(),
                'payee': form.find('[name="payee"]').val(),
                'subbranch': form.find('[name="subbranch"]').val(),
                'province': form.find('[name="province"]').val(),
                'city': form.find('[name="city"]').val(),
                'county': form.find('[name="county"]').val(),
                'address': form.find('[name="address"]').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            yqFormCheck.reset.apply(form.get(0));
            if(data.errCode == 0){
                window.location.reload();
            }else{
                var error_tip = form.find('.error-tip-' + data.errCode);
                if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
            }
        });
    });



    $('body').on('click', '#changeStepABtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        if(!yqFormCheck.frontCheck.apply(form.get(0))) return;
        $.ajax({
            url: '/Home/user/check_captcha_post',
            data: {
                mobile_captcha: form.find('.input-captcha').val(),
                mobile: form.find('.input-mobile').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            if(data.errCode == 0){
                $('.three-steps-indicator .step-b').addClass('active');
                $('.change-step-a').addClass('hide').siblings('.change-step-b').removeClass('hide');
            }else{
                var error_tip = form.find('.error-tip-' + data.errCode);
                if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
            }
        })
    });

    $('body').on('click', '#changeStepBBtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        yqFormCheck.frontCheck.apply(form.get(0));
        $.ajax({
            url: '/Home/user/check_mobile_captcha_update_post',
            data: {
                old_mobile: form.find('[name="old_mobile"]').val(),
                mobile: form.find('.input-mobile').val(),
                mobile_captcha: form.find('.input-captcha').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            if(data.errCode == 0){
                $('.three-steps-indicator .step-c').addClass('active');
                $('.change-step-b').addClass('hide').siblings('.change-step-c').removeClass('hide');
                $('#stepCMobile').text(form.find('.input-mobile').val().replace(form.find('.input-mobile').val().substr(3, 6), '******'));
            }else{
                var error_tip = form.find('.error-tip-' + data.errCode);
                if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
            }
        })
    });


    function getUploadConfig(uploadId){
        var uploadConfig = {
            pasteZone: null,
            dropZone: null,
            url: '/Home/account/img_upload',
            forceIframeTransport: true,
            redirect : '/proxy.html?%s',
            type: 'post',
            dataType: 'json',
            beforeSend: function(e, data) {
                // console.log(data);
            },
            fail: function(){
                yqDialog.simpleDialog('系统繁忙，请稍候再试！', 'fail');
            },
            success: function(data){
                if(data.errCode == 1){
                    yqDialog.simpleDialog('上传错误，请重新上传', 'fail');
                    return;
                }else{
                    var uploadItem = $('#' + uploadId).closest('.upload-item');
                    uploadItem.find('.upload-img-thumbnail').prop({'src': data.data.fileinfo.url}).show();
                    uploadItem.find('.remove-btn').removeClass('force-hide');
//                    uploadItem.find('.upload-img-info').prop({'value': data.data.fileinfo.img_info});
                    setTimeout(function(){
                        uploadItem.find('.upload-img-thumbnail').trigger('blur');
                    }, 0);
                }
            }
        }
        return uploadConfig;
    }

    $('#uploadFront').fileupload(getUploadConfig('uploadFront'));
    $('#uploadBack').fileupload(getUploadConfig('uploadBack'));
    $('#uploadBackZuzhi').fileupload(getUploadConfig('uploadBackZuzhi'));


    $('body').on('click', '.upload-item .remove-btn', function(event){
        event.preventDefault();
        var uploadItem = $(this).closest('.upload-item');
        uploadItem.find('.upload-img-thumbnail').prop({'src': ''}).hide();
        uploadItem.find('.remove-btn').addClass('force-hide');
        setTimeout(function(){
            uploadItem.find('.upload-img-thumbnail').trigger('blur');
        }, 0);
    });


    $('body').on('click', '#submitBtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        if(!yqFormCheck.frontCheck.apply(form.get(0))) return;

        $('#popupRealName').text(form.find('[name="company_name"]').val());
        $('#popupIdCard').text(form.find('[name="company_abbr"]').val());
        var content = $('<div></div>').wrapInner($('#popupConfirmSubmit')).html();
        var d = yqDialog.standardDialog({
            title: '提交审核',
            content: content,
            okValue: '确定',
            ok: function(){
                $.ajax({
                    url: '/Home/account/company_post',
                    data: {
                        'company_name': form.find('[name="company_name"]').val(),
                        'company_abbr': form.find('[name="company_abbr"]').val(),
                        'idcard_img1': form.find('.idcard-img-a').attr('src'),
                        'idcard_img2': form.find('.idcard-img-b').attr('src'),
                        'idcard_img3': form.find('.idcard-img-c').attr('src')
                    },
                    type: 'post',
                    dataType: 'json'
                }).done(function(data){
                    yqFormCheck.reset.apply(form.get(0));
                    if(data.errCode == 0){
                        window.location.reload();
                    }else{
                        var error_tip = form.find('.error-tip-' + data.errCode);
                        if(data.errCode == 6) error_tip.text(data.errMsg);
                        if(error_tip.length) yqFormCheck.backendCheckError.apply(error_tip.get(0));
                    }
                })
            },
            cancelValue: '取消',
            cancel: function(){}
        });
    });

    $('body').on('click', '#appeal_again', function(event){
        $('#realNameForm').show();
        $('#realNameFail').hide();
    });





});