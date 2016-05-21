<div style="border-bottom:1px solid #ccc;margin:0px -21px 10px -8px;text-align:right;padding:3px 5px;background:#f4f4f4;box-shadow: 0 2px 2px #f0f0f0;">


        <font style="color:#666;">
            欢迎您：
            <?php
            echo \Common\Helper\Session::instance()->member()->username;
            if ( \Common\Helper\Session::instance()->member()->is_super_admin )
            {
                echo ' (<span style="color:#ff9600">超管</span>)';
            }
            ?>
        </font>
        <span id="user_link_div">
    </span> | <a href="/admin/login/out">退出</a> |


</div>