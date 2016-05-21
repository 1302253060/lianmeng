/**
 * 类型检查
 */

define(function(require, exports, module){

    var TYPE_REG = {
        'address': /[\u4e00-\u9fa5]+/,
        'char': /^[a-zA-Z]+$/,
        'char_or_number': /^[a-zA-Z\d]+$/,
        'date': /^\d{4}\-\d{1,2}\-\d{1,2}$/,
        'email': /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/,
        'idcard': /(^\d{15}$)|(^\d{17}([0-9]|X)$)/i,
        'image': /\S+/,
        'mobile': /^1\d{10}$/,
        'number': /^\d+$/,
        'number_positive': /^\d*[1-9]+\d*$/,
        'qq': /^\d{5,12}$/,
        'real_name': /^[\u4e00-\u9fa5]{2,4}$/,
        'text': /\S+/,
        'url': /^https?:\/\/\w+\.\S+$/i,
        'user_id': /^\d{5,}$/,
        'user_name': /^[\u4e00-\u9fa5a-zA-Z0-9]{3,32}$/,
        'verify_code': /^\d{6}$/,
        'zipcode': /^[1-9]\d{5}$/,
        'password': /^[a-zA-Z0-9]{6,30}$/,
        'code': /^[a-zA-Z0-9]{4}$/
    }
    exports.type_reg = TYPE_REG;

    exports.check = function(input, type){
        return TYPE_REG[type].test(input);
    }

});
