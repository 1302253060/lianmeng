define(function(require, exports, module){

    var yqHelper = require('yqHelper');
    var yqDialog = require('yqDialog');
    if (typeof(sSrc) == 'undefined') {
        sSrc = '';
    }
    exports.init = function(){
        $('#uploadImgBtn').fileupload({
            pasteZone: null,
            dropZone: null,
            url: '/user/info/img_upload',
            // forceIframeTransport: true,
            redirect : '/proxy.html?%s',
            type: 'post',
            dataType: 'json',
            formData:{'sSrc': sSrc},
            beforeSend: function(e, data){
                // console.log(data);
            },
            fail: function(){
                yqDialog.simpleDialog('系统繁忙，请稍候再试！', 'fail');
            },
            success: function(data){
                if(data.errCode == 1){
                    yqDialog.simpleDialog('只允许上传图片哦！', 'fail');
                    return;
                }else if(data.errCode == 2){
                    yqDialog.simpleDialog('上传图片过大！', 'fail');
                    return;
                }else{
                    $('<div class="upload-item">\
                        <div class="upload-item-inner">\
                            <a class="remove-btn" href=""></a>\
                            <img class="upload-img-thumbnail" src="' + data.data.fileinfo.url + '">\
                        </div>\
                    </div>').insertBefore('.upload-area');
                    setTimeout(function(){
                        $('#uploadImgBtn').closest('.upload-queue').trigger('blur');
                    }, 0);
                }
            }
        });

        $('body').on('click', '#uploadImgBtn', function(){
            var max_size = $(this).data('max-size');
            var item_num = $(this).closest('.upload-queue').find('.upload-img-thumbnail').length;
            if(item_num >= max_size){
                yqDialog.simpleDialog('最多上传' + max_size + '张照片', 'fail');
                return false;
            }
        });

        $('body').on('click', '.upload-item .remove-btn', function(event){
            event.preventDefault();
            $(this).closest('.upload-item').remove();
            setTimeout(function(){
                $('#uploadImgBtn').closest('.upload-queue').trigger('blur');
            }, 0);
        });
    }

});
