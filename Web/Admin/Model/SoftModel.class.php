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
            case 9: //暴风影音
                $sFormatName = substr($sName, 0, strlen($sName) - 2) . '_%08d]]';
                break;
            case 10: //jj比赛
                $sFormatName = $sName . '-ChildID%d-';
                break;
            case 11: //输入法
                $sFormatName = $sName . '_sw-%010d';
                break;
            case 12: //hao123
                $sFormatName = $sName . '&tt=%d';
                break;
            case 13: //wps
                $sFormatName = $sName . ".%d";
                break;
            case 15: //LKGame
                $sFormatName = $sName . "_%06d";
                break;
            case 16: //PPS
                $sFormatName = $sName . "@%06d";
                break;
            case 18: //悠洋棋牌
                $sFormatName = $sName . "_%07d";
                break;
            case 500: //风行
                $sFormatName = $sName . "_C2%06d";
                break;
            case 1004: //天书世界，1000001~1300000 30w个包
                $sFormatName = $sName . "_1%06d";
                break;
            case 1005: //九星天，1000001~1300000 30w个包
                $sFormatName = $sName . "_1%06d";
                break;
            case 1: //卫士
            case 2: //杀毒
            case 6: //浏览器
            case 132: //桌面百度
            case 1003: //百度卫士beta版
                $sFormatName = $sName . '_10%08d';
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

