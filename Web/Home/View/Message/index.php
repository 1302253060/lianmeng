<div class="main-content-body exchange-niubi-page">
    <div class="msg-list-page">
        <div>
            <div class="bread-crumb">我的消息（<span id="unreadMsgCount" class="color-red"><?=$iUnreadCount?></span> / <?=$iAllCount?>）</div>
            <ul class="list msg-list">
                <?php if (!empty($aList)) foreach ($aList as $aVal) { ?>
                    <li <?php if($aVal['status']) echo 'class="read"';?> data-id="<?=$aVal['id']?>">
                        <div class="msg-title-line clearfix">
                            <span class="icon msg-icon"></span>
                            <?=$aVal['title']?>
                            <span class="float-right color-light"><?=$aVal['create_time']?></span>
                        </div>
                        <div class="msg-content"><?=$aVal['content']?></div>
                    </li>
                <?php } ?>

            </ul>
            <div class="pagination">
                <?=$sPagination?>
            </div>
        </div>
    </div>
</div>

<script>
!function(){

    $('body').on('click', '.msg-list li .msg-title-line', function(){
        var line = $(this).closest('li');
        var read = line.hasClass('read');
        if(line.hasClass('active')){
            line.removeClass('active');
        }else{
            line.siblings('li.active').removeClass('active');
            line.addClass('active read');
            if(!read){
                var id = line.data('id');
                $.ajax({
                    url: '/Home/message/read_post',
                    data: {id: id},
                    type: 'post',
                    dataType: 'json'
                }).done(function(data){
                    if(parseInt(data.errCode) == 0){
                        var unread_num = parseInt(data.data.msg_num, 10);
                        $('#unreadMsgCount').text(unread_num);
                        $('.head-bar .head-bar-item.letter .round-num').text(unread_num);
                        if(!unread_num) $('.head-bar .head-bar-item.letter .round-num').hide();
                    }
                });
            }
        }
    });

}();
</script>