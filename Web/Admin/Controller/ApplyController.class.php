<?php
namespace Admin\Controller;

use Admin\Model\ApplyModel;
use Admin\Model\PointFlowModel;
use Admin\Model\UserModel;
use Admin\Model\UserOrderModel;
use Common\Helper\Arr;
use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
class ApplyController extends BaseController {

    private $applyStatus = array(
        ApplyModel::STATUS_ING  => '申请中',
        ApplyModel::STATUS_SUCC => '申请成功',
        ApplyModel::STATUS_FAIL => '申请失败',
    );

    public function index() {
        $status  = I("get.status", ApplyModel::STATUS_ING);
        $user_id = I("get.user_id", '');

        $aWhere = array();
        if (!empty($user_id)) {
            $aWhere['user_id'] = $user_id;
        }
        $aWhere['status'] = $status;

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;

        $Model = M("apply_package");
        $aList = $Model->where($aWhere)->order("id desc")->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $this->assign("aList", $aList);
        $this->assign("sPagination", $show);
        $this->assign("aStatus", $this->applyStatus);
        $this->assign("status", $status);
        $this->assign("user_id", $user_id);
    }


    public function edit() {
        $iID   = (int)I('get.id');
        $Model  = M("apply_package");
        $Model->getById($iID);
        $this->assign("bEdit", true);
        $this->assign("Item",  $Model);
    }

    public function edit_post() {
        $this->sTPL = null;
        $iID   = I('post.id');
        $aSoft = I('post.soft_id', array());
        $iNum  = I('post.package_num', 0);
        $status = I('post.status', 0);

        if (empty($iID)) {
            $this->fail('参数ID错误');
            goto END;
        }

        if ($iNum == 0) {
            $this->fail('申请包数量不能为0');
            goto END;
        }

        if (empty($aSoft)) {
            $this->fail('软件不能为空');
            goto END;
        }

        $Model = M("apply_package");
        $data = $Model->create();

        $aOldData = $Model->find($iID);

        if (empty($aOldData)) {
            $this->fail(sprintf('[条目:%d 不存在]', $iID));
            goto END;
        }

        if (in_array($aOldData['status'], array(ApplyModel::STATUS_SUCC, ApplyModel::STATUS_FAIL))) {
            $this->fail(sprintf('该申请已经处理过'));
            goto END;
        }
        if ($status == 0) {
            $this->fail('请填写状态');
            goto END;
        }

        $Model->soft   = implode(",", $aSoft);
        $Model->status = I('post.status');
        $Model->mark   = I('post.mark');
        $Model->update_time = date('Y-m-d H:i:s');
        if (!$Model->save()) {
            $this->fail('更新失败');
            goto END;
        }
        $this->succ('更新成功');

        END:
    }

}
