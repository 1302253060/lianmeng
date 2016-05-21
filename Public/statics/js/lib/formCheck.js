/**
 * 表单检查
 */

define(function(require, exports, module){

    var yqTypeCheck = require('yqTypeCheck');

    function checkInput(){
        var required = $(this).data('check'),
            type = $(this).data('check-type'),
            max_size = $(this).data('check-max-size'),
            min_size = $(this).data('check-min-size'),
            value = $(this).val();
        if($(this).prop('tagName').toLowerCase() == 'img'){
            value = $(this).attr('src');
        }
        if(required == 'required') required = true;
        else if(required == 'optional') required = false;
        else return false;
        switch(type){
            case 'radio':
            case 'checkbox':
                var name = $(this).attr('name');
                value = $(this).closest('.form-group').find('[name="' + name + '"]:checked').val();
                break;
            case 'upload_img':
                value = $(this).find('.upload-img-thumbnail').length;
                break;
        }
        try{
            if(!required && !value && value !== 0) throw 1;
            else if($.inArray(type, ['radio', 'checkbox', 'select', 'upload_img']) !== -1){
                if(!value) throw -1;
            }else{
                if(!yqTypeCheck.check(value, type)) throw -1;
            }
            if(max_size && String(value).length > max_size) throw -1;
            if(min_size && String(value).length < min_size) throw -1;
            throw 1;
        }catch(code){
            var result = code;
        }
        return result;
    }

    function showError(check){
        var form_group = $(this).closest('.form-group');
        var type = $(this).data('check-type');
        var correct_icon = form_group.find('.icon-form-correct');
        form_group.find('.error-tip').hide();
        if(check == 1){
            $(this).removeClass('input-check-error');
            $(this).siblings('.btn-group.select').find('.dropdown-toggle').removeClass('input-check-error');
            form_group.find('.select').removeClass('input-check-error');
            form_group.find('.error-tip').hide();
            if(correct_icon.length) correct_icon.removeClass('force-hide');
        }else{
            $(this).addClass('input-check-error');
            $(this).siblings('.btn-group.select').find('.dropdown-toggle').addClass('input-check-error');
            form_group.find('.select').addClass('input-check-error');
            form_group.find('.error-tip-front').show();
            if(correct_icon.length) correct_icon.addClass('force-hide');
        }
    }

    function inputBlurHandler(){
        var check = checkInput.call(this);
        if(!check) return false;
        showError.call(this, check);
        return check;
    }

    // 表单检查初始化
    exports.init = function(){
        $('body').on('blur', '.form-area [data-check]', function(){
            inputBlurHandler.call(this);
        });

        $('body').on('change', '.form-area select[data-check]', function(){
            inputBlurHandler.call(this);
        });

        $('body').on('click', '.form-area .form-submit', function(){
            if($(this).hasClass('btn-disabled')) return false;
            if(!exports.frontCheck.apply($(this).closest('.form-area').get(0))) return false;
        });
    }

    // 提交时进行前端验证
    exports.frontCheck = function(){
        if(!$(this).find('[data-check]').length) return true;
        if($(this).find('.error-tip:visible').length) return false;

        var check = 1;
        $(this).find('[data-check]').each(function(){
            if(!$(this).closest('.form-group').is(':visible')) return true;
            /*
            if($(this).closest('.form-group').prevAll('.form-group').find('.input-check-error').length) return false;
            else if($(this).prevAll('.input-check-error').length) return false;
            else if($(this).prevAll('.btn-group.select').find('.input-check-error').length) return false;
            */
            if(check == -1) return false;
            check = inputBlurHandler.call(this);
        });
        return check == 1 ? true : false ;
    }

    // 后端返回错误触发
    exports.backendCheckError = function(){
        var form_group = $(this).closest('.form-group');
        form_group.find('.error-tip').hide();
        form_group.find('input').addClass('input-check-error');
        form_group.find('.dropdown-toggle').addClass('input-check-error');
        form_group.find('.icon-form-correct').addClass('force-hide');
        $(this).show();
    }

    // 检查后端返回错误，若匹配则提示，若无匹配则作默认提示
    exports.backendErrorGeneral = function(errCode, errMsg){
        var error_tip = $(this).find('.error-tip-' + errCode);
        if(error_tip.length){
            var form_group = error_tip.closest('.form-group');
            form_group.find('input, .dropdown-toggle, select').addClass('input-check-error');
            form_group.find('.icon-form-correct').addClass('force-hide');
            error_tip.show();
        }else{
            $(this).find('.error-tip-general').text(errMsg).show();
        }
    }

    // 重置错误提示
    exports.reset = function(){
        $(this).find('.error-tip').hide();
        $(this).find('.input-check-error').removeClass('input-check-error');
    }

});
