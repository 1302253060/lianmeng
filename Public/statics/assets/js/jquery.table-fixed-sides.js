(function($) {
    $.fn.fixedSides = function (options) {
        var config = {
            /**
             * 不需要固定的table
             */
            noFixedClass: 'no_fixed',
            topOffset: 0,
            leftOffset: 9,
            /**
             * 默认固定左边的列数
             */
            leftSideNum:1
        };
        if (options){ $.extend(config, options); }

        return this.each( function() {
            var table = $(this);
            if (table.hasClass(config.noFixedClass)) {
                return;
            }

            if (!table.find('thead').length) {
                return;
            }
            
            var win = $(window), 
            head = $('thead', table),
            body = $('tbody,tfoot', table),
            isFixedHead = false,
            isFixedLeft = false;
            
            var leftSideNum = table.attr('data-leftSide')?table.attr('data-leftSide'):config.leftSideNum;
            table.find('tr').each(function(){
            	var num = 0;
            	$(this).find('td,th').each(function(m){
            		if ( m >= leftSideNum ){
            			return false;
            		}
            		num += parseInt($(this).attr('colspan') || 1);
            	});
            	leftSideNum = Math.max(leftSideNum,num);
            });
            
            
            var div = $('<div style="position:relative;"></div>');
            table
                .before(div)
                .prependTo(div);
            
            var leftSide = $('<div style="position: absolute;z-index: 1;top:0;border:0px;padding:0px;margin:0px;"></div>');
            leftSide
                .appendTo(div)
                .addClass('leftSide')
                .hide();
            
            var leftSideTable = table.clone();
            
            var trStart = {};
            
            leftSideTable.appendTo(leftSide)
            	.addClass(config.noFixedClass)
            	.find('tr').each(function(n_tr){
            		
            		var n_td = trStart['tr'+n_tr] || 0;
            		
            		$(this).find('td,th').each(function(m){
	                	var rowspan = parseInt($(this).attr('rowspan') || 1);
	            		var colspan = parseInt($(this).attr('colspan') || 1);
	            		
	            		n_td += colspan;
	            		
	                    if ( n_td > leftSideNum ) {
	                        $(this).remove();
	                    }
	                    else {
	                    	for ( var i=1;i<rowspan;i++ ){
		            			trStart['tr'+(n_tr+i)] = ( trStart['tr'+(n_tr+i)] || 0 ) + colspan;
		            		}
	                    	
	                    	var width = table.find('tr').eq(n_tr).find('td,th').eq(m).width();
	                    	$(this).width( width + 5 );
	                    	table.find('tr').eq(n_tr).find('td,th').eq(m).width($(this).width());
	                    	
	                    	var height = table.find('tr').eq(n_tr).find('td,th').eq(m).height();
	                    	$(this).height( height + 5);
	                    	table.find('tr').eq(n_tr).find('td,th').eq(m).height($(this).height());
	                	}
	                });
            	});
            
            var leftSideHead = leftSideTable.clone(); 
            leftSideHead.prependTo(leftSide)
	            .addClass(config.noFixedClass)
	            .addClass('leftSideHead')
	            .hide()
	            .css('position','relative')
            	.find('thead tr').each(function(n_tr){
	                $(this).find('td,th').each(function(n_td){
	                    if ( n_td > leftSideNum -1 ) {
	                        $(this).remove();
	                    }
	                    else {
	                    	$(this)
	                    		.width( table.find('tr').eq(n_tr).find('td,th').eq(n_td).width() );
	                	}
	                });
            	});
            	leftSideHead.find('tbody,tfoot').remove();
            
            

            var headTop = head.length && head.offset().top - config.topOffset;
            var headLeft = head.length && head.offset().left;

            
            head
                .addClass('origin')
                .find('tr')
                .clone()
                .prependTo(table)
                .removeClass()
                .addClass('header clone')
                .hide();

            var cloneHead = $('.clone', table);

            function processScroll() {
                if (!table.is(':visible')){
                    return;                 
                }
                
                var scrollTop = win.scrollTop(), 
                    scrollLeft = win.scrollLeft();
                
                //固定左边栏
                if ( scrollLeft <= config.leftOffset ){
                    isFixedLeft = false;
                }
                else{
                    isFixedLeft = true;
                }
                
                if ( isFixedLeft ) {
                    $('.leftSide').show().css('left',scrollLeft-config.leftOffset);
                }
                else {
                    $('.leftSide').hide();
                }
                
                //固定头部
                var t = head.length && head.offset().top - config.topOffset;
                if (!isFixedHead && headTop != t) {
                    headTop = t;
                }
                if (scrollTop >= headTop && !isFixedHead) { 
                    isFixedHead = true; 
                }
                else if (scrollTop <= headTop && isFixedHead){ 
                    isFixedHead = false; 
                }
                
                if (isFixedHead) {
                    leftSideHead
                    	.show()
                        .css('top',scrollTop - cloneHead.offset().top + config.topOffset);
                    leftSideTable.find('thead').hide();
                    cloneHead.show();
                    head.css({'position':'fixed','top':0});
                    if (table.width() != head.width()) {
                        head.css({ 'margin':'0 auto', 'width':table.width()});
                        cloneHead.css({ 'margin':'0 auto', 'width':table.width()});
                        cloneHead.find('th,td').each(function (i, th) {
                            var ths = head.find('th,td');
                            $(ths[i]).css('width',$(th).width());
                            $(th).css('width',$(ths[i]).width());
                        });
                    }

                    if (scrollLeft) {
                        head.css({left: headLeft - scrollLeft});
                    } 
                    else {
                        head.css({left: ''});
                    }
                } 
                else {
                    leftSideHead
                    	.hide()
                        .css('top',0);
                    leftSideTable.find('thead').show();
                    cloneHead.hide();
                    head.css({'position':'static'});
                }
            }
            win.on('scroll', processScroll);
            setTimeout(processScroll,500);
        });
    };
})(jQuery);