!function(){

    var index_slides = $('.index-banner .bxslider');
    var index_slides_length = index_slides.find('li').length;

    if(index_slides_length > 1){
        var slider = $(index_slides).show().bxSlider({
            auto: true,
            autoHover: true,
            pause: 3000
        });
        $('body').on('mouseenter', '.bx-pager-link', function(){
            $(this).trigger('click');
        }).on('mouseleave', '.bx-pager-link', function(){
            slider.startAuto();
        });
    }else if(index_slides_length == 1){
        $(index_slides).show().bxSlider({
            auto: false,
            pager: false
        });
    }

    $('body').on('click', '.index-banner .bxslider li', function(e){
        console.info(e);
        var href = $(this).data('href');
        yqReport('banner_click', $(this).data('id'));
        if(href) window.open(href);
    });

    $('body').on('click', '#submitLoginBtn', function(){

        $.ajax({
            url: '/Home/user/login_post',
            data: {
                mobile: $('.form-area').find('[name="mobile"]').val(),
                password: $('.form-area').find('[name="password"]').val(),
                code: $('.form-area').find('[name="code"]').val()
            },
            type: 'post',
            dataType: 'json'
        }).done(function(data){
            if(data.errCode == 0){
                $("#IndexloginTip").html("");
                window.location.href = '/';
            }else{
                $("#IndexloginTip").html(data.msg);
            }
        });
    });

}();




