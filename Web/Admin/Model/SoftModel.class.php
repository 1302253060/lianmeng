<?php
namespace Admin\Model;

use Common\Helper\Arr;
use Common\Helper\Permission;
use Common\Helper\Session;
use Common\Helper\Constant;
use Think\Model;

class SoftModel extends Model {

    const STATUS_ONLINE = 1;
    const STATUS_OFFLINE = 0;

    const TYPE_PC  = 0;
    const TYPE_APP = 1;

    /**
     * 返回每款软件的 + 渠道号后的名字
     * @param $sPackName
     * @param $iSoft
     * @param $iUserID
     * @param bool $bFormatName 是否直接返回格式化之前的文件名
     * @return string
     */
    public static function generateDownloadName($sPackName, $iSoft, $iUserID, $bFormatName = false)
    {
        $i     = strrpos($sPackName, '.');
        $sName = substr($sPackName, 0, $i);
        $sExt  = substr($sPackName, $i);

        switch ($iSoft) {
            case 1011: //pps
                $sFormatName = $sName . '_%d';
                break;
            default:
                $sFormatName = $sName . '_%d';
                break;
        }
        return ($bFormatName ? $sFormatName : sprintf($sFormatName, $iUserID)) . $sExt;
    }


    /**
     * @param Item_Soft $ItemSoft
     * @param Item_User $User
     *
     * @return string
     */
    public static function generateDownloadUrl($ItemSoft, $User)
    {
        return Constant::CDN_URL . self::generateDownloadName($ItemSoft->package_zujian, $ItemSoft->id, $User->id);
    }

    public static function Version2Int($sVersion)
    {
        $aArr = explode('.', $sVersion);
        if (count($aArr) != 4) {
            $iRes = (int)$sVersion;
        } else {
            $iRes = ($aArr[0] << 56) + ($aArr[1] << 48) + ($aArr[2] << 32) + $aArr[3];
        }
        return $iRes;
    }

    public static function Int2Version($iInt)
    {
        $iP1 = $iInt >> 56;
        /*
        $iP2 = (((1 << 56) - 1) & $iInt) >> 48;
        $iP3 = (((1 << 48) - 1) & $iInt) >> 32;
        $iP4 = (((1 << 32) - 1) & $iInt);
         */
        $iP2 = ($iInt << 8 >> 8) >> 48;
        $iP3 = ($iInt << 16 >> 16) >> 32;
        $iP4 = ($iInt << 32 >> 32);
        return "$iP1.$iP2.$iP3.$iP4";
    }


    /**
     * 获取当前所有软件列表
     * @param $bFilterOutline bool 是否过滤已下线软件
     * @return array
     */
    public static function getAllSoft($bFilterOutline = true) {
        $aWhere = array();
        if ($bFilterOutline) {
            $aWhere['status'] = 1;
        }
        $aData = M("soft")->where($aWhere)->select();
        return Arr::changeIndex($aData, 'id');
    }

}

