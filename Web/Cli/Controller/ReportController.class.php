<?php
namespace Cli\Controller;

use Think\Controller;
use Common\Helper\PHPExcel;
use Common\Helper\Mail;

class ReportController extends Controller {
    private $sDir = 'D:/project/fanliang/';
//    private $sPre = 'fanliang_2016071200.txt';
    private $sPre = 'fanliang_';
    public function import(){
        $sDate = date('Ymd', strtotime("-1 days"));
        for ($i = 0; $i < 24; ++$i) {
            $iHour = sprintf("%02d", $i);
            $sFile = $this->sDir . $this->sPre . $sDate . $iHour . '.txt';
            if (!file_exists($sFile)) {
                continue;
            }
            $aLine = file($sFile);
            foreach ($aLine as $sItem) {
                if (empty($sItem)) {
                    continue;
                }
                $aItem = array();
                $aItem = explode("\t", $sItem);
                var_dump($aItem[0]);
                $aData = array(
                    'supply_id'    => $aItem[0],
                    'package_name' => $aItem[1],
                    'guid'         => $aItem[2],
                    'os_major_ver' => $aItem[3],
                    'os_minor_ver' => $aItem[4],
                    'os_bit'       => $aItem[5],
                    'mac'          => $aItem[6],
                    'cpu'          => $aItem[7],
                    'aHardDisk'    => $aItem[8],
                    'mainboard'    => $aItem[9],
                    'version'      => $aItem[10],
                    'virtual_machine' => $aItem[11],
                    'other'        => $aItem[12],
                    'ip'           => $aItem[13],
                    'server'       => $aItem[14],
                    'create_time'  => date('Y-m-d H:i:s'),
                    'date'         => date('Y-m-d', strtotime($sDate)),
                );
                M("report")->add($aData);
            }
        }
    }

    public function effectguid(){
        $sDate   = date('Y-m-d', strtotime("-1 days"));
        $aReport = M("report")->field("id, supply_id, guid")->order("id asc")->where(array('date' => $sDate))->select();
        if (empty($aReport)) {
            echo "report empty\n";
            exit;
        }
        foreach ($aReport as $aItem) {
            $iCount = M("report")->where(array('id' => array('LT', $aItem['id']), 'guid' => $aItem['guid']))->count();
            echo "{$aItem['id']}--{$aItem['supply_id']}--{$aItem['guid']}--{$iCount}\n";
            if ($iCount > 0) {
                continue;
            }
            $aData = array(
                'date'      => $sDate,
                'supply_id' => $aItem['supply_id'],
                'guid'      => $aItem['guid'],
            );
            M("effect_guid")->add($aData);
        }
    }
}
