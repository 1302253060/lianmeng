$(function(){
    var CONFIG = {
        expelTxt     : '开除',
        adjustTxt    : '调整',
        recoverTxt   : '恢复',
        belongType   : 'belong_type',
        pageNum      : 'pageNum',
        expelIDClass : 'expel_id',
        expelType    : 'expel_type',
        expelOpt     : 'expel_opt',
        adjustID     : 'adjustID',
        adjustErr    : 'adjustErr',
        adjustPid    : 'pid',
        async        : false,
        timeout      : 600000
    };
    var $dlg      = null;
    var $adjust   = null;
    var $adjust2  = null;
    var $checkAll = $('.checkAll');
    var $allRow   = $('.rowSingle .select');

    $allRow.on('click',function(){
        if (!$(this).is(':checked')) {
            $checkAll.prop('checked',false);
        };
    });
    //全选
    $checkAll.on('click',function(){
        $obj = $allRow.add($checkAll);
        if ($(this).is(':checked')) {
            $obj.prop('checked',true);
        }else{
            $obj.prop('checked',false);
        }
    });
    $('.level').add($('.'+CONFIG.belongType).add($('.'+CONFIG.pageNum))).change(function(){
        $('#Jsubmit').trigger('click');
    });

    var $level = $('.level');

    //开除
    $row = $('.userRow');
    $multiExpel = $('.multiOpeate');
    $multiExpel.add($row.find('.JOperate')).click(function(){
        var _this   = $(this);
        if (_this.hasClass('single')) {
            $allRow.prop('checked',false);
            _this.parents('td').siblings('.rowSingle').find('.select').prop('checked', true);
        };
        var attr    = Operator.getOperateAttr(_this);
        var id      = attr.id;
        var name    = attr.name;
        var opt     = attr.opt;
        var optName = attr.optName;
        var expelType = $level.val();
        if (id.length == 0) {
            $.alert('请选择要'+optName+'的用户', null,null,null,
                function(){return true;}, null, {'cancelTxt':''});
            return false;
        };
        if (3 == opt) {//调整
            var html = '<div class="dlg_line">ID：<input type="text" class="'+CONFIG.adjustID+'" />'
                     + '<span class="'+CONFIG.adjustErr+'"></span>'
                     + '<input type="hidden" id="'+CONFIG.expelIDClass+'" value="'+id+'" />'
                     + '<input type="hidden" id="'+CONFIG.expelOpt+'" value="'+opt+'" />'
                     + '<input type="hidden" id="'+CONFIG.expelType+'" value="'+expelType+'" /></div>';
            var parentName = '';
            var getZone    = '';
            if (4 == expelType) {
                parentName = '渠道经理';
                getZone = function(){};
            }else if(2 == expelType){
                parentName = '大区经理';
                getZone = Operator.getZone;
            };
            $adjust = $.alert(html,'调整为如下'+parentName,null,getZone,Operator.adjust, Operator.close);
        }else{//开除
            var html = '确定要'+optName+'【'+name+'】吗?'
                     + '<input type="hidden" id="'+CONFIG.expelIDClass+'" value="'+id+'" />'
                     + '<input type="hidden" id="'+CONFIG.expelOpt+'" value="'+opt+'" />'
                     + '<input type="hidden" id="'+CONFIG.expelType+'" value="'+expelType+'" />';
            $dlg = $.alert(html, null,null,null, Operator.expel, Operator.close);
        };
    });

    //操作
    var Operator = {
getZone : function(ele){
            $.ajax({
                url     : '/user/get_zone',
                type    :'post',
                async   : CONFIG.async,
                timeout : CONFIG.timeout,
                dataType: 'json',
                success : function(data) {
                    var sHtml = '<div class="Dlg_Zone">';
                    if (data.result == 0) {
                        $.each(data.data,function(i, name){
                            sHtml += "<span><a class='zone_row' data-id="+i
                                  + " href='javascript: void)(0)'>"+i
                                  +"_"+name+"</a></span>";
                        });
                    };
                    sHtml += '</div>';
                    $(sHtml).appendTo($(ele).find('.dlg-body'));
                    $(document).on('click', '.Dlg_Zone .zone_row',function(){
                        $(this).parents('.Dlg_Zone').find('a.zone_row').removeClass('on');
                        $(this).addClass('on');
                        $(ele).find('input:text.adjustID').val($(this).attr('data-id'));
                    });
                }
            });
        },
        close : function(element) {
            var _this = $(element);
            var sID   = _this.find('#'+CONFIG.expelIDClass).val();
            var id    = sID.split(',');
            $.each(id,function(i){
                $('.select[value='+id[i]+']').prop('checked',false);
            });
            $checkAll.prop('checked',false);
        },
        expel : function(element){
            var _this = $(element);
            var id    = _this.find('#'+CONFIG.expelIDClass).val();
            var type  = _this.find('#'+CONFIG.expelType).val();
            var opt   = _this.find('#'+CONFIG.expelOpt).val();
            $.ajax({
                url     : '/user_change/opt',
                type    :'post',
                data    : {'id':id,'type':type,'opt':opt},
                async   : CONFIG.async,
                timeout : CONFIG.timeout,
                dataType: 'json',
                success : function(data) {
                    $dlg.dtdlg('close');
                    if (0 == data.result) {
                        $.alert('恭喜您，操作成功',null,null,null,function(){
                            location.reload();
                        },null,{'cancelTxt':null});
                    }else{
                        $.error('不好，操作失败啦,请联系开发人员哦~~',null,null,null,function(){
                            return true;
                        },null,{'cancelTxt':null});
                    }
                },
                error: function(XMLHttp, textStatus){
                    $dlg.dtdlg('close');
                    var errMsg = (textStatus=='timeout') ? '警告：网络超时，请刷新重新操作'
                                                         : '警告：失败,请重新操作';
                    $.error(errMsg,null,null,null,function(){
                        location.reload();
                    });
                }
            });
            return false;
        },
        //调整操作第一步
        adjust: function(element) {
            var _this = $(element);
            var id    = _this.find('#'+CONFIG.expelIDClass).val();
            var type  = _this.find('#'+CONFIG.expelType).val();
            var opt   = _this.find('#'+CONFIG.expelOpt).val();
            var adjustID = _this.find('.'+CONFIG.adjustID).val();
            _this.find('.'+CONFIG.adjustErr).html('');
            $.ajax({
                type:'post',
                data: {'type':type,'uid':adjustID},
                dataType : 'json',
                async: CONFIG.async,
                timeout: CONFIG.timeout,
                url : '/user_change/getadjust',
                success: function(data) {
                    if (0 == data.result) {
                        $adjust.dtdlg('close');
                        var MsgHtml = '<div class+"dlg_line">用户名:'+data.data.name+ '</div>'
                                 + '<div class="dlg_line">QQ:'+data.data.qq+ '</div>'
                                 + '<div class="dlg_line">手机:'+data.data.mobile+ '</div>'
                                 + '<div class="dlg_line">加入时间:'+data.data.create_time+ '</div>'
                                 + '<input type="hidden" id="'+CONFIG.adjustPid+'" value="'+data.data.id+'" />'
                                 + '<input type="hidden" id="'+CONFIG.expelIDClass+'" value="'+id+'" />'
                                 + '<input type="hidden" id="'+CONFIG.expelOpt+'" value="'+opt+'" />'
                                 + '<input type="hidden" id="'+CONFIG.expelType+'" value="'+type+'" />';
                        $adjust2 = $.alert(
                            MsgHtml,
                            '确认分配到以下人员',
                            null,
                            null,
                            Operator.adjust2,
                            Operator.close
                        );
                    }else{
                        _this.find('.'+CONFIG.adjustErr).html(data.err_msg);
                    }
                },
                error: function(XMLHttp, textStatus){
                    var errMsg = (textStatus=='timeout') ? '警告：网络超时，请刷新重新操作'
                                                         : '系统错误，请联系管理员';
                    _this.find('.'+CONFIG.adjustErr).html(errMsg);
                }
            });
        },
        //调整操作第二步
        adjust2:function(element){
            var _this = $(element);
            var id    = _this.find('#'+CONFIG.expelIDClass).val();
            var pid   = _this.find('#'+CONFIG.adjustPid).val();
            var type  = _this.find('#'+CONFIG.expelType).val();
            var opt   = _this.find('#'+CONFIG.expelOpt).val();
            $.ajax({
                type:'post',
                data: {'id':id,'type':type,'opt':opt,'pid':pid},
                dataType : 'json',
                async: CONFIG.async,
                timeout: CONFIG.timeout,
                url : '/user_change/opt',
                success: function(data) {
                    $adjust2.dtdlg('close');
                    if (0 == data.result) {
                        $.alert('恭喜您，操作成功',null,null,null,function(){
                            location.reload();
                        },null,{'cancelTxt':null});
                        return false;
                    }
                    $.alert('警告：'+data.err_msg,'错误',null,null,function(){
                        location.reload();
                    });
                },
                error: function(XMLHttp, textStatus){
                    $adjust2.dtdlg('close');
                    var errMsg = (textStatus=='timeout') ? '警告：网络超时，请刷新重新操作'
                                                         : '警告：失败,请重新操作';
                    $.error(errMsg,null,null,null,function(){
                        location.reload();
                    });
                }
            });
        },
        getOperateAttr: function(that){
            var _this = that;
            //找出所选的大区经理
            var $row   = $('.rowSingle .select:checked');
            var id   = '';
            var name = '', tmpName = '';
            $.each($row,function(i,obj){
                tmpName = $(obj).parents('td').siblings('.userName').text();
                id   = $(obj).val() + ',' + id;
                name = tmpName + ',' + name;
            });
            id   = id.substring(0, id.length-1);
            name = name.substring(0, name.length-1);
            var opt     = _this.attr('data-opt');
            var optName = '';
            if (opt == 1) {
                optName = CONFIG.expelTxt;
            }else if(2 == opt){
                optName = CONFIG.releaseTxt;
            }else if (4 == opt){
                optName = CONFIG.recoverTxt;
            }else {
                optName = CONFIG.adjustTxt;
            };
            optName = "<font color='red'>"+optName+"</font>";
            return {'id':id,'name':name,'opt':opt,'optName':optName};
        }
    };
});
