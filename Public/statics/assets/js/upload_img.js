$('.uploadimg_clz').click(function() {
    fileupload_id = $(this).attr('id');
    show_id = '#' + fileupload_id + '_show';
    tag_id = '#' + fileupload_id + '_tag';
    post_id = '#' + fileupload_id + '_post';
    // v2
    post_id_hidden = '#' + fileupload_id + '_post_hidden';

    $('#' + fileupload_id).fileupload({
        pasteZone: null,
        dropZone: null,
        url: '/admin/file/upload_image',
        dataType: 'json',
        formData: {'postname': $(this).attr('name')},
        beforeSend: function(e, data) {
            $(tag_id).html('正在上传。。。');
        },
        done: function (e, data) {
            $(show_id).html('');

            var file = data.result.fileinfo;
            if (file.error == 0) {
                // v2
                $('<p/>').html('文件【'+file.org_file_name+'】已经上传').appendTo(show_id);
                $('<img/>').attr({'src':file.url, 'width':'50px', 'height':'50px'}).appendTo(show_id);
                $(tag_id).html('已完成上传');
                $(post_id).val(file.url);
                // v2
                $(post_id_hidden).val(file.url);
            } else {
                $(tag_id).html('上传失败');
                $('<p/>').html(file.errmsg).appendTo(show_id);
            }
        }
    });
});
