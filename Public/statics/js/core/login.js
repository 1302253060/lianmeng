// 登陆框

var $userLoginForm = $("#userLoginForm");
if($userLoginForm.length) {
    passport.use('login', {
        tangram:true
    }, function(magic){
        var login = new magic.passport.login({
            product : "blueray",
            loginType: 1,
            defaultCss:false,//是否加载CSS
            loginMerge:true,//是否合并
            hasRegUrl:true,//是否有注册链接
            autosuggest:true,//是否自动提示
            hasPlaceholder:true,//是否有placeholder
            authsiteLogin:['tsina','renren','qzone','tqq','fetion'],//第三方登录
            sms:true,//短信登录
            u: $('#loginJumpUrl').val(),
            isPhone: false,
            safeFlag: 0,
            staticPage: $('#staticUrl').val()
        });
        login.render('userLoginForm');
    });
}