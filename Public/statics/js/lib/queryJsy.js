/**
 *
 */

define(function(require, exports, module){

    var SOURCE = [];
    var ID_MAP = {};

    function _inputInit(el){
        el.autocomplete({
            source: SOURCE
        });
    }

    $('body').on('autocompleteselect', '.query-jsy', function(event, ui){
        var container = $(this).closest('.query-form');
        if(!container.length) container = $(this).closest('.form-area');
        if(container){
            var query_jsy_id = container.find('[name="query_jsy_id"]');
            query_jsy_id.val(ID_MAP[ui.item.value]);
        }
    });
    $('body').on('keyup', '.query-jsy', function(){
        var container = $(this).closest('.query-form');
        if(!container.length) container = $(this).closest('.form-area');
        if(container){
            var val = $(this).val();
            var query_jsy_id = container.find('[name="query_jsy_id"]');
            if(ID_MAP.hasOwnProperty(val)){
                query_jsy_id.val(ID_MAP[val]);
            }else{
                query_jsy_id.val('');
            }
        }
    });

    exports.init = function(){
        var el = $('.query-jsy');
        if(el.length){
            if(SOURCE.length){
                _inputInit(el);
            }else{
                $.ajax({
                    url: '/api/get_tec_user_list',
                    type: 'get',
                    data: {col: 2},
                    dataType: 'json'
                }).done(function(data){
                    if(parseInt(data.errCode, 10) == 0){
                        var user_data = data.data.user_data;
                        for(var i in user_data){
                            var temp;
                            temp = user_data[i].name + '(ID:' + user_data[i].id + ')';
                            SOURCE.push(temp);
                            ID_MAP[temp] = user_data[i].id;

                            temp = user_data[i].name + '(QQ:' + user_data[i].qq + ')';
                            SOURCE.push(temp);
                            ID_MAP[temp] = user_data[i].id;

                            temp = user_data[i].name + '(手机:' + user_data[i].mobile + ')';
                            SOURCE.push(temp);
                            ID_MAP[temp] = user_data[i].id;
                        }
                        _inputInit(el);
                    }
                });
            }
        }
    }

});
