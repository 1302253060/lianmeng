<script src="/Public/statics/assets/js/admin_header.js"></script>
<script type="text/javascript">
    function show_or_hidden_menu(obj_id)
    {
        var obj = $('#_left_menu'+obj_id)[0];
        if (!obj) {
            return false;
        }
        var setdata = function()
        {
            var data = LianMeng.localStorage.getItem('left_menu_fav') || ',';
            if (obj.style.display=='none')
            {
                data += obj_id + ',';
            }
            else
            {
                var re = new RegExp (','+obj_id+',','g');
                data = data.replace(re,',');
            }
            if (data==',')
            {
                LianMeng.localStorage.removeItem('left_menu_fav');
            }
            else
            {
                LianMeng.localStorage.setItem('left_menu_fav',data);
            }
        }
        LianMeng.resizeDiv(obj,setdata);
    }
</script>
<div id="left-menu-div">
    <div id="logo-div">
        <a href="javascript:void(0);">
            <img src="/Public/statics/assets/img/logo.png" style="float:left;width:144px;height:38px;" />
        </a>
    </div>
</div>

<div id="leftmenudiv">
    <div id="leftmenu_srcollbar" style="position:absolute;z-index:1;"></div>
    <div id="leftmenu_top_line"></div>
    <div id="leftmenu">
        <div style="padding-bottom:100px;">
            <ul id="leftmenulink" class="ul"></ul>
        </div>
    </div>
</div>

