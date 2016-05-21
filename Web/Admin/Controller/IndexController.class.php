<?php
namespace Admin\Controller;

use Admin\Model\KvModel;
use Admin\Model\SoftModel;
use Admin\Model\UserModel;
use Admin\Model\UserOrderModel;
use Common\Helper\Arr;
use Common\Helper\Constant;
use Think\Controller;

class IndexController extends BaseController {
    public function index(){

        $this->getTotalData();

        #未返量软件列表
        $aData['aDataImportMiss']['data'] = D("kv")->findV(KvModel::DATAIMPORT_MISS, KvModel::TYPE_SERIALIZE);
        krsort($aData['aDataImportMiss']['data']);
        $aSoftMiss = array();
        if ($aData['aDataImportMiss']['data']) foreach ($aData['aDataImportMiss']['data'] as $aValue) {
            foreach ($aValue as $iSoftId => $iShow) {
                $aSoftMiss[$iSoftId] = $iSoftId;
            }
        }
        sort($aSoftMiss);
        $aData['aDataImportMiss']['soft'] = $aSoftMiss;

        #昨日已入库软件列表
        $aData['aDataImportFinished'] = array();
        foreach (SoftModel::getAllSoft() as $iSoftId => $aValue) {
//            if (C_DataImport::checkDateAllFinish('', array($iSoftId))) {
            if (1) {
                $aData['aDataImportFinished'][$iSoftId] = $aValue['name'];
            }
        }
        ksort($aData['aDataImportFinished']);

        $this->assign('aAllSoft', SoftModel::getAllSoft());
        $this->assign('aData', $aData);

    }


    /**
     * 获取汇总数据
     */
    private function getTotalData() {

        $aNewUser = M("user")->field("level, count(*) as num")
            ->where(
            array(
                'level'       => array('IN', array(UserModel::LEVEL_ONE, UserModel::LEVEL_TWO)),
                'create_time' => array('EGT', date('Y-m-d')),
                'is_login'    => 1
            )
        )->group("level")->select();
        $aNewUser = Arr::changeIndexToKVMap($aNewUser, 'level', 'num');
        $aTotal['aNewUser']['one'] = isset($aNewUser[UserModel::LEVEL_ONE]) ? $aNewUser[UserModel::LEVEL_ONE] : 0;
        $aTotal['aNewUser']['two'] = isset($aNewUser[UserModel::LEVEL_TWO]) ? $aNewUser[UserModel::LEVEL_TWO] : 0;

        $aSelfHelp = M("user_order")->field("sum(point) as point, count(distinct user_id) as user_num")
            ->where(
            array(
                'status'      => UserOrderModel::ORDER_SUCC,
                'create_time' => array('EGT', date('Y-m-d'))
                )
            )->select();
        $aTotal['aSelfHelp']['user_num'] = $aSelfHelp[0]['user_num'] ? $aSelfHelp[0]['user_num'] : 0;
        $aTotal['aSelfHelp']['point']    = $aSelfHelp[0]['user_num'] ? $aSelfHelp[0]['point'] : 0;
        $aTotal['aSelfHelp']['point']    = number_format($aTotal['aSelfHelp']['point'] / Constant::RMB2NB, 0, '.', ',');
        $this->assign("aTotal", $aTotal);
    }


    public function soft_install() {
        $sEndDate   = I('get.end_date', date('Y-m-d', time() - 86400));
        $sStartDate = I('get.start_date', date('Y-m-d', strtotime('-30 day', strtotime($sEndDate))));
        $soft_ids   = I('get.soft_ids', '');

        $aAllSoft = SoftModel::getAllSoft(false);
        foreach ($aAllSoft as $iSoftId => $aValue) {
            $aAllSoft[$iSoftId] = $aValue['name'] . '(' . $iSoftId . ')';
        }

        if ($soft_ids) {
            if ($soft_ids == 'all') {
                $aGetSoftId = SoftModel::getAllSoft(false);
                $aGetSoftId = array_keys($aGetSoftId);
            } else {
                $aGetSoftId = $soft_ids;
            }
        } else {
            $aSoft = SoftModel::getAllSoft();
            $aGetSoftId = array_keys($aSoft);
            $aSoftKey   = $aSoft;
        }

        $this->assign("aGetSoftId", $aGetSoftId);
        foreach ($aGetSoftId as $iSoftId) {
            $aSoftKey[$iSoftId] = $aAllSoft[$iSoftId];
        }

        $aWhere = array(
            'soft_id' => array('IN', $aGetSoftId),
            'date'    => array(array('EGT', $sStartDate), array('ELT', $sEndDate)),
        );

        $aSoftEffectOrg = M("daily_data")
                            ->field("date, soft_id, sum(effect_org) as effect")
                            ->where($aWhere)
                            ->group("date, soft_id")
                            ->select();

        $aSoftEffectTidy = array();
        foreach ($aSoftEffectOrg as $aValue) {
            $aSoftEffectTidy[$aValue['soft_id']][$aValue['date']] = $aValue;
        }

        $aSoftInstall['startTime'] = (strtotime($sStartDate) + 86400) * 1000;
        for($sCurDate = $sStartDate; strtotime($sCurDate) <= strtotime($sEndDate); $sCurDate = date('Y-m-d', strtotime($sCurDate) + 86400)) {
            foreach ($aGetSoftId as $iSoftId) {
                $aSoftInstall['effect'][$iSoftId][] = isset($aSoftEffectTidy[$iSoftId][$sCurDate])
                    ? (int)$aSoftEffectTidy[$iSoftId][$sCurDate]['effect']
                    : 0;
            }
        }

        $this->assign("aSoftKey", $aSoftKey);
        $this->assign("sStartDate", $sStartDate);
        $this->assign("sEndDate", $sEndDate);
        $this->assign("aSoftInstall", $aSoftInstall);
    }

}
