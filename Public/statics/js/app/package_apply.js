seajs.use(['yqFormCheck', 'yqDialog', 'yqTypeCheck'], function(yqFormCheck, yqDialog, yqTypeCheck){

    $('body').on('click', '#submitApplyBtn', function(event){
        event.preventDefault();
        var form = $(this).closest('.form-area');
//        if(!yqFormCheck.frontCheck.apply(form.get(0))) return;

        aSoft = [];
        form.find('[name="soft"]:checked').each(function(){
            var sfruit = $(this).val();
            aSoft.push(sfruit);
        });

        $.ajax({
            url: '/Home/package/apply_post',
            data: {
                num: form.find('[name="num"]').val(),
                other: form.find('[name="other"]').val(),
                soft: aSoft
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            yqFormCheck.reset.apply(form.get(0));
            if(data.errCode == 0){
                window.location.href = '/Home/package/apply_list';
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
            url: '/Home/package/edit_post',
            data: {
                'name': form.find('[name="name"]').val(),
                'mark': form.find('[name="mark"]').val(),
                'channel_id': form.find('[name="channel_id"]').val()
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

});
