<div class="main-footer">
    <script type="text/javascript">
        !function(){
            if(typeof NO_FOOT_ADJUSCT !== 'undefined' && NO_FOOT_ADJUSCT){
            }else if(!isMobile){
                var window_height = $(window).height(),
                    body_height = $('body').outerHeight(),
                    foot_height = 111;
                var foot_adjust = (body_height + foot_height) < window_height ? true : false ;
                if(foot_adjust) $('.main-footer').addClass('stick-to-bottom');
            }
        }();
    </script>
    <div class="layout clearfix">
        <div class="block-left">
            <p>
                <a href="#">关于我们</a>
                &nbsp;
                |
                &nbsp;
                <a href="#">商务合作</a>
                &nbsp;
                |
                &nbsp;

            </p>
            <p class="size-small margin-top-10">©<?=date('Y', time())?> 第二官方 | <a href="#">用户协议</a></p>
        </div>
        <div class="block-right clearfix">
            <div class="contact-info contact-mail">
                <div class="icon icon-footer icon-footer-mail"></div>
                第二官方邮箱<br>
                735774793@qq.com
            </div>
            <div class="contact-info contact-tel">
                <div class="icon icon-footer icon-footer-phone"></div>
                028-87774707<br>
                服务时间：9:00 - 21:00
            </div>
        </div>
    </div>
</div>


<div id="greyMask"></div>



<script type="text/javascript" src="/Public/statics/vendor/artDialog/dist/dialog.js"></script>
<script type="text/javascript" src="/Public/statics/vendor/seajs/sea.js"></script>
<script type="text/javascript" src="/Public/statics/js/core/seaConfig.js"></script>


<script type="text/javascript" src="/Public/statics/js/core/default.js"></script>

<script>
seajs.use('/Public/statics/js/core/default.js');
<?php if(!empty($SITE_FOOT_JS) && is_array($SITE_FOOT_JS)):?>
<?php foreach($SITE_FOOT_JS as $sJsPath):?>
seajs.use('<?=$sJsPath?>');
<?php endforeach;?>
<?php endif;?>
</script>

