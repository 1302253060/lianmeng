<?php
namespace Admin\Controller;

use Admin\Model\DailyDataModel;
use Admin\Model\KvModel;
use Admin\Model\UserModel;
use Common\Helper\Arr;
use Common\Helper\Message;
use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
class UserdataController extends BaseController {

    private $aLevel = array(
        UserModel::LEVEL_ONE => '一级渠道',
        UserModel::LEVEL_TWO => '二级渠道',
    );

    private $aCut = array(
        2 => '全部',
        DailyDataModel::VM_NO_CUT => '未扣量',
        DailyDataModel::VM_CUT => '已扣量'
    );

    public function index() {
//$a = Message::send('1234', '大鱼测试', '{"customer":"1234"}', array('13137798393','13137798393'), 'SMS_6691165');
//   var_dump($a);
        $level  = I('get.level', UserModel::LEVEL_ONE);
        $userid = I('get.userid');
        $soft   = I('get.soft', 1);
        $is_cut = I('get.is_cut', 3);
        $start_date = I('get.start_date', date('Y-m-d', strtotime("-7 days")));
        $end_date   = I('get.end_date', date('Y-m-d', strtotime("-1 days")));

        $aSoft  = SoftModel::getAllSoft(false);
        $aWhere = array(
            'soft_id' => $soft,
            'date'    => array(array('EGT', $start_date), array('ELT', $end_date)),
        );

        if ($is_cut != 3) {
            $aWhere['is_sub'] = $is_cut;
        }
        if (!empty($userid) && $level == UserModel::LEVEL_ONE) {
            $aWhere['user_id'] = $userid;
        }
        if (!empty($userid) && $level == UserModel::LEVEL_TWO) {
            $aWhere['channel_id'] = $userid;
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;

        $Model = M("daily_data");
        $aList = $Model->where($aWhere)->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $this->assign("aList", $aList);
        $this->assign("userid", $userid);
        $this->assign("sPagination", $show);
        $this->assign("aLevel", $this->aLevel);
        $this->assign("level", $level);
        $this->assign("start_date", $start_date);
        $this->assign("end_date", $end_date);
        $this->assign("aCut", $this->aCut);
        $this->assign("is_cut", $is_cut);
        $this->assign("aSoft", Arr::changeIndexToKVMap($aSoft, 'id', 'name'));
    }

    public function one() {
        $userid = I('get.userid');
        $soft   = I('get.soft', 1);
        $start_date = I('get.start_date', date('Y-m-d', strtotime("-1 days")));
        $end_date   = I('get.end_date', date('Y-m-d', strtotime("-1 days")));

        $aSoft  = SoftModel::getAllSoft(false);
        $aWhere = array(
            'soft_id' => $soft,
            'date'    => array(array('EGT', $start_date), array('ELT', $end_date)),
        );

        if (!empty($userid)) {
            $aWhere['user_id'] = $userid;
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;

        $Model = M("daily_data");
        $aList = $Model
                    ->field("user_id, soft_id, date, sum(origin_org) as origin_org, sum(effect_org) as effect_org, sum(vm_num) as vm_num, sum(cut_vm_num) as cut_vm_num")
                    ->where($aWhere)
                    ->group("user_id, soft_id")
                    ->page($p.',' . $iDefaultNumberPerPage)->select();

        $count = $Model->where($aWhere)->group("user_id")->count();
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $this->assign("aList", $aList);
        $this->assign("userid", $userid);
        $this->assign("sPagination", $show);
        $this->assign("start_date", $start_date);
        $this->assign("end_date", $end_date);
        $this->assign("aSoft", Arr::changeIndexToKVMap($aSoft, 'id', 'name'));
    }
}
