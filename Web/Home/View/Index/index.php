<div class="main-index">
<div class="index-banner">
    <div class="banner-slides">
        <ul class="bxslider hide">
            <?php
            if(!count($aActivity)){
                $aActivity = array(
                    array('index_img' => '/Public/statics/img/banner/default.png', 'background' => '#2284c8'),
                );
            }
            ?>
            <?php foreach ($aActivity as $List): ?>
                <li data-id="<?=$List['id']?>" data-href="#" style="background-color: #2284c8;">
                    <div class="img-center" style="background-image: url('<?=$List['index_img']?>');">
                        <div class="img-left" style="background-image: url('<?=$List['index_img']?>');"></div>
                        <div class="img-right" style="background-image: url('<?=$List['index_img']?>');"></div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="banner-top">
        <div class="layout">
                <?php  if ($User && $User->ifLogin()) { ?>
                    <div class="user-info-box">
                        <div class="title"><span class="name-container"><?=$User->name?></span>，你好！</div>

                        <p>
                            欢迎登录第二官方
                        </p>
                        <a class="btn btn-big btn-block account-center-btn" href="/Home/userearn/last">快速进入账户中心</a>

                    </div>
                <?php } else { ?>
                    <div class="user-login-box">

                        <div class="login-title">登录 <span><a href="/Home/user/register">立即注册</a></span></div>
                            <p id="IndexloginTip"></p>
                            <div class="login-form form-area"">
                            <input class="input-text input-username" placeholder="请输入手机号" name="mobile">
                            <input class="input-text input-password" style="margin-top: 6px;" type="password" placeholder="请输入密码" name="password">
                            <input class="input-text input-code" style="margin-top: 17px;" placeholder="请输入验证码" name="code">
                            <img id="img-code" class="img-code" style="margin-top: 17px;margin-left: 1px;" src="/Home/code/index" width="94" height="37" onclick="reImg();">
                        </div>

                        <div class="login-tig">
                            <span><input style="float: left;" type="checkbox" name="need_update" value="true" <?php if(!empty($bNeedUpdate)) echo 'checked="checked"';?>>记住账号</span>
                            <span><a href="/Home/user/forget_password">忘记密码？</a></span>
                        </div>

                        <div class="login-button">
                            <a href="#" id="submitLoginBtn"></a>
                        </div>
                    </div>
                <?php } ?>
        </div>
    </div>
</div>

<div class="index-content">
    <div class="layout clearfix">
        <div class="block-middle">
            <div class="block-title clearfix">
                <div class="title">联盟优势</div>
            </div>

            <div class="promote-process clearfix">
                <div class="step">
                    <div class="icon icon-promote icon-promote-pen"></div>
                    <div class="icon-promote-text">
                        <p class="icon-promote-text-title">业绩查询</p>
                        <p class="icon-promote-text-content">随时查询渠道与子渠道推广数据，实时监控</p>
                    </div>
                </div>
                <div class="step">
                    <div class="icon icon-promote icon-promote-download"></div>
                    <div class="icon-promote-text">
                        <p class="icon-promote-text-title">渠道管理</p>
                        <p class="icon-promote-text-content">平台拥有强大便捷的渠道管理体系</p>
                    </div>
                </div>
                <div class="step">
                    <div class="icon icon-promote icon-promote-money"></div>
                    <div class="icon-promote-text">
                        <p class="icon-promote-text-title">领取收益</p>
                        <p class="icon-promote-text-content">收益一键领取，方便提现与日常日常生活需要</p>
                    </div>
                </div>
                <div class="step">
                    <div class="icon icon-promote icon-promote-wallet"></div>
                    <div class="icon-promote-text">
                        <p class="icon-promote-text-title">收入保障</p>
                        <p class="icon-promote-text-content">国内最大的联盟体系，保证您的收入稳定性</p>
                    </div>
                </div>
            </div>

            <div class="block-title clearfix">
                <div class="title">软件推广</div>
                <a class="right" href="/Home/packet/">更多</a>
            </div>

            <div class="promote-res clearfix">
                <?php $i = 0; if (!empty($aSoft)) foreach ($aSoft as $aVal) { ++$i; ?>
                <div class="soft <?php if ($i % 4 == 0) { echo "margin-right-0"; } ?>">
                    <div class="icon-soft">
                        <img src="<?=$aVal['logo']?>" width="69" height="69">
                    </div>
                    <div class="promote-res-text">
                        <p class="promote-res-text-title"><?=$aVal['name']?></p>
                        <p class="promote-res-text-content"><span><?=$aVal['price'] * \Common\Helper\Constant::NIUBI_RANK?></span>流量/台</p>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>

    </div>
</div>
</div>

<link rel="stylesheet" type="text/css" href="/Public/statics/vendor/jquery.bxslider/jquery.bxslider.css">
<link rel="stylesheet" type="text/css" href="/Public/statics/css/login.css">
<script type="text/javascript" src="/Public/statics/vendor/jquery.bxslider/jquery.bxslider.min.js"></script>



<script type="text/javascript">
    function reImg(){
        var img = document.getElementById("img-code");
        img.src = "/Home/code/index?rnd=" + Math.random();
    }
</script>