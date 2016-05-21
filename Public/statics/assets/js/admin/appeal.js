$(function(){
    var time = 100;
    function show($item) {
        $item.show();
        $item.animate({
            'right':0
        }, time);
    }

    function hide($item) {
        var width   = $item.width();
        $item.animate({
            'right': -(width + 20) +'px'
        }, time,null,function(){
            $item.show();
        });
    }

    var $quickReply = $('.quickReply');
    hide($quickReply);

    //显示出来
    $(document).on('click',".appealReply",function(){
        show($quickReply);
    });

    $(document).on('keydown','.appealReply',function(){
        hide($quickReply);
    });

    $('body').click(function(){
        hide($quickReply);
    });

    $quickReply.click(function(e){
        e.stopPropagation();
    });

    $('.quickReply a').click(function(){
        $('.appealReply').val($(this).html()).trigger('blur');
        hide($quickReply);
    });
});
