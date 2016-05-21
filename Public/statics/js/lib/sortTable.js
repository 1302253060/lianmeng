/**
 * 表格排序
 */

define(function(require, exports, module){

    var yqHelper = require('yqHelper');
    var yqMUP = require('yqModifyUrlParam');

    exports.init = function(){
        $('body').on('click', 'th[data-sort]', function(){
            var sort_field = $(this).data('sort');
            var current_order = yqHelper.getUrlParam('order');
            if(sort_field == current_order){
                var current_orderby = yqHelper.getUrlParam('order_desc');
                if(current_orderby == 'asc'){
                    yqMUP.addUrlParam('order_desc', 'desc');
                }else{
                    yqMUP.addUrlParam('order_desc', 'asc');
                }
            }else{
                yqMUP.removeUrlParam('order_desc');
                yqMUP.addUrlParam('order', sort_field);
            }
            yqMUP.removeUrlParam('page');
            yqMUP.locationRelaod();
        });
    }

});