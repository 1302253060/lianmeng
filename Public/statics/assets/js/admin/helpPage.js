$(function(){
    var basic  = {'animate':'top','z_index':30000,'msgAlign':'center'};
    var $FQuestionSave = $('.FQuestionSave');
    $('.sortList').dragsort({
        'dragEnd':function(){
            showSync();
        }
    });
    //添加问题
    $('.addQuestionDetail').click(function(){
        var pid = $(this).attr('pid');
        location.href = '/page/question_list_handle?pid=' + pid;
    });

    $FQuestionSave.click(function(){
        var sortID = getSortList($('.sortList .row:visible'));
        $.ajax({
            type:'post',
            data: {'ids':sortID},
            dataType : 'json',
            url : '/page/sort',
            success: function(data) {
                if (data.result) {
                    $.error('更新失败，请重新再试');
                }else{
                    $.alert('恭喜,同步成功,请到外网检查',null,null,null,function(){
                        location.reload();
                    },null,$.extend({},{'cancelTxt':''},basic));
                    /*
                    $.alert('恭喜,操作成功',null,null,null,function(){
                        location.reload();
                    },null,$.extend({},{'cancelTxt':''},basic));
                    */
                };
            }
        });
    });


    //删除
    $('.FQuestion .delete').click(function(){
        var sHTML = "确定要删除吗?";
        var _this = $(this);
        var $row  = _this.parents('.row');
        var id    = $row.attr('data-id');
        var outID = getRandID();
        $.error( sHTML,null, outID,null,function(){
            $row.hide();
            $('#'+outID).dtdlg('close');
            showSync();
        },null, basic);
    });
    //编辑
    $('.FQuestion .edit').click(function(){
        var _this = $(this);
        var $tar  = _this.parents('.row');
        var id    = $tar.attr('data-id');
        var $title= _this.parents('.row').find('.title');
        var title = $title.html();
        var sHTML = "标题：<span><input type='text' id='editTitle' class='sortTitle' value='"+title+"' /></span>";
        var sID = 'PAGE_EDIT_ID';
        $.alert( sHTML, null,sID,null,function(){
            $('#'+sID).dtdlg('close');
            $title.html($('#editTitle').val());
            $('#sync').show();
        },null, basic
        );
    });

    //添加分类
    var $add = $('.addQuestion');
    $add.click(function(){
        var PID = parseInt($(this).attr('pid'));
        var sHTML = "标题：<span><input id='addQuestionDlg' type='text' class='sortTitle' /></span>";
        var sID = getRandID();
        $.alert(
            sHTML,
            null,sID,null,function(){
                $('#'+sID).find('.dlg-confirm').unbind('click');
                $.ajax({
                    type:'post',
                    data: {'pid':PID,'title':$('#addQuestionDlg').val()},
                    dataType : 'json',
                    url : '/page/ques_add',
                    success: function(data) {
                        $('#'+sID).dtdlg('close');
                        if (data.result) {
                            $.error('添加失败，请重新再试',null,null,null,function(){
                                return true;
                            },null, $.extend({},{'cancelTxt':''},basic));
                        }else{
                            location.reload();
                            /*
                            $.alert('恭喜,添加成功',null,null,null,function(){
                            },null,$.extend({},{'cancelTxt':''},basic));
                            */
                        };
                    }
                });
            },null, basic
        );
    });


    //同步
    $sync = $('#sync');
    $sync.click(function(){
        $(this).html('更新中，请耐心等候').attr('disabled','disabled');
        var sortID   = getSortList($('.sortList .row:visible'));
        var data     = getSortData($('.sortList .row:visible'));
        var deleteID = getSortList($('.sortList .row:hidden'));
        $.ajax({
            type:'post',
            data: {'ids':sortID,'data':data,'delete':deleteID},
            dataType : 'json',
            url : '/page/sync',
            success: function(data) {
                if (data.result) {
                    $.error('更新失败，请重新再试');
                }else{
                    $FQuestionSave.trigger('click');
                };
            }
        });
    });


    function getSortData($row) {
        var ret = {};
        $.each($row, function(i, obj){
            ret[i] = $(obj).find('.title').html();
        });
        return ret;
    }

    function showSync() {
        $('#sync').show();
    }

});
