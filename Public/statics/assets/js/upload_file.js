$('.uploadfile_clz').click(function() {
    fileupload_id = $(this).attr('id');
    show_id = '#' + fileupload_id + '_show';
    tag_id = '#' + fileupload_id + '_tag';
    post_id = '#' + fileupload_id + '_post';
    md5_id = '#' + fileupload_id + '_md5';
    size_id = '#' + fileupload_id + '_size';
    // v2
    post_id_hidden = '#' + fileupload_id + '_post_hidden';
    $('#' + fileupload_id).fileupload({
        pasteZone: null,
        dropZone: null,
        url: '/admin/file/upload_file',
        dataType: 'json',
        formData: {'postname': $(this).attr('name')},
        beforeSend: function(e, data) {
            $(tag_id).html('正在上传。。。');
        },
        done: function (e, data) {
            $(show_id).html('');

            var file = data.result.fileinfo;
            if (file.error == 0) {
                $('<p/>').html('文件【'+file.org_file_name+'】已经上传').appendTo(show_id);
                $(tag_id).html('已完成上传');
                $(post_id).val(file.org_file_name);
                $(post_id_hidden).val(file.org_file_name);
                var eMD5ID = $(md5_id);
                if (eMD5ID) {
                    eMD5ID.val(file.md5);
                }
                var eSizeID = $(size_id);
                if (eSizeID) {
                    eSizeID.val(file.size);
                }
            } else {
                $(tag_id).html('上传失败');
                $('<p/>').html(file.errmsg).appendTo(show_id);
            }
        }
    });
});
