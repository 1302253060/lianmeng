<?php $uri = $_SERVER['REQUEST_URI'];?>
<div id="sidebar" class="sidebar-manager">
    <div class="sidebar-accordion">

        <a class="sidebar-item-work-manage" href="">
            <span class="icon icon-sidebar icon-sidebar-h"></span>
            <span class="text">昨日业绩</span>
        </a>
        <ul class="menu-sub sidebar-ul-work-manage">
            <li><a class="sidebar-item-general <?php if(preg_match('/^\/Home\/userearn\/last/', $uri)) echo 'active';?>" href="/Home/userearn/last">昨日业绩</a></li>
        </ul>

        <a class="sidebar-item-shop-manage" href="">
            <span class="icon icon-sidebar icon-sidebar-f"></span>
            <span class="text">业绩查询</span>
        </a>
        <ul class="menu-sub sidebar-ul-work-manage">
            <li><a class="sidebar-item-shop-list <?php if(preg_match('/^\/Home\/(userearn|Userearn)\/channel/', $uri)) echo 'active';?>" href="/Home/userearn/channel">业绩查询</a></li>
        </ul>

        <a class="sidebar-item-jsy-manage" href="">
            <span class="icon icon-sidebar icon-sidebar-i"></span>
            <span class="text">领取收益</span>
        </a>
        <ul class="menu-sub sidebar-ul-jsy-manage">
            <li><a <?php if(preg_match('/^\/Home\/(money|Money)\/(index|)/', $uri)) echo 'class="active"';?> href="/Home/money/">领取收益</a></li>
        </ul>


        <a class="sidebar-item-appeal-manage" href="">
            <span class="icon icon-sidebar icon-sidebar-n"></span>
            <span class="text">账户信息</span>
        </a>
        <ul class="menu-sub sidebar-ul-appeal-manage">
            <li><a <?php if(preg_match('/^\/Home\/account/', $uri)) echo 'class="active"';?> href="/Home/account/">账户信息</a></li>
        </ul>

        <a class="sidebar-item-appeal-manage" href="">
            <span class="icon icon-sidebar icon-sidebar-o"></span>
            <span class="text">消息中心</span>
        </a>
        <ul class="menu-sub sidebar-ul-appeal-manage">
            <li><a <?php if(preg_match('/^\/Home\/(message|Message)\/index/', $uri)) echo 'class="active"';?> href="/Home/message/index">我的消息</a></li>
        </ul>


    </div>
    <div class="sidebar-mask"></div>
</div>

<script type="text/javascript">
    !function(){
        // 渠道经理侧边栏交互
        if(isIE() && isIE() < 8){}
        else{
            var active_index = $('.sidebar-manager .menu-sub a.active').closest('.menu-sub').index('.sidebar-manager ul');
            $('.sidebar-accordion').accordion({
                active: active_index,
                icons: { "header": "accordion-icon-default", "activeHeader": "accordion-icon-open" },
                animate: 200,
                collapsible: true,
                heightStyle: 'content'
            });
        }
    }();
</script>