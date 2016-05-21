<?php
namespace Admin\Controller;

use Admin\Model\PointFlowModel;
use Admin\Model\UserModel;
use Admin\Model\UserOrderModel;
use Common\Helper\Arr;
use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
class UserpointController extends BaseController {

    private $aIsSub = array(
        -1  => '全部',
        PointFlowModel::IS_SUB_NO => '获取牛币',
        PointFlowModel::IS_SUB_YES => '失去牛币',
    );

    public function index() {
        $aUserId    = I('get.find_value', '');
        $sStartDate = I("get.start_date", date('Y-m-d'));
        $sEndDate   = I("get.end_date", date('Y-m-d'));
        $iIsSub     = I("get.is_sub", -1);;
        $iType      = I("get.type", '');

        $aUserIds   = explode("\r\n", $aUserId);
        $aWhere = array(
            'date'    => array(array('EGT', $sStartDate), array('ELT', $sEndDate)),
        );

        if (!empty($aUserId) && !empty($aUserIds)) {
            $aWhere['user_id'] = array('IN', $aUserIds);
        }

        if ($iIsSub != -1) {
            if (!isset($this->aIsSub[$iIsSub])) {
                $this->fail('牛币得失选择有误');
            }
            $aWhere['is_sub'] = $iIsSub;
        }
        if ($iType !== '') {
            if (!isset(PointFlowModel::$aAllType[$iType])) {
                $this->fail('类型选择有误');
            }
            $aWhere['type'] = $iType;
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;

        $Model = M("point_flow");
        $aList = $Model->where($aWhere)->order("id desc")->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $this->assign("aList", $aList);
        $this->assign("sPagination", $show);


        $this->assign("aIsSub", $this->aIsSub);
        $this->assign("aAllType", PointFlowModel::$aAllType);
        $this->assign("sStartDate", $sStartDate);
        $this->assign("sEndDate", $sEndDate);
        $this->assign("iIsSub", $iIsSub);
        $this->assign("iType", $iType);

    }


    public function point() {
        $iUserId = I("get.user_id");
        $aWhere = array();
        if ($iUserId) {
            $aWhere['user_id'] = $iUserId;
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;

        $Model = M("user_point");
        $aList = $Model->where($aWhere)->order("id desc")->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $this->assign("aList", $aList);
        $this->assign("sPagination", $show);

    }

}
