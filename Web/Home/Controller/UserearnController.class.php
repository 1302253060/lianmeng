<?php
namespace Home\Controller;


use Admin\Model\SoftModel;
use Admin\Model\UserModel;
use Common\Helper\Arr;
use Common\Helper\PHPExcel;

class UserearnController extends BaseController {

    protected $SITE_HEADNAV = 'User';

    public function last(){
        $type    = I('get.type', 1);
        $aSoft   = SoftModel::getAllSoft();
        $aSoftID = array();
        if ($type == 1) {
            $iType = SoftModel::TYPE_PC;
        } elseif ($type == 2) {
            $iType = SoftModel::TYPE_APP;
        } else {
            $iType = SoftModel::TYPE_PC;
        }

        foreach ($aSoft as $iSoftId => $aVal) {
            if ($aVal['type'] == $iType) {
                $aSoftID[] = $iSoftId;
            }
        }

        $sDate     = date('Y-m-d', strtotime("-1 day"));
        $aStatData = array();
        if ((int)$this->User->level === UserModel::LEVEL_ONE) {
            $aStatData = M("daily_data")
                ->field("SUM(effect_org) as effect_org, soft_id")
                ->where(array('soft_id' => array('IN', $aSoftID), 'date' => $sDate, 'user_id' => $this->User->id))
                ->group("soft_id")->select();
        } elseif ((int)$this->User->level === UserModel::LEVEL_TWO) {
            $aStatData = M("daily_data")
                ->field("effect_org, soft_id")
                ->where(array('soft_id' => array('IN', $aSoftID), 'date' => $sDate, 'channel_id' => $this->User->id))
                ->select();
        }
        $aTimeData = M("daily_data")
            ->field("create_time, soft_id")
            ->where(array('date' => $sDate, 'soft_id' => array('IN', $aSoftID)))
            ->group("soft_id")
            ->select();

        $this->assign("aSoft", $aSoft);
        $this->assign("aData", $aStatData);
        $this->assign("type", $type);
        $this->assign("aTimeData", Arr::changeIndexToKVMap($aTimeData, 'soft_id', 'create_time'));
    }

    private $aSearchKey     = array('id', 'name');
    private $aSearchAction = array('channel', 'date');
    public function index() {

    }


