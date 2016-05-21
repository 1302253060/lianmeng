$(function(){
$time = null;
$('.export').click(function(){
    $('#export').val(1);
    $download = $('#download');
    $download.dtdlg({
        'hasTop' : true,
        'confirmTxt' : ''
    });
    $download.dtdlg('open');
    $time = setInterval(downloadData, 100);
    return false;
});

function downloadData(){
    $download = $('#download');
    $.ajax({
        url  : '/user_manager/list',
        type : 'post',
        async: true,
        data : {
            'export':1,
            'p_zone' : $("#p_zone").val(),
            'p_level': $("#p_level").val(),
            'name'   : $('#name').val()
            },
        dataType : 'json',
        success: function(data){
            var iStatus = data.status;
            if (0 == iStatus || 1 == iStatus) {//开始下载
                $download.find('.percent').html(data.data);
            }else if(2 == iStatus){//完成
                $download.find('.dlg-body').html('数据下载完成');
                clearInterval($time);
                location.href = '/user_manager/download?file='+data.file;
            }
        }
    });
}
});
