<?php
namespace Admin\Controller;

use Admin\Model\UserModel;
use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
class UsermanagerController extends BaseController {

    private $aAllStatus = array(
        1   => '冻结',
        2   => '解冻',
    );

    public function index() {

        $aQueryType = array(
            'id'     => 'ID',
            'name'   => '姓名',
            'qq'     => 'QQ',
            'mobile' => '手机',
        );

        $aWhere = array();
        if (I('get.value')) {
            if (!isset($aQueryType[I('get.type')])) {
                return $this->fail('类型选择有误');
            }
            $aWhere[I('get.type')] = I('get.value');
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $User = M('user'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $User->where($aWhere)->order('create_time desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $User->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
        $this->assign("aQueryType", $aQueryType);
    }

    public function edit() {
        $iID   = (int)I('get.id');
        $User  = M("user");
        $User->getById($iID);
        $this->assign("bEdit", true);
        $this->assign("Item",  $User);
    }


    public function edit_post() {
        $this->sTPL = null;

        $iID = I('post.id');
        if (empty($iID)) {
            $this->fail('参数ID错误');
            goto END;
        }
        $User = M("user");
        $data = $User->create();

        $aOldData = $User->find($iID);

        if (empty($aOldData)) {
            $this->fail(sprintf('[条目:%d 不存在]', $iID));
            goto END;
        }

        if ($data['mobile']) {
            if($User->where(
                array(
                    'mobile' => $data['mobile'],
                    'id'     => array('neq', $iID),
                    'level'  => $aOldData['level'],
                )
            )->count()) {
                $this->fail('该手机号已经存在');
                goto END;
            }
        }

        $User->update_time = date('Y-m-d H:i:s');
        if (!$User->save($data)) {
            $this->fail('更新失败');
            goto END;
        }
        $this->succ('更新成功');

        END:
    }


    public function change() {
        $this->assign("aAllStatus", $this->aAllStatus);
    }

    public function change_post() {
        set_time_limit(0);
        $this->sTPL = null;

        $aArr = array(
            'user_ids' => I("post.user_ids"),
            'status'   => I("post.status"),
            'reason'   => I("post.reason"),
        );

        if (!$aArr['user_ids']) {
            $iCode = 1;
            $sMsg  = '参数错误';
            goto END;
        }

        if (!isset($this->aAllStatus[$aArr['status']])) {
            $iCode = 1;
            $sMsg  = '参数错误';
            goto END;
        }

        $aUserId = explode("\n", $aArr['user_ids']);

        foreach ($aUserId as $iUserId) {
            $iUserId = (int)$iUserId;
            if (!$iUserId) {
                continue;
            }

            $User = new UserModel();
            $User->getById($iUserId);
            $iStatus = false;
            switch ($aArr['status']) {
                case 1:
                    if (UserModel::isFreeze($User->status)) {
                        continue;
                    }
                    $iStatus = UserModel::STATUS_FREEZE;
                    break;
                case 2:
                    if (!UserModel::isFreeze($User->status)) {
                        continue;
                    }
                    $iStatus = UserModel::STATUS_NORMAL;
                    break;
                default:
                    break;
            }
            if ($iStatus !== false) {
                $User->changeStatus($iStatus, $aArr['reason']);
            }
        }

        END:
        !isset($iCode) ? $this->succ('操作成功') : $this->fail($sMsg, null, $iCode);
    }
}
