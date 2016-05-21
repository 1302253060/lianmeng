$(function(){
    var CONFIG = {
        'placeHoler' : 'regPlaceHoler',
        'regInput'   : 'joinInput'
    };
    var $form = $('.create_user_div');
    var $regLabel = $form.find('.'+CONFIG.placeHoler);
    //默认如果有值，就把label隐藏掉
    $form.find('.'+CONFIG.regInput).each(function(){
        if($.trim($(this).val()) != '') {
            $(this).siblings('.'+CONFIG.placeHoler).hide();
        }
    });

    $regLabel.on('click',function(){
        $(this).siblings('.'+CONFIG.regInput).focus();
    });

    $form.find('.'+CONFIG.regInput).focus(function(){
        var $placeHoler = $(this).siblings('.'+CONFIG.placeHoler);
        $(this).css('color','#000');
        $placeHoler.hide();
    }).blur(function(){
        var val = $.trim($(this).val());
        if (val === '') {
            $(this).css('color','#FFF');
            $(this).siblings('.'+CONFIG.placeHoler).show();
        };
    });
});

