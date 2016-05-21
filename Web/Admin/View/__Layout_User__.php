<!DOCTYPE html>
<html lang="en">
<?php
$title = !empty($title) ? $title : '第二官方—管理后台';
?>
<include file="./Web/Admin/View/__Widget__/Head.php" title='{$title}' />
<body>


<div class="container-fluid">
    <div class="left-content">
        <include file="./Web/Admin/View/__Widget__/UserSide.php" />
    </div>
    <div class="right-content" style="margin-left: 196px;">
        <div class="right-header">
            <include file="./Web/Admin/View/__Widget__/Header.php" />
        </div>
        <div class="right-main">
            <?php
            if (!\Common\Helper\Session::instance()->member()->bCurrentPerm || $sMainTPL === null) {
                echo "暂无权限访问，请联系管理员开通权限";
            } else {
                require_once $sMainTPL;
            }
            ?>
        </div>
        <div class="right-footer" style="margin: 10px auto;text-align: center;">
            <include file="./Web/Admin/View/__Widget__/Footer.php" />
        </div>
    </div>
</div>

<!--end content-->
<script src="/Public/statics/assets/js/jquery.ui.datepicker-zh-CN.js" type="text/javascript"></script>
<script>
    $(function() {
        LianMeng.iniHtml();
        $( ".datepicker" ).datepicker( $.datepicker.regional[ "zh-CN" ] );
        $( "#locale" ).change(function() {
            $( ".datepicker" ).datepicker( "option",
                $.datepicker.regional[ $( this ).val() ] );
        });

        //监听footer的位置
        var height_window = $(window).height();
        var height_header = $('.right-header').outerHeight(true);
        var height_footer = $('.right-footer').outerHeight(true);
        $('.right-main').css('min-height', height_window - height_header - height_footer - ($('.right-main').outerHeight(true) - $('.right-main').height())*2 - 20);
    });
</script>

</body>
</html>