    public function search() {
        if ((int)$this->User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/', 1000);
            return;
        }
        $type       = I('get.type', 1);
        $sStartDate = I('get.start_date', date('Y-m-d', strtotime("-7 days")));
        $sEndDate   = I('get.end_date', date('Y-m-d', strtotime("-1 days")));
        $search_key = I('get.search_key', 'id');
        $search_text= I('get.search_text', '');
        $search_action = I('get.search_action', 'date');
        $is_export = I('get.is_export', 0);
        $aSoft   = SoftModel::getAllSoft();
        $aSoftID = array();
        if ($type == 1) {
            $iType = SoftModel::TYPE_PC;
        } elseif ($type == 2) {
            $iType = SoftModel::TYPE_APP;
        } else {
            $iType = SoftModel::TYPE_PC;
        }

        foreach ($aSoft as $iSoftId => $aVal) {
            if ($aVal['type'] == $iType) {
                $aSoftID[] = $iSoftId;
            }
        }

        $aWhere = array();
        if ((int)$this->User->level === UserModel::LEVEL_ONE && !empty($search_text)) {
            $aWhere[$search_key] = $search_text;
            $select = M("user")->field("id")->where($aWhere + array('level' => UserModel::LEVEL_TWO, 'parent_id' => $this->User->id))->select();
            if (empty($select)) {
                $this->fail("你输入的用户信息错误，请重新输入");
                return false;
            }
            unset($aWhere);
            $aWhere['channel_id'] = array('IN', array_keys(Arr::changeIndexToKVMap($select, 'id', 'id')));
        }
        $aWhere['user_id'] = $this->User->id;
        $aWhere['date']    = array(array('EGT', $sStartDate), array('ELT', $sEndDate));
        $aWhere['soft_id'] = array('IN', $aSoftID);

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;

        if ($is_export == 1) {
            $this->_export($aWhere, $search_action);
        }
        if ($search_action == 'channel') {
            $Model = M("daily_data");
            $aList = $Model
                ->field("channel_id, soft_id, sum(effect_org) as effect_org")
                ->where($aWhere)
                ->group("channel_id, soft_id")
                ->page($p.',' . $iDefaultNumberPerPage)
                ->select();
            $count = $Model
                ->where($aWhere)
                ->group("channel_id, soft_id")
                ->select();
            $Page  = new \Think\Page(count($count), $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
            $show  = $Page->show();// 分页显示输出
            unset($count);
        } elseif ($search_action == 'date') {
            $Model = M("daily_data");
            $aList = $Model
                ->field("date, soft_id, sum(effect_org) as effect_org")
                ->where($aWhere)
                ->group("date, soft_id")
                ->page($p.',' . $iDefaultNumberPerPage)
                ->select();
            $count = $Model
                ->field("date, soft_id, sum(effect_org) as effect_org")
                ->where($aWhere)
                ->group("date, soft_id")
                ->select();
            $Page  = new \Think\Page(count($count), $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
            $show  = $Page->show();// 分页显示输出
            unset($count);
        } else {
            $this->fail("你输入的信息有误，请重新输入");
            return false;
        }

        $this->assign("aSoft", $aSoft);
        $this->assign("type", $type);
        $this->assign("sStartDate", $sStartDate);
        $this->assign("sEndDate", $sEndDate);
        $this->assign("search_key", $search_key);
        $this->assign("search_text", $search_text);
        $this->assign("aSearchKey", $this->aSearchKey);
        $this->assign("aSearchAction", $this->aSearchAction);
        $this->assign("search_action", $search_action);
        $this->assign("aList", $aList);
        $this->assign("sPagination", $show);
    }

    private function _export($aWhere, $search_action) {
        if ($search_action == 'channel') {
            $Model = M("daily_data");
            $aList = $Model
                ->field("channel_id, soft_id, sum(effect_org) as effect_org")
                ->where($aWhere)
                ->group("channel_id, soft_id")
                ->select();
        } elseif ($search_action == 'date') {
            $Model = M("daily_data");
            $aList = $Model
                ->field("date, soft_id, sum(effect_org) as effect_org")
                ->where($aWhere)
                ->group("date, soft_id")
                ->select();
        }
        foreach ($aList as &$aVal) {
            $aVal['soft_id'] = SoftModel::getAllSoft()[$aVal['soft_id']]['name'];
        }

        if ($search_action == 'channel') {
            $aHead = array('渠道号', '软件', '安装量');
        } elseif ($search_action == 'date') {
            $aHead = array('日期', '软件', '安装量');
        }
        PHPExcel::arr2ExcelDownload($aList, $aHead, '渠道数据_' . $search_action);
    }


    public function channel() {
        $type       = I('get.type', 1);
        if ($type == 1) {
            $iType = SoftModel::TYPE_PC;
        } elseif ($type == 2) {
            $iType = SoftModel::TYPE_APP;
        } else {
            $iType = SoftModel::TYPE_PC;
        }
        $aSoft = SoftModel::getAllSoft();
        foreach ($aSoft as $iSoftId => $aVal) {
            if ($aVal['type'] == $iType) {
                $aSoftID[] = $iSoftId;
            }
        }

        $User = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_ONE) {
            $this->fail('你没有权限操作', '/', 1000);
            return;
        }
        $iChannelId = $User->id;
        $start_date = I("get.start_date", date('Y-m-d', strtotime("-1 days")));
        $end_date   = I("get.end_date", date('Y-m-d', strtotime("-1 days")));


        $aWhere = array('channel_id' => $iChannelId, 'soft_id' => array('IN', $aSoftID));
        $aWhere['date'] = array(array('EGT', $start_date), array('ELT', $end_date));
        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('daily_data'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $Model->where($aWhere)->order('id asc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $this->assign("aList", $aList);
        $this->assign("sPagination", $show);
        $this->assign("start_date", $start_date);
        $this->assign("end_date", $end_date);
        $this->assign("aSoft", SoftModel::getAllSoft());

        $this->assign("type", $type);
    }
}
