seajs.use(['yqOption', 'yqArea', 'yqFormCheck'], function(yqOption, yqArea, yqFormCheck){

    var WINDOW_WIDTH = $(window).width();

    // click延迟
    FastClick.attach(document.body);

    // 地区三级下拉框
    yqArea.init();

    // 表单检查
    yqFormCheck.init();

    // 非典型链接
    $('body').on('click', '[data-href]', function(){
        var href = $(this).data('href');
        location.href = href;
    });

    // 非活跃链接
    $('body').on('click', 'a.disabled, .btn-disabled, .btn-loading', function(event){
        event.preventDefault();
    });

    // 固定在顶部元素
    var fixCount = 0;
    $('[data-fix="top"]').each(function(){
        if($(this).closest('table').length){
            var classes = $(this).closest('table').attr('class');
            var el = $('<table></table>');
            el.addClass(classes);
        }else{
            var el = $('<div></div>');
        }
        var content = $('<div></div>').wrapInner($(this).clone());
        content.find('[data-fix]').removeAttr('data-fix');
        if($(this).closest('table').length){
            if($(this).find('th').length) var cell = 'th';
            else var cell = 'td';
            $(this).find(cell).each(function(i){
                var width = $(this).outerWidth() / WINDOW_WIDTH * 100 + '%';
                content.find(cell + ':eq(' + i + ')').css({width: width});
            });
        }
        el.append(content.html());
        var fixId = 'fixTop' + fixCount;
        el.attr('id', fixId).css({position: 'fixed', top: 0, left: 0, width: '100%'}).addClass('hide');
        $('#page').append(el);
        fixCount ++;

        var offset = $(this).offset();
        $(this).attr('data-fix-dist', offset.top);
        $(this).attr('data-fix-el', fixId);
    });
    function scrollFixEl(scrollTop){
        $('[data-fix="top"]').each(function(){
            var dist = $(this).data('fix-dist');
            var fixEl = $('#' + $(this).data('fix-el'));
            if(scrollTop > dist){
                fixEl.show()
            }else{
                fixEl.hide()
            }
        });
    }

    $.fn.extend({

        // 表单提交暂时冻结按钮
        button: function(status){
            if(!$(this).hasClass('btn')) return false;
            switch(status){
                case 'loading':
                    var default_text = $(this).data('default-text');
                    var loading_text = $(this).data('loading-text');
                    var width = $(this).css('width');
                    if(!default_text) $(this).data('default-text', $(this).text());
                    if(loading_text) $(this).text(loading_text);
                    $(this).addClass('btn-loading');
                    var width2 = $(this).css('width');
                    if(width > width2) $(this).css({'width': width});
                    break;
                case 'reset':
                    var default_text = $(this).data('default-text');
                    if(default_text) $(this).text(default_text);
                    $(this).removeClass('btn-loading');
                    break;
            }
        }
        
    });

    // 页面滚动事件
    $(window).on('touchmove scroll', function(){
        var scrollTop = $(window).scrollTop();
        scrollFixEl(scrollTop);
    });

});
