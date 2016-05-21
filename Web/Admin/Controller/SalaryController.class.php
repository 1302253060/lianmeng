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
class SalaryController extends BaseController {

    private $aPayStatus = array(
        1 => '已支付',
        2 => '待支付',
        3 => '未支付',
        4 => '全部',
    );
    private $aUserStatus = array(
        0 => '正常',
        1 => '冻结',
        2 => '全部',
    );

    public function index() {
        $sDate  = I('get.date', date("Y-m-01", strtotime("-1 months")));
        $status = I('get.status', 3);
        $user_status = I('get.user_status', 0);
        $soft    = I('get.soft', 1);
        $user_id = I('get.user_id', '');
        $sDate   = '2015-04-01';
        $aWhere  = array(
            'month_price_data.date'    => $sDate,
            'month_price_data.soft_id' => $soft,
            'user.level'               => UserModel::LEVEL_ONE,
        );
        if (!empty($user_id)) {
            $aWhere['month_price_data.user_id'] = $user_id;
        }
        switch ($status) {
            case 1:
                $aWhere['month_price_data.pay_status'] = array('IN', array(1));
                break;
            case 2:
                $aWhere['month_price_data.pay_status'] = array('IN', array(2));
                break;
            case 3:
                $aWhere['month_price_data.pay_status'] = array('IN', array(0));
                break;
            case 4:
                $aWhere['month_price_data.pay_status'] = array('IN', array(0, 1, 2));
                break;
            default:
                break;
        }
        switch ($user_status) {
            case 0:
                $aWhere['user.status'] = array('IN', array(UserModel::STATUS_NORMAL));
                break;
            case 1:
                $aWhere['user.status'] = array('IN', array(UserModel::STATUS_FREEZE));
                break;
            case 2:
                $aWhere['user.status'] = array('IN', array(UserModel::STATUS_NORMAL, UserModel::STATUS_FREEZE));
                break;
            default:
                break;
        }

        $Model = M("month_price_data");
        $aList = $Model
            ->field("
                month_price_data.date,
                month_price_data.user_id,
                month_price_data.soft_id,
                sum(month_price_data.avg_org_price) as avg_org_price,
                sum(month_price_data.avg_limit_price) as avg_limit_price,
                sum(month_price_data.install_num) as install_num,
                sum(month_price_data.total_money) as total_money,
                sum(month_price_data.total_final_money) as total_final_money"
            )
            ->join('user ON month_price_data.user_id = user.id')
            ->where($aWhere)
            ->group("month_price_data.date,month_price_data.user_id,month_price_data.soft_id")
            ->select();
        $aSoft = SoftModel::getAllSoft(false);
        $this->assign("aList", $aList);
        $this->assign("sDate", $sDate);
        $this->assign("aPayStatus", $this->aPayStatus);
        $this->assign("status", $status);
        $this->assign("aUserStatus", $this->aUserStatus);
        $this->assign("user_status", $user_status);
        $this->assign("aSoft", $aSoft);
        $this->assign("aSelectSoft", Arr::changeIndexToKVMap($aSoft, 'id', 'name'));
        $this->assign("soft", $soft);
        $this->assign("user_id", $user_id);
    }

