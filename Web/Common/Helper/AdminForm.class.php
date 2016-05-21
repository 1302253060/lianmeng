<?php
namespace Common\Helper;
use Admin\Model\SoftModel;

/**
 * 扩展Form类
 */
class AdminForm extends Form
{



    /**
     * 复选框，选择软件
     * @param string $sName
     * @param array $aSelected
     * @param bool $bFilterOutline
     * @return mixed
     */
    public static function checkboxSoft($aSelected = array(), $sName = 'soft_ids', $bFilterOutline = true)
    {
        $aSoft  = SoftModel::getAllSoft($bFilterOutline);
        foreach ($aSoft as $iSoftId => $aValue) {
            $aSoft[$iSoftId] = $aValue['name'] . "({$iSoftId})";
        }
        return self::checkbox_popup($sName, $aSoft, $aSelected);
    }

};