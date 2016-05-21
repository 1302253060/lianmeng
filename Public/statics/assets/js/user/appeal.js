var CONFIG = {
    "appealClass"  : "appeal",
    "installWay"   : "install-way",
    "installEnv"   : "install-env",
    "SWay"         : "installWay",
    "SEnv"         : "installEnv",
    "details"      : "details",
    "detailsBack"  : "details_back",
    "appealInput"  : "appealInput",
    "rows"         : "rows",
    "notice"       : "notice",
    "noticeTxt"    : "txt",
    "successClass" : "succ",
    "errorClass"   : "err",
    "submit"       : "JAppealSubmit",
    "appealType"   : "appeal_type",
//    "idcardImg"    : "idcard_img",
    "materialImg"  : "material_img",
    "materialImgBack": "material_img_back",
    "idcardHidden" : "idcards",
    "materialHidden": "materialHidden",
    "materialBackHidden": "materialBackHidden",
    "uploadifyFile": "uploadify-queue-item",
    "seperator"    : ",",
    "showTips"     : "showTips",
    "submitingTxt" : "提交中，请耐心等候...",
    "submitTxt"    : "提 交",
    "throught"     : "throught",
    "pass"         : "pass",
    "back"         : "back",
    "dlgHide"      : "DlgHide",
    "throughtKey"  : "throughtKey",
    "passKey"      : "passKey",
    "backKey"      : "backKey",
    "redStar"      : "redStar",
    "reply"        : "reply",
    "materialImgQueue" : "material_img-queue",
    "materialImgBackQueue" : "material_img_back-queue",
    "channeLReply" : "channel_reply_img",
    "replyImg"     : "reply_img",
    "replyDlg"     : "replyDlg",
    "lastChance"   : "lastChance",
    "appealItemDiv": "appeal_item_div",
    "appealItem"  : "appeal_item",
    "timeout"      : 5000
};

function showDlg(){
    var w     = $reply.width();
    var h     = $reply.height();
    var left_top = getCenterXY(w,h);
    $('#'+CONFIG.reply).css(left_top);
    $('.shade').css('display','block');
}