    public function channel() {
        $sDate   = I('get.date', date("Y-m-01", strtotime("-1 months")));
        $status  = I('get.status', 3);
        $user_status = I('get.user_status', 0);
        $soft    = I('get.soft', 1);
        $user_id = I('get.user_id', '');
        $search_text = I('get.search_text', '');
        $sDate   = '2015-04-01';
        $aWhere  = array(
            'month_price_data.date'    => $sDate,
            'month_price_data.soft_id' => $soft,
            'user.level'               => UserModel::LEVEL_TWO,
        );
        if (!empty($user_id)) {
            $aWhere['month_price_data.user_id'] = $user_id;
        }
        if (!empty($search_text)) {
            $channel = explode("\r\n", $search_text);
            $aWhere['month_price_data.channel_id'] = array('IN', $channel);
        }
        switch ($status) {
            case 1:
                $aWhere['month_price_data.pay_status'] = array('IN', array(1));
                break;
            case 2:
                $aWhere['month_price_data.pay_status'] = array('IN', array(2));
                break;
            case 3:
                $aWhere['month_price_data.pay_status'] = array('IN', array(0));
                break;
            case 4:
                $aWhere['month_price_data.pay_status'] = array('IN', array(0, 1, 2));
                break;
            default:
                break;
        }
        switch ($user_status) {
            case 0:
                $aWhere['user.status'] = array('IN', array(UserModel::STATUS_NORMAL));
                break;
            case 1:
                $aWhere['user.status'] = array('IN', array(UserModel::STATUS_FREEZE));
                break;
            case 2:
                $aWhere['user.status'] = array('IN', array(UserModel::STATUS_NORMAL, UserModel::STATUS_FREEZE));
                break;
            default:
                break;
        }

        if(I('get.action') == 'update_all') {
            $this->_updateAllStatus($aWhere);
            return;
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;

        $Model = M("month_price_data");
        $aList = $Model
            ->field("month_price_data.*")
            ->join('user ON month_price_data.channel_id = user.id')
            ->where($aWhere)
            ->page($p.',' . $iDefaultNumberPerPage)
            ->select();
        $count = $Model
                ->join('user ON month_price_data.channel_id = user.id')
                ->where($aWhere)
                ->count();
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $this->assign('sPagination',$show);// 赋值分页输出
        $aSoft = SoftModel::getAllSoft(false);
        $this->assign("aList", $aList);
        $this->assign("sDate", $sDate);
        $this->assign("aPayStatus", $this->aPayStatus);
        $this->assign("status", $status);
        $this->assign("aUserStatus", $this->aUserStatus);
        $this->assign("user_status", $user_status);
        $this->assign("aSoft", $aSoft);
        $this->assign("aSelectSoft", Arr::changeIndexToKVMap($aSoft, 'id', 'name'));
        $this->assign("soft", $soft);
        $this->assign("user_id", $user_id);
        $this->assign("search_text", $search_text);
    }


    public function update_price() {
        $this->sTPL = null;

        $iID = (int)I('post.pk');
        if ($iID === 0) {
            $this->fail('参数ID错误');
            goto END;
        }
        $value = I('post.value');

        if (empty($value)) {
            $this->fail('参数value错误');
            goto END;
        }

        $Model  = M("month_price_data");
        $aPrice = $Model->where(array('id' => $iID))->find();
        if (empty($aPrice)) {
            $this->fail('参数ID错误');
            goto END;
        }

        if ($aPrice['avg_limit_price'] == $value) {
            $this->succ('无需更新');
            goto END;
        }
        $Model->avg_limit_price   = $value;
        $Model->total_final_money = $value * $aPrice['install_num'];

        $Model->where(array('id' => $iID))->save() ?
            $this->succ('更新成功') :
            $this->fail('更新失败');

        END:

    }



    public function update_pay_status() {
        $this->sTPL = null;
        $sIds    = I('post.ids');
        $iStatus = I('post.status');
        $sMark   = I('post.mark');
        $rate    = I('post.rate');
        if(empty($sIds)) {
            $this->fail('请选择数据后再更新');
            return;
        }
        if (empty($rate)) {
            $rate = 1;
        }
        if(!empty($rate) && is_numeric($rate) && ($rate > 1 || $rate < 0)) {
            $this->fail('请填写折扣比例，并且比例范围[0,1]');
            return;
        }

        $Model= M("month_price_data");
        $sTime = date('Y-m-d H:i:s');
        $sSql = <<<EOF
        UPDATE month_price_data
        SET
        pay_status = {$iStatus},
        avg_limit_price = avg_limit_price * {$rate},
        total_final_money = total_final_money * {$rate},
        mark = '{$sMark}',
        rate = {$rate},
        update_time = '{$sTime}',
        last_edit_admin = '{$this->AdminUser->username}'
        WHERE id IN ({$sIds}) AND pay_status in (0, 2)
EOF;
        $bRet = $Model->execute($sSql);
        if(!$bRet) {
            $this->fail('更新失败!');
            return;
        }
        $this->succ('更新成功');
    }

    private function _updateAllStatus($aWhere) {
        $iStatus = I('get.update_status', 0);
        $rate    = I('get.rate', 1);
        $sMark   = I('get.mark', '');
        if(!empty($rate) && is_numeric($rate) && ($rate > 1 || $rate < 0)) {
            $this->fail('请填写折扣比例，并且比例范围[0,1]');
            return;
        }

        $Model = M("month_price_data");
        $aIds = $Model
            ->field("month_price_data.id")
            ->join('user ON month_price_data.channel_id = user.id')
            ->where($aWhere)
            ->select();
        if(empty($aIds)) {
            $this->fail('请选择数据后再更新');
            return;
        }

        $aIds = array_keys(Arr::changeIndexToKVMap($aIds, 'id', 'id'));
        $sIds = implode(',', $aIds);

        $sTime = date('Y-m-d H:i:s');
        $sSql = <<<EOF
        UPDATE month_price_data
        SET
        pay_status = {$iStatus},
        avg_limit_price = avg_limit_price * {$rate},
        total_final_money = total_final_money * {$rate},
        mark = '{$sMark}',
        rate = {$rate},
        update_time = '{$sTime}',
        last_edit_admin = '{$this->AdminUser->username}'
        WHERE id IN ({$sIds}) AND pay_status in (0, 2)
EOF;
        $bRet = $Model->execute($sSql);

        if(!$bRet) {
            $this->fail('更新失败!');
            return;
        }
        $this->succ('更新成功');
    }


    public function pay() {



        $sDate   = I('get.date', date("Y-m-01", strtotime("-1 months")));
        $soft    = I('get.soft', 1);
        $search_text = I('get.search_text', '');
        $sDate   = '2015-04-01';
        $aWhere  = array(
            'month_price_data.date'    => $sDate,
            'month_price_data.soft_id' => $soft,
            'user.level'               => UserModel::LEVEL_ONE,
        );
        $aWhere['month_price_data.pay_status'] = array('IN', array(2));

        if (!empty($search_text)) {
            $channel = explode("\r\n", $search_text);
            $aWhere['month_price_data.user_id'] = array('IN', $channel);
        }

        $Model = M("month_price_data");
        $aList = $Model
            ->field("
                month_price_data.date,
                month_price_data.user_id,
                month_price_data.soft_id,
                sum(month_price_data.avg_org_price) as avg_org_price,
                sum(month_price_data.avg_limit_price) as avg_limit_price,
                sum(month_price_data.install_num) as install_num,
                sum(month_price_data.total_money) as total_money,
                sum(month_price_data.total_final_money) as total_final_money"
            )->join('user ON month_price_data.user_id = user.id')
            ->where($aWhere)
            ->group("month_price_data.date,month_price_data.user_id,month_price_data.soft_id")
            ->select();

        $aSoft = SoftModel::getAllSoft(false);
        $this->assign("aList", $aList);
        $this->assign("sDate", $sDate);
        $this->assign("aSoft", $aSoft);
        $this->assign("aSelectSoft", Arr::changeIndexToKVMap($aSoft, 'id', 'name'));
        $this->assign("soft", $soft);
        $this->assign("search_text", $search_text);
    }

    private $aApplayStatus = array(
        UserOrderModel::ORDER_ING  => '申请中',
        UserOrderModel::ORDER_SUCC => '申请成功',
        UserOrderModel::ORDER_FAIL => '申请失败',
        4                          => '全部',
    );

    public function apply() {
        $search_text  = I('get.search_text', '');
        $apply_status = I('get.apply_status', UserOrderModel::ORDER_ING);
        $level = I('get.level', 0);

        if ($apply_status != 4) {
            $aWhere = array('user_order.status' => $apply_status);
        }

        if ($level != 0) {
            $aWhere['user.level'] = $level;
        }

        if (!empty($search_text)) {
            $channel = explode("\r\n", $search_text);
            $aWhere['user_order.user_id'] = array('IN', $channel);
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;

        $Model = M("user_order");
        $aList = $Model
            ->field("
                user_order.id,
                user_order.order_bid,
                user_order.user_id,
                user_order.point,
                user_order.order_info,
                user_order.status,
                user_order.create_time,
                user_order.update_time,
                user.level,
                user.name,
                user.mobile,
                user.payee,
                user.bankcard,
                user.subbranch"
            )->join('user ON user_order.user_id = user.id')
            ->where($aWhere)
            ->page($p.',' . $iDefaultNumberPerPage)
            ->select();

        $count = $Model
            ->join('user ON user_order.user_id = user.id')
            ->where($aWhere)
            ->count();

        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign("aList", $aList);
        $this->assign("search_text", $search_text);
        $this->assign("aApplyStatus", $this->aApplayStatus);
        $this->assign("apply_status", $apply_status);
        $this->assign("level", $level);
        $this->assign("aLevel", array(UserModel::LEVEL_ONE => '一级渠道', UserModel::LEVEL_TWO => '二级渠道', '0' => '全部'));
    }

    public function apply_agree() {
        $this->sTPL = null;
        $iID    = I('get.id');
        if(empty($iID)) {
            $this->fail('非法数据');
            return;
        }

        $Model = M("user_order");
        $aData = $Model->where(array('id' => $iID))->find();
        if (empty($aData)) {
            $this->fail('数据不存在');
            return;
        }

        $sTime   = date('Y-m-d H:i:s');
        $iStatus = UserOrderModel::ORDER_SUCC;
        $sSql = <<<EOF
        UPDATE user_order
        SET
        status = {$iStatus},
        update_time = '{$sTime}'
        WHERE id = '{$iID}' AND status = 0
EOF;
        $bRet = $Model->execute($sSql);
        if(!$bRet) {
            $this->fail('更新失败!');
            return;
        }
        $this->succ('更新成功');
    }

    public function apply_reject() {
        $this->sTPL = null;
        $iID    = I('get.id');
        if(empty($iID)) {
            $this->fail('非法数据');
            return;
        }

        $Model = M("user_order");
        $aData = $Model->where(array('id' => $iID))->find();
        if (empty($aData)) {
            $this->fail('数据不存在');
            return;
        }

        $sTime   = date('Y-m-d H:i:s');
        $iStatus = UserOrderModel::ORDER_FAIL;
        $sSql = <<<EOF
        UPDATE user_order
        SET
        status = {$iStatus},
        update_time = '{$sTime}'
        WHERE id = '{$iID}' AND status = 0
EOF;
        $bRet = $Model->execute($sSql);
        if(!$bRet) {
            D("point_flow")->addPoint($aData['user_id'], $aData['point'], PointFlowModel::TYPE_ADD_ORDER, '打款失败，流量返回用户帐户',null, $iErrorCode);
            $this->fail('更新失败!');
            return;
        }
        $this->succ('更新成功');
    }


    public function pay_post() {
        $aParams = array(
            's_date' => I("post.s_date"),
            'ids'    => I("post.ids"),
        );

        if (empty($aParams['s_date']) || empty($aParams['ids'])) {
            $this->fail('数据不能为空', null, 1001);
            return;
        }
        $sErrorMsg   = "";
        $iTotalPoint = 0;
        $aIds = explode(',', $aParams['ids']);


        $iFailNum = 0;
        foreach ($aIds as $iUserID) {
            $aUser = M("user")->where(array('id' => $iUserID))->find();
            if (empty($aUser)) {
                ++$iFailNum;
                $sErrorMsg .= "渠道{$iUserID}不存在\n";
                continue;
            }

            $aWhere = array(
                'user_id'     => $iUserID,
                'date'        => date('Y-m-01', strtotime($aParams['s_date'])),
                'pay_status'  => 2
            );

            $aPrice = M("month_price_data")->field('sum(total_final_money) as total_price')->where($aWhere)->select();
            $iPoint = $aPrice[0]['total_price'];
            if (!empty($aPrice) && $iPoint > 0) {
                $aUpData = array(
                    'pay_status'      => 1,
                    'update_time'     => date('Y-m-d H:i:s'),
                    'last_edit_admin' => $this->AdminUser->username
                );
                $bRet = M("month_price_data")->where($aWhere)->save($aUpData);
                if (!$bRet) {
                    ++$iFailNum;
                    $sErrorMsg .= "渠道{$iUserID}发放失败\n";
                    continue;
                }

                $sMark = "渠道{$iUserID},{$aParams['s_date']}月份推广收入";
                $bAddPoint = D("point_flow")->addPoint($iUserID, $iPoint, PointFlowModel::TYPE_ADD_SALARY, $sMark,null, $iErrorCode);
                if (!$bAddPoint) {
                    ++$iFailNum;
                    $sErrorMsg .= "渠道{$iUserID}发放失败\n";
                    continue;
                }
                $iTotalPoint += $iPoint;
            } else {
                ++$iFailNum;
                $sErrorMsg .= "渠道{$iUserID}发放失败,没有可用流量\n";
            }
        }
        $iTotal     = count($aIds);
        $iSucc      = $iTotal - $iFailNum;
        $sErrorMsg .= "共发放{$iTotal}个，成功{$iSucc}，失败{$iFailNum}个\n共发放牛币{$iTotalPoint}";
        $this->succ($sErrorMsg);
    }


}
