<div class="header-top">
    <div class="layout" style="line-height: 32px;">
        <p>
            <?php if ($User && $User->ifLogin()) { ?>
                <a href="/Home/userearn/last/"><?=$User->name?></a>
                |
                <?=$User->id?>
                |
                <a href="/Home/message/index">消息(<?=$iUnreadCount?>)</a>
                |
                <a href="/Home/user/loginout">退出</a>
            <?php } else { ?>
                <a href="/">登录</a> | <a href="/Home/user/register">注册</a>
            <?php } ?>
        </p>
    </div>
</div>
<div class="main-header">
    <div class="head-bar">
        <div class="layout">
            <div class="block-left">
                <a href="/"><img class="logo" src="/Public/statics/img/logo.png" width="144" height="38"></a>
            </div>
            <?php
            $head_nav = array(
                'Index' => array('name' => '首页', 'link' => '/'),
                'Packet' => array('name' => '推广软件', 'link' => '/Home/packet/?type=app'),
                'Anno' => array('name' => '联盟公告', 'link' => '/Home/anno/'),
                'Help' => array('name' => '帮助中心', 'link' => '/Home/help/'),
                'User' => array('name' => '账户中心', 'link' => '/Home/userearn/last/'),
            );
            ?>

            <?php
                if (!$User || !$User->ifLogin()) {
                    unset($head_nav['User']);
                }
            ?>

            <div class="block-right">
                <ul class="clearfix">
                    <?php foreach ($head_nav as $key => $aVal) { ?>
                        <li><a class="<?php if(isset($SITE_HEADNAV) && ucfirst($SITE_HEADNAV) == $key) echo 'active';?>" href="<?=$aVal['link']?>" ><?=$aVal['name']?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>

</div>
