<?php
namespace Home\Controller;


use Admin\Model\UserOrderModel;
use Common\Helper\MobileCaptcha;

class MoneyController extends BaseController {

    protected $SITE_HEADNAV = 'User';
    protected $SITE_FOOT_JS = array('/Public/statics/js/app/money.js');

    public function index(){
        $User   = $this->User;
        $aPoint = M("user_point")->where(array('user_id' => $User->id))->find();

        $bCheckAuth    = false;
        $aExchangeAuth = $User->checkExchangeAuth();
        if (empty($aExchangeAuth)) {
            $bCheckAuth = true;
        }

        $this->assign("point", $aPoint['point']);
        $this->assign("bCheckAuth", $bCheckAuth);
        $this->assign("User", $User);
    }

    public function award_post() {
        $User     = $this->User;
        $iNum     = I('post.point');
        $iCaptcha = I('post.captcha');

        $bMatch = preg_match('#^\d+$#', trim($iNum));
        if(empty($iNum) || !$bMatch || (int)$iNum === 0) {
            $this->fail('请填写正确的兑换数量!', null, 2002);
            return;
        }
        //单位:1000
        $iNum = (int)$iNum * 1000;

        $aExchangeAuth = $User->checkExchangeAuth($iNum);
        if(!empty($aExchangeAuth)) {
            $this->fail($aExchangeAuth['errMsg'], $aExchangeAuth['errCode']);
            return;
        }

        $iMobile = $User->mobile;
        $bRet = MobileCaptcha::check($iMobile, $iCaptcha);
        if(!$bRet) {
            $this->fail('输入的验证码不正确', null, 2001);
            return;
        }

        $MPoint = M('user_point');
        $MPoint->create();
        $MPoint->where(array('user_id' => $User->id))->find();
        if(empty($MPoint->user_id) || $MPoint->point < 1000) {
            $this->fail('账户余额少于1000流量无法兑换', null, 3001);
            return;
        }
        if($MPoint->point < $iNum) {
            $this->fail("您当前最多兑换{$MPoint->point}个牛币,无法兑换{$iNum}个牛币,请更改兑换牛币数量,再进行兑换", null, 3002);
            return;
        }

        $bRs = UserOrderModel::toBank($this->User, $iNum, $iErr, $sErr);
        if(!$bRs) {
            $this->fail("暂时无法兑换，请稍等再试，如多次无法兑换请联系渠道负责人", null, $iErr);
            return;
        }

        //验证成功后把cookie设为空
        $bSendMsg = cookie(self::LM_SEND_MSG_COOKIE_KEY);
        if($bSendMsg) {
            cookie(self::LM_SEND_MSG_COOKIE_KEY, null);
        }

        $this->succ('兑换成功');
    }

    public function list_detail() {
        $User = $this->User;
        $aGet = array(
            'start_date' => I('get.start_date', date('Y-m-').'01'),
            'end_date'   => I('get.end_date', date('Y-m-').'31'),
        );

        $aWhere = array('user_id' => $User->id);
        if(strtotime($aGet['start_date']) > strtotime($aGet['end_date'])) {
            $this->fail('开始日期不能大于结束日期',null,1001);
            return;
        }

        if(!empty($aGet['start_date'])) {
            $aWhere['date'][] = array('EGT', $aGet['start_date']);
        }
        if(!empty($aGet['end_date'])) {
            $aWhere['date'][] = array('ELT', $aGet['end_date']);
        }


        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('point_flow'); // 实例化User对象
        $aList = $Model->where($aWhere)->order('id desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
        $this->assign("aGet", $aGet);
        $this->assign("start_date", $aGet['start_date']);
        $this->assign("end_date", $aGet['end_date']);
    }

    public function salary() {
        $User   = $this->User;
        $aWhere = array('user_id' => $User->id);

        $aGet = array(
            'start_date' => I('get.start_date', date('Y-m-').'01'),
            'end_date'   => I('get.end_date', date('Y-m-01', strtotime("+1 months"))),
        );

        $aWhere = array('user_id' => $User->id);
        if(strtotime($aGet['start_date']) > strtotime($aGet['end_date'])) {
            $this->fail('开始日期不能大于结束日期',null,1001);
            return;
        }

        if(!empty($aGet['start_date'])) {
            $aWhere['create_time'][] = array('EGT', $aGet['start_date']);
        }
        if(!empty($aGet['end_date'])) {
            $aWhere['create_time'][] = array('ELT', $aGet['end_date']);
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('user_order'); // 实例化User对象
        $aList = $Model->where($aWhere)->order('id desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
        $this->assign("start_date", $aGet['start_date']);
        $this->assign("end_date", $aGet['end_date']);
    }

}
