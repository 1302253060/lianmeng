<?php
namespace Admin\Model;

use Common\Helper\Arr;
use Common\Helper\Permission;
use Common\Helper\Session;
use Common\Helper\Constant;
use Think\Model;

class HelpModel extends Model {

    const STATUS_ONLINE  = 1;
    const STATUS_OFFLINE = 0;


    public static $aType = array(
        1 => '常见问题',
        2 => '财务问题',
        3 => '推广规范',
    );

}

