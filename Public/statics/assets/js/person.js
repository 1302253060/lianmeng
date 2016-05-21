var target;
var is_know = false;

function initTarget() {
    target = {
        'id': '',
        'type': '',
        'target': '',
        'page': '',
        'statusContent': '',
        'changeContent': ''
    };
}

function showFreezeHint() {
    $("#cover").show();
    $(".freeze_hint").show().attr("open", "1");
    $("#cover").attr("style", $("#cover").attr("style") + ";_height:" + $(document).outerHeight() + "px");
}

function closeFreezeHint() {
    $("#cover").hide();
    $(".freeze_hint").hide().attr("open", "0");
}

function initWindowFreeze(page) {
    $(".freeze_hint").delegate(".yes", "click", function() {
        postApi();
        var is_know_checkbox = $("#freeze_know");
        if (is_know_checkbox[0].checked) {
            is_know = true;
            setCookie("is_know", "1", 50 * 365 * 24 * 60 * 60);
        }
        closeFreezeHint();
    });
}

function initFreeze(page) {
    $(".polifits").delegate(".freeze", "click", function() {
        initTarget();
        target.id = $(this).attr('_id');
        target.type = 'freeze';

        if (!is_know) {
            is_know = getCookie("is_know");
        }
        if (!is_know) {
            showFreezeHint();
        } else {
            postApi();
        }
    });
}

function initUnfreeze(page) {
    $(".polifits").delegate(".unfreeze", "click", function() {
        initTarget();
        target.id = $(this).attr('_id');
        target.type = 'de_freeze';
        postApi();
    });
}

function postApi() {
    var url = "/user/user_manager/";

    var freeze_reason = $("#freeze_reason").val();
    $.post(url,
        {
            user_id         : target.id,
            freeze_reason   : freeze_reason,
            __action__      : target.type
        }, function(json) {
            alert(json.msg);
            location.reload();
        }, 'json');
}

function setCookie(c_name, value, expiredays)
{
    var exdate = new Date()
    exdate.setDate(exdate.getDate() + expiredays)
    document.cookie = c_name + "=" + escape(value) +
        ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString())
}

function getCookie(c_name)
{
    if (document.cookie.length > 0)
    {
        c_start = document.cookie.indexOf(c_name + "=")
        if (c_start != -1)
        {
            c_start = c_start + c_name.length + 1
            c_end = document.cookie.indexOf(";", c_start)
            if (c_end == -1)
                c_end = document.cookie.length
            return unescape(document.cookie.substring(c_start, c_end))
        }
    }
    return ""
}