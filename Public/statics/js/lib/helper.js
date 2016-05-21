/**
 * helper函数
 */

define(function(require, exports, module){

    exports.getObjectLength = function(obj){
        var size = 0, key;
        for(key in obj){
            if(obj.hasOwnProperty(key)) size++;
        }
        return size;
    },

    exports.getCookie = function(c_name){
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
    },

    exports.setCookie = function(c_name, value, expiredays, path){
        var exdate = new Date()
        exdate.setDate(exdate.getDate() + expiredays)
        if(typeof path === 'undefined') path = '/';
        document.cookie = c_name + "=" + escape(value) +
            ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) +
            ";path=" + path;
    },

    exports.getUrlParam = function(sParam){
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) 
            {
                return sParameterName[1];
            }
        }
    },

    exports.getAllUrlParam = function(){
        var oResult = {};
        var sPageURL = window.location.search.substring(1);
        if (sPageURL) {
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) {
                var sParameterName = sURLVariables[i].split('=');
                oResult[sParameterName[0]] = sParameterName[1];
            }
        }
        return oResult;
    }

    exports.formatNumber = function(str, glue) {
        // 如果傳入必需為數字型參數，不然就噴 str 回去
        if(isNaN(str)) {
            return str;
        }
        // 決定三個位數的分隔符號
        var glue= (typeof glue== 'string') ? glue: ',';
        var digits = str.toString().split('.'); // 先分左邊跟小數點
        var integerDigits = digits[0].split(""); // 獎整數的部分切割成陣列
        var threeDigits = []; // 用來存放3個位數的陣列
        // 當數字足夠，從後面取出三個位數，轉成字串塞回 threeDigits
        while (integerDigits.length > 3) {
            threeDigits.unshift(integerDigits.splice(integerDigits.length - 3, 3).join(""));
        }
        threeDigits.unshift(integerDigits.join(""));
        digits[0] = threeDigits.join(glue);
        return digits.join(".");
    }

});
