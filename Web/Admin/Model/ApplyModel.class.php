<?php
namespace Admin\Model;

use Common\Helper\Arr;
use Common\Helper\Permission;
use Common\Helper\Session;
use Common\Helper\Constant;
use Think\Model;

class ApplyModel extends Model {

    const STATUS_ING  = 0;
    const STATUS_SUCC = 1;
    const STATUS_FAIL = 2;

    private static $aSoft = array();

    public static function getSoft($iSoft) {
        if (empty(self::$aSoft)) {
            self::$aSoft = SoftModel::getAllSoft();
        }

        if (!isset(self::$aSoft[$iSoft])) {
            return array();
        }
        return self::$aSoft[$iSoft];
    }

}

