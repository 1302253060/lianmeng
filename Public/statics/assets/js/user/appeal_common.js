
(function($){
    /*++++++++++++++++++++++++++++++++++++++++++++++++++
     * foxibox
     *++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    $("a[rel]").foxibox({
        'speed' : 'fast',
        'title' : false
    });

    //最后一次机会
    $('.lastChance').click(function(){
        var href = $(this).attr('href');
        $.alert('您还有最后一次机会申诉，请填写正确有效资料，提高申诉成功率','有情提示',null,
            null,function(){
                location.href = href;
            },null);
        return false;
    });
 })(jQuery);
