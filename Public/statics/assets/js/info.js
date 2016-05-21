/*
 * 地推项目个人用户信息
 *
 */
(function($){
    //全局配置文件
    var CONFIG = {
        'editTxt' : '修改',
        'backTxt' : '返回'
    };
    //用户资料：基本信息--start
    var $EditBasic = $('#J_Edit_Basic'),
        btnTxt = '';
    $EditBasic.text(CONFIG.editTxt);
    $EditShow = $('.myAccount .basicEdit').add($('.myAccount li.submit'));//修改需要显示的
    $DefaultShow = $('.myAccount .basicInfo');//默认显示的
    $EditBasic.on('click',function(){
        btnTxt = $(this).text();
        if (CONFIG.editTxt == btnTxt) {
            $DefaultShow.hide();
            $EditShow.show();
            $(this).text(CONFIG.backTxt);
        }else {
            $DefaultShow.show();
            $EditShow.hide();
            $(this).text(CONFIG.editTxt);
        };
    });
    delete $EditBasic;

    //初始化省份,城市
    var init_province = $("#init_province").val() || '';
    var init_city = $("#init_city").val() || '';
    pc_init(init_province);
    var obj_province = $("#province");
    obj_province.change(function() {
        pc_change(obj_province,obj_province.val());
    });
    pc_change(obj_province,init_city);

    $("#show_bind_mobile").click(function() {
        var mobile_ok = $(this).attr('mobile_ok') || 0;
        window.YQ_BindMobile.show_bind_mobile_layer(mobile_ok);
    });

})(jQuery);
