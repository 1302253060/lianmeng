/**
 * 公共函数JS文件
 */

function getCenterXY(w,h){
    var w_w = $(window).width();
    var w_h     = $(window).height();
    var s_top   = $(window).scrollTop();
    var ret_top = (w_h-h)/2 < 0 ? 0 : (w_h-h)/2;
    ret_top += s_top;
    return { "left":(w_w-w)/2 +"px","top":ret_top+"px" };
}

function check_mobile(mobile) {
    var re = /^\d{11}$/;
    if(!mobile || !mobile.length || !re.test(mobile)) {
        return false;
    }
    return true;
}

function check_qq(qq) {
    var re = /^\d{5,12}$/;
    if(!qq || !qq.length || !re.test(qq)) {
        return false;
    }
    return true;
}

function getSortList($row, key) {
    if (typeof(key) == 'undefined') { key = 'data-id'; }

    var ret = '';
    $.each($row, function(i, obj){
        ret += $(obj).attr(key) + ',';
    });
    return ret;
}

function getRandID(){
    return 'dlg' + parseInt(Math.random(100,999)*1000);
}
function parseURL(sURL){
    sURL = sURL.substr(sURL.indexOf('?')+1);
    var aURL = sURL.split('&');
    var json = {};
    for (var i = 0; i < aURL.length; i++) {
        var aItem = aURL[i].split('=');
        for (var j = 0; j < aItem.length; j++) {
            json[aItem[j]] = aItem[++j];
        };
    };
    return json;
}

function parseJsonToStr(json){
    var str = '';
    $.each(json,function(i, data) {
        str += (i + '|' + data);
    });
    return str;
}

$(function(){
    $.jget = function(json,key) {
        var val = false;
        if (typeof(key) == 'undefined') return json;
        $.each(json,function(k,v){
            if (k == key) {
                val = v;
                return false;
            };
        })
        return val;
    }
    $.fn.disabled = function(txt){
        $(this).attr('disabled','disabled').text(txt);
    }
    $.fn.enabled = function(txt){
        $(this).removeAttr('disabled').text(txt);
    }
});
