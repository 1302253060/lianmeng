!function(){
    var option = {
        base: '/Public/statics/js/',
        alias: {
            'yqOption': 'lib/option.js',
            'yqHelper': 'lib/helper.js',
            'yqDialog': 'lib/dialog.js',
            'yqTypeCheck': 'lib/typeCheck.js',
            'yqFormCheck': 'lib/formCheck.js',
            'yqImgUpload': 'lib/imgUpload.js',
            'yqModifyUrlParam': 'lib/modifyUrlParam.js',
            'yqArea': 'lib/area.js',
            'yqCalendar': 'lib/calendar.js',
            'yqQueryJsy': 'lib/queryJsy.js',
            'yqSortTable': 'lib/sortTable.js'
        }
    }
    var timestamp = parseInt(new Date().getTime()/1000/300, 10)*300;
    for(var i in option.alias){
        option.alias[i] += '?' + timestamp;
    }
    seajs.config(option);
}();