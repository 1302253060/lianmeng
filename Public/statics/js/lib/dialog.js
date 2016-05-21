/**
 * 弹出框 based on artDialog
 */

define(function(require, exports, module){

    var DIALOG_HISTORY = {}

    // 简单提示框
    exports.simpleDialog = function(text, icon){
        /**
        * text 文字
        * icon 图标(success / fail)
        */
        if(!text) return false;
        var icon_class = {
            tick: ['success', 'tick'],
            cross: ['fail', 'cross']
        }
        if($.inArray(icon, icon_class['tick']) !== -1){
            text = '' + text;
        }else if($.inArray(icon, icon_class['cross']) !== -1){
            text = '' + text;
        }
        var d = dialog({
            skin: 'simple-dialog',
            content: text
        }).show();
        setTimeout(function(){
            d.close().remove();
        }, 2000);
        return d;
    }

    // 通用提示框
    exports.commonDialog = function(option){
        /**
        * option.title 标题
        * option.icon 图标(confirm / alert)
        * option.content 内容
        * option.okValue 确定按钮文字
        * option.ok 确定按钮事件
        * option.cancelValue 取消按钮文字
        * option.cancel 取消按钮事件
        * option.width 弹出框宽度（覆盖默认宽度）
        */
        if($.type(option) !== 'object') return false;
        var dialog_html;
        var cached_dialog = false;
        if(/^#/.test(option['content'])){
            if(typeof DIALOG_HISTORY[option['content'].replace('#', '')] !== 'undefined'){
                cached_dialog = DIALOG_HISTORY[option['content'].replace('#', '')];
            }else{
                dialog_html = $(option['content']).css({'display': 'block'}).remove();
                var temp_html = $('<div></div>').append(dialog_html);
                option['content'] = temp_html.html();
            }
        }
        if(cached_dialog){
            var d = cached_dialog;
        }else{
            var icon_class = {
                question: ['confirm', 'question'],
                exclamation: ['alert', 'exclamation']
            }
            var body = '';
            var class_name = 'common-dialog';
            if(option['title']){
                body += '<div class="size-large">';
                if($.inArray(option['icon'], icon_class['question']) !== -1){
                    body += '';
                }else if($.inArray(option['icon'], icon_class['exclamation']) !== -1){
                    body += '';
                }
                body += option['title'] + '</div>';
            }
            if(option['content']){
                body += '<p class="margin-top-10">' + option['content'] + '</p>';
            }
            body += '<button i="close" class="ui-dialog-close" title="cancel">×</button>';
            if(option.bigBtn) class_name += ' dialog-big-btn';
            var d = dialog({
                skin: class_name,
                content: body,
                okValue: option['okValue'],
                ok: option['ok'],
                cancelValue: option['cancelValue'],
                cancel: option['cancel'],
                onshow: option['onshow']
            });
            if(option['width']) d.width(option['width']);
            if($.type(dialog_html) === 'object') DIALOG_HISTORY[dialog_html.get(0).id] = d;
        }
        d.showModal();
        return d;
    }

    // 标准弹出框
    exports.standardDialog = function(option){
        /**
        * option.title 标题
        * option.content 内容
        * option.okValue 确定按钮文字
        * option.ok 确定按钮事件
        * option.cancelValue 取消按钮文字
        * option.cancel 取消按钮事件
        * option.width 弹出框宽度（覆盖默认宽度）
        */
        if($.type(option) !== 'object') return false;
        var dialog_html;
        var cached_dialog = false;
        if(/^#/.test(option['content'])){
            if(typeof DIALOG_HISTORY[option['content'].replace('#', '')] !== 'undefined'){
                cached_dialog = DIALOG_HISTORY[option['content'].replace('#', '')];
            }else{
                dialog_html = $(option['content']).css({'display': 'block'}).remove();
                var temp_html = $('<div></div>').append(dialog_html);
                option['content'] = temp_html.html();
            }
        }
        var skin = 'standard-dialog';
        if(option.skin) skin += ' ' + option.skin;
        if(cached_dialog){
            var d = cached_dialog;
        }else{
            var d = dialog({
                skin: skin,
                title: option['title'],
                content: option['content'],
                okValue: option['okValue'],
                ok: option['ok'],
                cancelValue: option['cancelValue'],
                cancel: option['cancel'],
                onshow: option['onshow']
            });
            if(option['width']) d.width(option['width']);
            if($.type(dialog_html) === 'object') DIALOG_HISTORY[dialog_html.get(0).id] = d;
        }
        d.showModal();
        return d;
    }

    // 简洁弹出框
    exports.blankDialog = function(option){
        option['bigBtn'] = true;
        return exports.commonDialog(option);
    }

    // 气泡
    exports.tip = function(type, content, align, width){
        align = align || 'bottom';
        var d = dialog({
            skin: 'yq-tip ' + type + '-tip',
            content: content,
            align: align
        });
        if(width) d.width(width);
        d.show(this);
        return d;
    }

});