<div id="left-banner-div">
    <ul class="ul" id="menu_ul">
        <script type="text/javascript">
            var _admin_menu = eval('(' + '<?=json_encode($admin_menu)?>' + ')');

            function change_menu(menu_key,a_obj,show_key)
            {
                var menu = _admin_menu;
                var obj = $('#leftmenulink');
                var thismenu = menu[menu_key];
                show_key = show_key || [];
                if (!thismenu)return false;
                if (a_obj){
                    var url = document.location.href.replace(/\#.*/,'');
                    //存在链接，则直接页面跳转
                    if (a_obj.href){
                        if (a_obj.href==url+'#'){
                            //空链接
                        }else if (a_obj.href.replace(/\#.*/,'')==url){
                            //相同链接，或略
                        }else{
                            //返回true，允许页面跳转到href指定url上
                            return true;
                        }
                    }
                    //已在当前菜单上，或略点击
                    if (a_obj.className=='hover') return false;
                }

                var new_title = '';

                var show_key_len = 0;
                if (show_key)show_key_len = show_key.length;


                var show_html = function(keystr,arr,n,islast,leftstr,isfocus)
                {
                    leftstr = leftstr || '';
                    n=n||0;
                    if(n==0) {
                        isfocus = (show_key[0] == menu_key) ? true : false;
                    }
                    var tmphtml = '';
                    var tmpli   = '';
                    var tmparr  = '';
                    var len     = 0;
                    for (var k in arr){
                        if (typeof arr[k] =='object'){
                            len++;
                        }
                    }

                    var i=0;
                    for (var k in arr){
                        if (typeof arr[k] =='object')
                        {
                            i++;
                            tmpli += show_html(
                                keystr+'_'+k,
                                arr[k],
                                n+1,
                                i==len?true:false ,
                                n>1?(leftstr+(islast?'0':'3')):'' ,
                                isfocus?(k==show_key[n+1]?true:false):false
                            );
                        }
                        else if (k!='innerHTML')
                        {
                            tmparr += ' '+k+'="'+arr[k]+'"';
                        }
                    }
                    if (arr['innerHTML'])
                    {
                        if (typeof arr['title'] == 'undefined')
                        {
                            tmparr += ' title="'+arr['innerHTML']+'"';
                        }
                        if (n==0){
                            new_title = arr['innerHTML'];
                        }else{
                            var tagleft = '';
                            var tagright = '';
                            for(var i=0;i<leftstr.length;i++)
                            {
                                tagleft += '<div class="menu_tree_'+leftstr.substr(i,1)+'">';
                                tagright += '</div>';
                            }
                            if (arr['href']){
                                tmparr = '<a'+tmparr+'>'+arr['innerHTML']+'</a>';
                            }else{
                                tmparr = '<font'+tmparr+'>'+arr['innerHTML']+'</font>';
                            }
                            tmparr = tagleft + (n==1||tmpli?'':'<div class="right_nav"></div>') +'<div class="menu_tree_'+(n==1?'title':(islast?'2':'1'))+'">' + tmparr + '</div>' + tagright;
                            tmphtml += '<li'
                                +' class="menu_tree_li'
                                +(tmpli?' menu_tree_btn':'')
                                +(n+1==show_key_len && isfocus?' hover':'')
                                +'">'
                                +(tmpli?'<div class="show_hidden_button" title="展开/收缩子菜单" onclick="show_or_hidden_menu(\''+keystr+'\')"></div>':'')
                                +tmparr
                                +'</li>';
                        }
                    }
                    if (tmpli){
                        if (n>0)
                        {
//                            var left_menu_fav = LianMeng.localStorage.getItem('left_menu_fav')||'';
                            var left_menu_fav = '';
                            tmphtml += '<ul'+(left_menu_fav.indexOf(','+keystr+',')!=-1?' style="display:none;"':'')+' class="ul menu_tree_block" id="_left_menu'+keystr+'">'+tmpli+'</ul>';
                        }
                        else
                        {
                            tmphtml += tmpli;
                        }
                    }

                    return tmphtml;
                }

                var html = show_html('',thismenu);

                if (html){
                    obj.html(html);
                    if (a_obj){
                        var all_a = $('#left-banner-div')[0].getElementsByTagName('a');
                        for(var i=0;i<all_a.length;i++){
                            all_a[i].className = '';
                        }
                        a_obj.className = 'hover';
                    }
                    $('#leftmenu')[0].scrollTop = 0;

                    scroll_left_menu();
                    return false;
                }else{
                    return true;
                }
            }
        </script>
        <?php
        if ($admin_menu)foreach ($admin_menu as $k=>&$v)
        {
            if (is_array($v)){
                if (isset($v['innerHTML']))
                {
                    echo '<li><a onclick="return change_menu(\''.$k.'\',this);"'.($k=='base1'?' class="hover"':'');
                    if ($k==$top_menu)echo ' class="hover"';
                    foreach ($v as $key=>$value){
                        if ($key=='innerHTML' || $key=='perm' || $key=='icon')
                        {
                            continue;
                        }
                        elseif (is_string($value))
                        {
                            echo ' '.$key.'="'.$value.'"';
                        }
                        elseif (!isset($v['href']) && is_array($value) && isset($value['href']))
                        {
                            # 没有链接的话，取子菜单第一个
//                            echo ' href="'.$value['href'].'"';
//                            $v['href'] = $value['href'];
                        }
                    }
                    if (!isset($v['href'])) {
                        echo ' href="#"';
                    }
                    if ( isset($v['icon']) )
                    {
                        $html = '<img src="/Public/statics/assets/img/'.$v['icon'].'" title="'.$v['innerHTML'].'" />';
                    }
                    else
                    {
                        $html = $v['innerHTML'];
                    }
                    echo '><span></span><strong>'.$html.'</strong></a></li>';
                }
            }
        }

        ?>
    </ul>
</div>

<script type="text/javascript">
    var top_menu = '<?php echo $top_menu;?>';
    var menu = <?php echo json_encode($menu)?>;
    change_menu(top_menu,null,menu);

    reset_left_scroll_top();
    init_left_scroll();
    scroll_left_menu();
//    ini_header();

    $('#leftmenu').height($('#left-banner-div').height());
</script>

<div id="login-out-div">
    <a href="/admin/login/out"><img src="/Public/statics/assets/img/logout_64.png" title="安全退出" style="width:32px;height:32px;" /></a>
</div>