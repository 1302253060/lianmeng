define(function(require, exports, module){

    var yqHelper = require('yqHelper');

    var urlParam = yqHelper.getAllUrlParam();

    exports.addUrlParam = function(param, value){
        if(param && value){
            urlParam[param] = value;
        }
    }

    exports.removeUrlParam = function(param){
        if(param && typeof urlParam[param] !== 'undefined'){
            delete urlParam[param];
        }
    }

    exports.locationRelaod = function(){
        var dest = window.location.pathname;
        var count = 0;
        for(var i in urlParam) {
            dest += count ? '&' : '?';
            dest += i + '=' + urlParam[i];
            count++;
        }
        window.location.href = dest;
    }

});