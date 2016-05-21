seajs.use(['yqFormCheck', 'yqDialog'], function(yqFormCheck, yqDialog){

    $('body').on('click', '#submitRecipientBtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
        if(!yqFormCheck.frontCheck.call(form.get(0))) return false;
        $(this).button('loading');
        var post_data = {
            name: form.find('[name="name"]').val(),
            mobile: form.find('[name="mobile"]').val(),
            province: form.find('[name="province"]').val(),
            city: form.find('[name="city"]').val(),
            county: form.find('[name="county"]').val(),
            address: form.find('[name="address"]').val(),
            tshirt_size: form.find('[name="tshirt_size"]:checked').val(),
        }
        var _this = this;
        $.ajax({
            url: '/main/recipient',
            type: 'post',
            data: post_data,
            dataType: 'json',
            cache: false
        }).done(function(doc){
            yqFormCheck.reset.call(form.get(0));
            if(doc.errCode == 0){
                yqDialog.simpleDialog('提交成功', 'success');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }else{
                yqFormCheck.backendErrorGeneral.call(form, doc.errCode, doc.errMsg);
            }
        }).always(function(){
            $(_this).button('reset');
        })
    })

});