function replySelectError(){
    $.error('文件已存在列表当中，请重新选择',null,null,function(){
        $('#'+CONFIG.reply).css({'left':'-9999px'});
    },null,function(){
        showDlg();
        var replyDlg = $('#'+CONFIG.replyDlg).val();
        return replyDlg == 1 ? 'step' : true;
    },{'confirmTxt':''});
}
$(function(){
    $cancel = $("#J_Cancel");
    //取消申诉
    $cancel.click(function(){
        bindCancel($(this));
    });

    function bindCancel($this) {
        var href = $this.attr('data-href');
        $.alert("确定要取消吗?",null,null,null,function(){
            location.href = href;
        });
    }

    var $SWay = $('.'+CONFIG.SWay);
    var $SEnv = $('.'+CONFIG.SEnv);
    var sWayEnvOther = '其它';
    $SWay.change(function(){
        actionSelect($(this),$('.'+CONFIG.installWay));
    });
    $SEnv.change(function(){
        actionSelect($(this),$('.'+CONFIG.installEnv));
    });
    function actionSelect(_this, $input) {
        //选择了其它
        var isOther = sWayEnvOther == $.trim(_this.find('option:selected').text());
        if (isOther) {
            _this.nextAll($input).show();
        }else{
            _this.nextAll($input).hide();
        };
        appealTip($input,null);
    }

    var BASE_UPLOAD = {
        "swf"      : "/statics/uploadify/uploadify.swf",
        "auto"     : false,
        "wmode"    : "transparent",
        "width"    : 102,
        "height"   : 32,
        "fileSizeLimit" :'2MB',
        "buttonImage"  : "/statics/assets/img/btn-upload.png",
        "buttonText"   : '',
        "fileTypeExts" : '*.jpeg;*.jpg;*.png;*.bmp;*.gif',
        "uploader"     : "uploadify",
        "overrideEvents" : ['onSelectError','onDialogClose'],
        "onSelectError"  : function(file,errorCode,errorMsg){
            var limit   = this.settings.queueSizeLimit;
            var maxSize = this.settings.queueSizeLimit;
            switch (errorCode) {
                case -100:
                    $.error("上传数量不得超过" + limit + "个,谢谢！",
                        null,null,null,
                        function(){return true;}
                    );
                    break;
                case -110:
                    $.error("文件 [" + file.name + "] 大小超出限制,谢谢！",
                        null,null,null,
                        function(){return true;}
                    );
                    break;
                case -120:
                    $.error("文件 [" + file.name + "] 大小异常！",
                        null,null,null,
                        function(){return true;}
                    );
                    break;
                case -130:
                    $.error("文件 [" + file.name + "] 类型不正确,请允许上传图片格式文件！",
                        null,null,null,
                        function(){return true;}
                    );
                    break;
            }
            return false;
        },
        "onUploadSuccess": function(file, data, response){
            var data = eval('('+data+')');
            console.log(data);
            var $idcardHidden = $('#'+data.data.hiddenInput);
            $idcardHidden.parents('.msg').find('.'+CONFIG.uploadifyFile)
                .find('.data').html('完成');
            var file_name     = data.data.file_name;
            var val           = $idcardHidden.val();
            append_val        = val + CONFIG.seperator + file_name;
            $idcardHidden.val(append_val);
        },
        "onCancel": function(e, queueID, fileObj){
            var sID = e.id;
            $('#'+sID).find('.fileName').next('span').html('取消');
        }
    };

    /*
     *  上传文件
     * */
//    $idcard        = $("#"+CONFIG.idcardImg);
    $material       = $('#'+CONFIG.materialImg);
    $materialBack   = $('#'+CONFIG.materialImgBack);
//    //身份证
//    var idcard_param = $.extend({},BASE_UPLOAD,{
//        "queueSizeLimit" : 2,
//        "formData"       : {'hiddenInput':CONFIG.idcardHidden},
//        "onSelect"       : function(){
//            appealTip($('#'+CONFIG.idcardImg),null);
//        },
//        "onQueueComplete" : function(){
//           //如果有材料的上传,触发
//           var mLen = $('#'+CONFIG.materialImgQueue)
//                      .find('.'+CONFIG.uploadifyFile+":visible")
//                      .length;
//           if (mLen > 0) {
//               $material.uploadify('upload','*');
//           }else{
//               appealSubmit();
//           };
//        }
//    });
//    $idcard.uploadify(idcard_param);
    //其它资料
    var material_param = $.extend({},BASE_UPLOAD,{
        "queueSizeLimit" : 4,
        "formData"       : {'hiddenInput':CONFIG.materialHidden},
        "onSelect"       : function(){
            appealTip($('#'+CONFIG.materialImg),null);
        },
        "onQueueComplete" : function(){
            //触发材料的上传
            appealSubmit();
        }
    });
    $material.uploadify(material_param);

    //补充资料
    var material_back_param = $.extend({},BASE_UPLOAD,{
        "queueSizeLimit" : 4,
        "formData"       : {'hiddenInput':CONFIG.materialBackHidden},
        "onSelect"       : function(){
            appealTip($('#'+CONFIG.materialImg),null);
        },
        "onQueueComplete" : function(){
            //触发材料的上传
            appealSubmit();
        }
    });
    $materialBack.uploadify(material_back_param);

    /*
     ********************************************************************************
     *  申诉表单认证start
     *  START
     ********************************************************************************
     */
    var VERIFY = {
        'installWay'     : {'name':'安装方式','required':true,'maxlength':20,'minlength':0},
        'installEnv'     : {'name':'安装环境','required':true,'maxlength':20,'minlength':0},
        'details'        : {'name':'详细说明','required':true,'maxlength':500,'minlength':0},
        'throughtKey'    : {'name':'补充说明','required':true,'maxlength':500,'minlength':0},
        'passKey'        : {'name':'驳回原因','required':true,'maxlength':500,'minlength':0},
        'backKey'        : {'name':'资料完善原因','required':true,'maxlength':500,'minlength':0}
    };

    var $appealInput = $('.'+CONFIG.appealInput);
    $appealInput.blur(function(){
        var _this   = $(this);
        //必须是显示有效字段才检查
        if (!_this.is(':visible')) { return false; };
        //如果是reply框且通过，是非必须填的
        if (_this.parents('#'+CONFIG.reply).length > 0) {
            if(_this.parents('#'+CONFIG.reply).find('.'+CONFIG.redStar+':visible').length == 0){
                return false;
            }
        };
        var val     = $.trim(_this.val());
        var key     = _this.attr('data-key');
        var val_len = val.length;
        var param = $.jget(VERIFY,key);
        //非空
        if (param.required == true) {
            if (val == '') {
                appealTip(_this,'请填写'+param.name);
                return false;
            }else {
                appealTip(_this);
            };
        };
        //最大长度
        if (typeof(param.maxlength != 'undefined')) {
            if (val_len > param.maxlength) {
                appealTip(_this,param.name+'长度不得超过'+param.maxlength+'个字');
                return false;
            }else{
                appealTip(_this);
            };
        };
        //最小长度
        if (typeof(param.minlength != 'undefined')) {
            if (val_len < param.minlength) {
                appealTip(_this,param.name+'长度不得少于'+param.minlength+'个字');
                return false;
            }else{
                appealTip(_this);
            };
        };
    }).focus(function(){
        var _this = $(this);
        appealTip(_this,null);
    });

    var $appealItem    = $('.'+CONFIG.appealItem);
    var $appealItemDiv = $('.'+CONFIG.appealItemDiv);

    $appealItem.click(function(){
        appealTip($(this),null);
    });


    //提交
    var $submit = $('#'+CONFIG.submit);
    $submit.click(function(){
        var _this = $(this);
        _this.disabled(CONFIG.submitingTxt);
        $cancel.unbind('click');
        //渠道经理选技术员申诉类型
        if ($('.'+CONFIG.appealItemDiv).length > 0 ) {
            var $item = $('.'+CONFIG.appealItem+":checked");
            if ($item.length == 0 ) {
                appealTip($('.'+CONFIG.appealItem),'请选择申诉类型');
            };
        };
        //input框检测
        $appealInput.trigger('blur');
        //检查是否有上传身份证
//        var $idcardImg = $('#'+CONFIG.idcardImg)
//        var idlen = $idcardImg
//                    .parents('.msg')
//                    .find('.'+CONFIG.uploadifyFile+':visible')
//                    .length;
//        if (idlen == 0) {
//            appealTip($idcardImg,'请上传身份证照片');
//        }else{
//            appealTip($idcardImg,null);
//        };
        //不是必须要上传的
        //检查是否有上传其它材料
        /*
         var $materialImg = $('#'+CONFIG.materialImg)
         var malen = $materialImg
         .parents('.msg')
         .find('.'+CONFIG.uploadifyFile+':visible')
         .length;
         if (malen == 0) {
         appealTip($materialImg,'请上传材料照片');
         }else{
         appealTip($materialImg,null);
         };
         */

        //检测有错的选项
        var errLen = $(this).parents('.content '). find('.'+CONFIG.appealClass)
            .find('.'+CONFIG.notice+'.'+CONFIG.errorClass)
            .length;
        if (errLen > 0) {
            _this.enabled(CONFIG.submitTxt);
            $cancel.click(function(){
                bindCancel($(this));
            });
            return false;
        };
        //照片上传
//        $idcard.uploadify('upload','*');
        //如果有材料的上传,触发
        var mLen = $('#'+CONFIG.materialImgQueue)
            .find('.'+CONFIG.uploadifyFile+":visible")
            .length;
        var mBackLen = $('#'+CONFIG.materialImgBackQueue)
            .find('.'+CONFIG.uploadifyFile+":visible")
            .length;
        if (mLen > 0) {
            $material.uploadify('upload','*');
        } else if (mBackLen > 0) {
            $materialBack.uploadify('upload','*');
        } else{
            appealSubmit();
        }
    });

    function appealSubmit() {
        //安装方式
        var sWay = sWayEnvOther == $.trim($SWay.find('option:selected').text())
            ? $('.'+CONFIG.installWay).val()
            : $SWay.find('option:selected').text();
        //安装环境
        var sEnv = sWayEnvOther == $.trim($SEnv.find('option:selected').text())
            ? $('.'+CONFIG.installEnv).val()
            : $SEnv.find('option:selected').text();
        var data = {
            'user_id'    : $('#user_id').val(),
            'installWay' : sWay,
            'installEnv' : sEnv,
            'appealType' : getAppealType(),
            'details'    : $('.'+CONFIG.details).val(),
            'idcardImg'  : $('#'+CONFIG.idcardHidden).val(),
            'materialImg': $('#'+CONFIG.materialHidden).val(),
            'materialImgBack': $('#'+CONFIG.materialBackHidden).val(),
            'detailsBack'    : $('.'+CONFIG.detailsBack).val(),
            'id'             : $submit.data('id')
        };
        //数据请求
        $.ajax({
            url     : '/user/appeal/appeal',
            type    :'post',
            data    : data,
            async   : false,
            timeout : CONFIG.timeout,
            dataType: 'json',
            success : function(data) {
                $submit.enabled(CONFIG.submitTxt);
                $cancel.click(function(){
                    bindCancel($(this));
                });
                if (data.result == 0) {
                    $.alert("恭喜，申诉提交成功，请耐心等待工作人员处理,谢谢!!!",
                        null,null,null,function(){
                            location.href = data.data.href;
                        },function(){
                            location.href = data.data.href;
                        },{'cancelTxt':''});
                }else{
                    $.error(data.err_msg,null,null,null,
                        function(){return true;}
                        ,null,{'cancelTxt':''});
                };
            }
        });
    }

    function getAppealType(){
        var $appealType = $('#'+CONFIG.appealType);
        if ($appealType.length > 0) {//技术员
            return $appealType.val();
        }
        //渠道经理
        return $('.'+CONFIG.appealItem+':checked').val();
    }

    function replySubmit() {
        var data = {
            'id'         : $reply.find('#handleID').val(),
            'status'     : $reply.find('.status').val(),
            'wangtui_judge': $reply.find('input[name="wangtui_judge"]:checked').val(),
            'pass_back'    : $reply.find('input[name="pass_back"]:checked').val(),
            'details'    : $reply.find('.'+CONFIG.details).val(),
            'replyImg'   : $reply.find('#'+CONFIG.replyImg).val()
        };
        $.ajax({
            url     : 'reply',
            type    :'post',
            data    : data,
            async   : false,
            timeout : CONFIG.timeout,
            dataType: 'json',
            success : function(data) {
                hideReplyDlg();
                if (data.result == 0) {
                    $replySubmit.enabled(CONFIG.submitTxt);
                    $('#'+CONFIG.reply).css({'left':'-9999px'});
                    $.alert("恭喜，操作成功",
                        null,null,null,function(){
                            window.location.reload();
                        },null,{'cancelTxt':''});
                }else{
                    $replySubmit.disabled(CONFIG.submitingTxt);
                    $.error(data.err_msg,null,null,null,
                        function(){
                            location.reload();
                        },
                        null,
                        {'cancelTxt':''}
                    );
                };
            }
        });
    }


    /*
     ********************************************************************************
     *  申诉表单认证start
     *  END
     ********************************************************************************
     */

    function appealTip($this,errMsg){
        var $span = $this.siblings('.'+CONFIG.notice);
        if ($span.length==0) {
            $span = $this.parents('.msg').find('.'+CONFIG.notice)
        };
        if (typeof(errMsg) == 'undefined') {
            $span.addClass(CONFIG.successClass)
                .removeClass(CONFIG.errorClass)
                .find('.'+CONFIG.noticeTxt)
                .html('&nbsp;');
        }else if(errMsg === null){
            $span.removeClass(CONFIG.successClass)
                .removeClass(CONFIG.errorClass)
                .find('.'+CONFIG.noticeTxt)
                .text('');
        }else{
            $span.removeClass(CONFIG.successClass)
                .addClass(CONFIG.errorClass)
                .find('.'+CONFIG.noticeTxt)
                .text(errMsg);
        };
    }

    /*
     * 渠道经理驳回
     */
    $reply           = $('#'+CONFIG.reply);
    $channelAppeal   = $('#'+CONFIG.channeLReply);
    $replySubmit = $reply.find('.dlg-confirm');

    //渠道经理回应
    var channeLReplyParam = $.extend({},BASE_UPLOAD,{
        "queueSizeLimit" : 4,
        "formData"       : {'hiddenInput':CONFIG.replyImg},
        "onSelect"       : function(){
            appealTip($('#'+CONFIG.channeLReply),null);
        },
        "onSelectError"  : function(file,errorCode,errorMsg){
            $('#'+CONFIG.reply).css('left','-9999px');
            var limit   = this.settings.queueSizeLimit;
            var maxSize = this.settings.queueSizeLimit;
            switch (errorCode) {
                case -100:
                    $.error("上传数量不得超过" + limit + "个,谢谢！",
                        null, null, null, null,
                        function(){showDlg(); return 'step';}
                        ,{'confirmTxt':''});
                    break;
                case -110:
                    $.error("文件 [" + file.name + "] 大小超出限制,谢谢！",
                        null,null,null,
                        function(){showDlg(); return true},
                        function(){showDlg();}
                    );
                    break;
                case -120:
                    $.error("文件 [" + file.name + "] 大小异常！",
                        null,null,null,
                        function(){showDlg(); return true},
                        function(){showDlg();}
                    );
                    break;
                case -130:
                    $.error("文件 [" + file.name + "] 类型不正确,请允许上传图片格式文件！",
                        null,null,null,
                        function(){showDlg(); return true},
                        function(){showDlg();}
                    );
                    break;
            }
            return false;
        },
        "onQueueComplete" : function(){
            //触发材料的上传
            replySubmit();
        }
    });
    $channelAppeal.uploadify(channeLReplyParam);

    $throught = $('.'+CONFIG.throught);
    $pass     = $('.'+CONFIG.pass);
    $back     = $('.'+CONFIG.back);
    //补充
    var Tips = '请与技术员实际联系，了解清楚情况，并初步确认为误判后填写以下补充说明并提交，通过率过低将影响你的申诉信誉';
    $(document).on('click','.'+CONFIG.throught,function(){
        showReplyDlg($(this),'补充说明',Tips,CONFIG.throughtKey);
    });
    //驳回
    $(document).on('click','.'+CONFIG.pass,function(){
        showReplyDlg($(this),'驳回原因',Tips,CONFIG.passKey, 1);
    });
    //back
    $(document).on('click','.'+CONFIG.back,function(){
        showReplyDlg($(this),'资料完善说明',Tips,CONFIG.backKey, 1);
    });

    $reply.find('.dlg-confirm').click(function(){
        var _this = $(this);
        if (_this.parents('#reply').find('.'+CONFIG.redStar).is(':visible')) {
            _this.parents('#reply').find('.details').trigger('blur');
        };
        //检查是否有材料
        /***非必填***/
        var $channelInput = $('#'+CONFIG.channeLReply);
        var idlen = $channelInput
            .parents('.msg')
            .find('.'+CONFIG.uploadifyFile+':visible')
            .length;

        //检测有错的选项
        var errLen = $('#'+CONFIG.reply)
            .find('.'+CONFIG.notice+'.'+CONFIG.errorClass)
            .length;
        if (errLen > 0) {
            _this.enabled(CONFIG.submitTxt);
            return false;
        };
        //照片上传
        if (idlen > 0 ) {
            $channelAppeal.uploadify('upload','*');
        }else{
            replySubmit();
        };
    });

    function showReplyDlg($this, text,tips,key, hideUploadFile){
        var id          = $this.attr('data-id');
        var status      = $this.attr('data-status');
        var biaoqian    = $this.attr('data-biaoqian');
        var level       = $this.attr('data-level');
        var back_num    = $this.attr('data-backnum');
        if (parseInt(biaoqian) === 1 && $this.hasClass('throught')) {
            $reply.find('.wangtui_judge').show();
        } else {
            $reply.find('.wangtui_judge').hide();
        }

        var level_1 = parseInt($('#level_1').val());
        var level_2 = parseInt($('#level_2').val());
        if (level == level_1 && $this.hasClass('pass')) {
            $reply.find('.pass_back').show();
        } else if (level == level_2  && $this.hasClass('pass')) {
            $reply.find('.pass_back').show();
            var back_num_left = 1 - parseInt(back_num);
            $reply.find('#back_num').html('(您有' + back_num_left + '次操作机会)');
            if (back_num_left === 0) {
                $reply.find('input[name="pass_back"][value="back"]').attr('disabled', 'disabled');
            }
        } else {
            $reply.find('.pass_back').hide();
        }
        $reply.find('.dlg-header').find('h3').text('请填写'+text);
        $reply.find('.dlg-body').find('.details-name').text(text);
        $reply.find('.dlg-body').find('.details').attr('data-key',key);
        $reply.find('.freeze-body').find('#handleID').val(id);
        $reply.find('.freeze-body').find('.status').val(status);
        $reply.find('.freeze-body').find('.top-tips').text(tips);
        if (typeof(hideUploadFile) != 'undefined' && 1 == hideUploadFile) {
            //驳回
            $reply.find('.DlgMaterial').addClass(CONFIG.dlgHide);
            $reply.find('.'+CONFIG.redStar).show();
        } else {
            //通过，可以不写原因哦
            $reply.find('.DlgMaterial').removeClass(CONFIG.dlgHide);
            $reply.find('.'+CONFIG.redStar).hide();
        };
        var w     = $reply.width();
        var h     = $reply.height();
        var left_top = getCenterXY(w,h);
        $('#'+CONFIG.reply).css(left_top);
        $('.shade').css({
            'display':'block',
            'height':$(document).height()+'px',
            'width' : $(document).width()+'px'
        });
    }

    function hideReplyDlg() {
        $reply.find('.dlg-header').find('h3').text('');
        $reply.find('.details').val('');
        $reply.find('.notice').removeClass(CONFIG.successClass)
            .removeClass(CONFIG.errorClass)
            .find('.txt').html('');
        $channelAppeal.uploadify('cancel','*');
        $reply.find('.'+CONFIG.uploadifyFile).empty();
        $reply.find('.dlg-body').find('.details-name').text('');
        $reply.find('#'+CONFIG.replyImg).val('');
        $reply.find('.dlg-body').find('.details').attr('data-key','');
        $reply.find('.freeze-body').find('#handleID').val('');
        $reply.find('.freeze-body').find('.status').val('');
        $reply.find('.freeze-body').find('.top-tips').text('');
        $reply.find('.DlgMaterial').removeClass(CONFIG.dlgHide);
        $reply.css({'left':'-9999px'});
        $('.shade').css('display','none');
    }

    //close
    $reply.find('.close').click(function(){
        hideReplyDlg();
    });

    if(typeof($('.'+CONFIG.showTips).tips) !== 'undefined'){
        $('.'+CONFIG.showTips).tips({
            'attrKey' : 'data',
            'border'  : '1px solid #e5bb00',
            'css'     : {'padding':'5px 15px','color':'#e5bb00'}
        });
    }



    $.ajaxSetup({ cache: false });
//    function getAppealList(data) {
//        var $body = $('.appeal_list');
//        $body.html('<tr><td colspan=7>数据玩命加载中，请耐心稍后...</td></tr>');
//        //数据缓存
//        var sJson = parseJsonToStr(data);
//        $.ajax({
//            url     : '/user/appeal/get_appeal_list',
//            type    : 'get',
//            data    : data,
//            async   : true,
//            dataType: 'html',
//            success : function(html) {
//                $body.empty().html(html);
//            },
//            timeout: 10000,
//            error: function(){
//                $body.html('<tr><td colspan=7>数据加载失败，请刷新再试一下哦！</td></tr>');
//            }
//        });
//    }

//    if ($('.appeal_list').length > 0) {
//        getAppealList({});
//    };
//
//    $(document).on('click','.prePage .pagination a',function(){
//        getAppealList(parseURL($(this).attr('href')));
//        return false;
//    });
//
//    $(document).on('click','.stats a',function(){
//        getAppealList(parseURL($(this).attr('href')));
//        return false;
//    })

//    $('form.getAppealInfo').submit(function(){
//        getAppealList({'appeal_id': $('.J_appeal_id').val()});
//        return false;
//    });


    var help_appeal_config = {
        'title':'帮技术员申诉',
        'hasTop':true,
        'confirmTxt':'申诉',
        'cancelTxt' :'取消',
        'animate'  : 'top',
        'closeDirect':1,
        'draggable' : false,
        'openHandler'   : function() {
            $('#help_appeal_user_id')
                .val('')
                .focus();
            $('#help_appeal_warning').html('');
        },
        'successHandler' : function() {
            var user_id = $('#help_appeal_user_id').val();
            var warning = $('#help_appeal_warning');
            if (!user_id || (parseInt(user_id) != user_id) || user_id < 10000) {
                warning.html('用户ID/渠道号无效');
                return false;
            }
            $.ajax({
                url     : '/user/appeal/help_appeal',
                type    : 'get',
                data    : {
                    'user_id' : user_id
                },
                async   : true,
                dataType: 'json',
                success : function(data) {
                    if (data.code == 1) {
                        document.location = '/user/appeal/appeal?user_id=' + user_id;
                    } else {
                        warning.html(data.msg);
                        return false;
                    }
                },
                error: function(){
                    warning.html('请求失败，请重试');
                    return false;
                }
            });
        }
    };
    $('.button_help_appeal').click(function() {
        $('#help_appeal').dtdlg(help_appeal_config);
        $('#help_appeal').dtdlg('open');
    });


    //身份证认证，弹框
    var idcard_need_upload = $('#idcard_need_upload').val();
    if (idcard_need_upload != 0) {
        var idcard_button = $('#idcard_button').val();
        var idcard_url = $('#idcard_url').val();
        var idcard_upload_config = {
            'title':'信息提示',
            'hasTop':true,
            'confirmTxt': idcard_button,
            'cancelTxt' :'',
            'animate'  : 'top',
            'closeDirect':1,
            'draggable' : false,
            'listenEnter'   : false,
            'openHandler'   : function() {
                $('#idcard_upload .close').hide();
            },
            'successHandler'    : function() {
                document.location = idcard_url;
            }
        };
        $('#idcard_upload').dtdlg(idcard_upload_config);
        $('#idcard_upload').dtdlg('open');
    }
});
