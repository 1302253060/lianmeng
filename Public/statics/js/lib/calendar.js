/**
 * 日历控件
 */

define(function(require, exports, module){

    var LOCK = {SWITCH_MONTH: false};

    function generateContent(timestamp, data){
        if(!timestamp) timestamp = new Date().getTime();
        var data_processed = {};
        var class_names = {
            2: 'late',
            3: 'on-time'
        }
        if(!!data){
            for(var i in data){
                data_processed[parseInt((i.match(/\-\d+$/)[0]).match(/\d+/)[0], 10)] = class_names[data[i]];
            }
        }
        var date = new Date(timestamp),
            year = date.getFullYear(),
            month = date.getMonth();
        var first_day = new Date(year, month, 1),
            last_day = new Date(year, month + 1, 0);
        var first_day_in_week = first_day.getDay();
        var days = last_day.getDate();
        var temp_tds = [];
        var body = '';
        var head = year + '年' + (month + 1) + '月';

        for(var i = 0; i < first_day_in_week; i++){
            temp_tds.push('<td></td>');
        }
        for(var i = 1; i <= days; i++){
            var class_name = '';
            if('undefined' !== typeof data_processed[i]) class_name = data_processed[i];
            temp_tds.push('<td class="' + class_name + '">'+i+'</td>');
        }
        if(temp_tds.length % 7 > 0){
            var temp_count = 7 - temp_tds.length % 7;
            for(var i = 0; i < temp_count; i++){
                temp_tds.push('<td></td>');
            }
        }
        for(var i in temp_tds){
            if(parseInt(i, 10) % 7 == 0){
                body += '<tr>';
            }
            body += temp_tds[i];
            if((parseInt(i, 10) + 1) % 7 == 0){
                body += '</tr>';
            }
        }
        return {head: head, body: body, timestamp: new Date(year, month).getTime()};
    }

    function calculate(data, timestamp){
        if(!timestamp) timestamp = new Date().getTime();
        var date = new Date(timestamp),
            year = date.getFullYear(),
            month = date.getMonth();
        var last_day = new Date(year, month + 1, 0);
        var days_in_month = last_day.getDate();
        var days = {
            on_time: data.iStatusCount_3,
            late: data.iStatusCount_2
        }
        days.not_checked = days_in_month - (days.on_time + days.late);
        return days;
    }

    $('body').on('click', '[data-calendar="initialized"] .switch-month a', function(event){
        event.preventDefault();
        if(LOCK.SWITCH_MONTH) return;
        LOCK.SWITCH_MONTH = true;
        var timestamp = parseInt($(this).closest('[data-calendar="initialized"]').attr('timestamp'), 10);
        var date = new Date(timestamp),
            year = date.getFullYear(),
            month = date.getMonth();
        var switch_month = $(this).data('switch');
        if('next' == switch_month){
            month += 1;
            if(month > 11){
                month = 0;
                year += 1;
            }
        }else if('prev' == switch_month){
            month -= 1;
            if(month < 0){
                month = 11;
                year -= 1;
            }
        }
        var target_timestamp = new Date(year, month).getTime();
        var el = $(this).closest('[data-calendar="initialized"]');
        $.ajax({
            url: '/channel/work/get_sign_in_data',
            type: 'post',
            data: {timestamp: target_timestamp / 1000},
            dataType: 'json'
        }).always(function(data){
            // TODO: 测试数据
            /*
            data = {},
            data.data = {}
            data.data.aData = {};
            data.data.iStatusCount_2 = 1;
            data.data.iStatusCount_3 = 1;
            */

            if('undefined' !== typeof data.data.aData) var calendar_data = data.data.aData;
            else var calendar_data = '';
            var content = generateContent(target_timestamp, calendar_data);
            var statistics = calculate(data.data, target_timestamp);
            el.attr('timestamp', content.timestamp);
            el.find('.calendar-head-content').html(content.head);
            el.find('.calendar-days').html(content.body);
            LOCK.SWITCH_MONTH = false;
            var popupCalendar = $('#signInRecord');
            popupCalendar.find('.days-on-time').text(statistics.on_time);
            popupCalendar.find('.days-late').text(statistics.late);
            popupCalendar.find('.days-not-checked').text(statistics.not_checked);
        });
    });

    exports.init = function(){
        $('[data-calendar="true"]').each(function(i){
            if($(this).attr('data-calendar') !== 'initialized'){
                var _this = this;
                $.ajax({
                    url: '/channel/work/get_sign_in_data',
                    type: 'post',
                    dataType: 'json'
                }).always(function(data){
                    // TODO: 测试数据
                    /*
                    data = {}
                    data.data = {}
                    data.data.aData = {"2015-01-01":"1","2015-01-02":"2","2015-01-03":"3","2015-01-04":"4"};
                    data.data.iStatusCount_2 = 1;
                    data.data.iStatusCount_3 = 1;
                    */

                    if('undefined' !== typeof data.data.aData) var calendar_data = data.data.aData;
                    else var calendar_data = '';
                    var content = generateContent('', calendar_data);
                    var statistics = calculate(data.data);
                    $(_this).attr('data-calendar', 'initialized');
                    $(_this).attr('timestamp', content.timestamp);
                    $(_this).find('.calendar-head-content').html(content.head);
                    $(_this).find('.calendar-days').html(content.body);
                    var popupCalendar = $('#signInRecord');
                    popupCalendar.find('.days-on-time').text(statistics.on_time);
                    popupCalendar.find('.days-late').text(statistics.late);
                    popupCalendar.find('.days-not-checked').text(statistics.not_checked);
                });
            }
        });
    }

});