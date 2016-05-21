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
class PointflowController extends BaseController {

    private function getAllPointFlowType() {
        return array(
            PointFlowModel::TYPE_ADD_BONUS => PointFlowModel::$aAllType[PointFlowModel::TYPE_ADD_BONUS],
            PointFlowModel::TYPE_ADD_SALARY => PointFlowModel::$aAllType[PointFlowModel::TYPE_ADD_SALARY],
            PointFlowModel::TYPE_SUB_TAKEOUT => PointFlowModel::$aAllType[PointFlowModel::TYPE_SUB_TAKEOUT],
        );
    }

    public function add() {
        $this->assign("aType", $this->getAllPointFlowType());
    }

    public function add_post() {
        $this->sTPL = null;
        $aArr = array(
            'user_ids_point' => I("post.user_ids_point"),
            'type'           => I("post.type"),
            'note'           => I("post.note"),
        );

        $aType = $this->getAllPointFlowType();
        if (!isset($aType[$aArr['type']])) {
            $this->fail('参数错误');
            goto END;
        }

        $aError = array();
        $aSuccess = array();
        if (!$aArr['user_ids_point']) {
            $this->fail('参数错误');
            goto END;
        }
        $aUserId = explode("\n", $aArr['user_ids_point']);

        if (count($aUserId) > 300) {
            $this->fail('一次发放请控制在300用户以内');
            goto END;
        }

        foreach ($aUserId as $sValue) {
            $aTmp       = explode(",", $sValue);
            $iUserId    = (int)(isset($aTmp[0])?$aTmp[0]:0);
            $iPoint     = (int)(isset($aTmp[1])?$aTmp[1]:0);

            if (!($iUserId > 0) || !($iPoint > 0)) {
                $aError[] = $sValue;
                continue;
            }

            $iErrorCode = 0;
            $bRet = D("point_flow")->addPoint($iUserId, $iPoint, $aArr['type'], $aArr['note'],null, $iErrorCode);
            if (!$bRet) {
                $aError[] = $sValue . ' , error : ' . PointFlowModel::$aAllAddPointError[$iErrorCode];
                continue;
            }
            $aSuccess[] = $iUserId;
        }

        #推送短信通知
//        if ($_POST['send_sms'] == 1 && $aSuccess) {
//            $aMobile = MF()->getUser()->findCustom(array('id in' => $aSuccess, 'mobile >' => 0),'','id, mobile');
//            $aMobile = Arr::changeIndexToKVMap($aMobile, 'id', 'mobile');
//            Message::send($aMobile, $_POST['sms_content']);
//        }

        if (!$aError) {
            $this->succ('操作成功');
        } else {
            $this->warn('操作成功，失败的记录有：<br>' . implode('<br>', $aError));
        }
        END:
    }

}
