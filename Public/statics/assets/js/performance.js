var toChangeUserId;
var target;
function showHint(){
    $("#cover").show();
    $("#hint").show();
    var left = parseInt(($(window).width() - $("#hint").outerWidth())/2),
        top = parseInt(($(window).height() - $("#hint").outerHeight())/2);

    $("#hint").css({"left":left+"px", "top":top+"px"});
    $("#cover").attr("style",$("#cover").attr("style")+";_height:"+$(document).outerHeight()+"px");
}

function closeHint(){
    $("#cover").hide();
    $("#hint").hide();
}

function initRemark() {

    $(document).delegate(".remark", "click", function() {
        $('#mark_content').val($(this).parent().prev().text());
        $('#expel_form').hide();
        $('#mark_form').show();
        showHint();
        toChangeUserId = $(this).attr('data-userid');
    });

    $(document).delegate(".expel_remark", "click", function() {
        $('#expel_mark_content').val($(this).attr('data-mark'));
        $('#mark_form').hide();
        $('#expel_form').show();
        showHint();
        toChangeUserId = $(this).attr('data-userid');
    });

    $("#hint").delegate("#index_submit", "click", function() {
        var url = "/zone_work/";
        var mark = $("#mark_content").val();
        if(mark == ""){
            alert("亲,备注内容不能为空哦！");
            exit;
        }
        $.post(url,
                {
                    user_id: toChangeUserId,
                    mark: mark,
                    __action__: "mark"
                }, function(json) {
            if (json.msg == "操作成功") {
                alert(json.msg);
                //target.html('<a class="remark" href="#">'+mark+'</a>');
            } else {
                alert(json.msg);
            }
            $("#mark_content").val("");
            closeHint();
            window.location.reload(true);
        }, 'json');
    });

    $("#hint").delegate("#expel_index_submit", "click", function() {
        var url = "/zone_work/hidden";
        var mark = $("#expel_mark_content").val();
        if(mark == ""){
            alert("亲,开除原因不能为空哦！");
            exit;
        }
        $.post(url,
            {
                user_id: toChangeUserId,
                mark: mark
            }, function(json) {
                if (json.status == true) {
                    alert(json.msg);
                } else {
                    alert(json.msg);
                }
                $("#mark_content").val("");
                closeHint();
                window.location.reload(true);
            }, 'json');
    });
}