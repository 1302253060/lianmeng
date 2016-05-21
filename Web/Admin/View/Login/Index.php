<!DOCTYPE html>
<html lang="zh-CN" style="background: #2784bd url(/statics/assets/img/bg_line.gif) repeat-x left top; text-align: center;">
<include file="./Web/Admin/View/__Widget__/Head.php" title="联盟—管理后台" />
<body style="background: transparent;">
<div style="margin: 0 auto; text-align: center; width: 500px; margin-top: 100px;">
    <h1 style="margin-bottom: 20px; color: #ffffff;">第二官方运营后台</h1>
</div>
<div style="margin: 0 auto; text-align: center; width: 500px;">

    <form class="form-horizontal" action="/admin/login/index_post" method="post" onsubmit="return LianMeng.form_post(this, '<?=I('get.ret_url') ? : '/admin/'?>');">
        <div style="margin-bottom: 20px;">
            <span style="color: #ffffff; margin-right: 10px;">账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号:</span>
            <input name="username" placeholder="" type="text" />
        </div>
        <div style="margin-bottom: 20px;">
            <span style="color: #ffffff; margin-right: 10px;">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:</span>
            <input name="password" placeholder="" type="password" />
        </div>

        <input type="submit" class="btn" style="color: #000000; width: 150px;" value="登录"/>
    </form>
</div>
</body>