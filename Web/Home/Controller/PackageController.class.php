<?php
namespace Home\Controller;


use Admin\Model\ApplyModel;
use Admin\Model\SoftModel;
use Admin\Model\UserModel;
use Common\Helper\Arr;

class PackageController extends BaseController {

    protected $SITE_FOOT_JS = array('/Public/statics/js/app/package_apply.js');

    protected $SITE_HEADNAV = 'User';
    public function index(){
        $User = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/', 1000);
            return;
        }
        $aDefValue = array(
            'search_key'  => I("get.search_key", 'id'),
            'search_text' => I("get.search_text", ''),
        );

        $aGet   = $aDefValue;
        $aWhere = array('parent_id' => $User->id, 'level' => UserModel::LEVEL_TWO);
        if(!empty($aGet['search_text'])) {
            $aWhere[$aGet['search_key']] = $aGet['search_text'];
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('user'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $Model->where($aWhere)->order('id desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
        $this->assign('aGet', $aGet);
    }

    public function apply_list(){
        $User = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/', 1000);
            return;
        }
        $aWhere = array('user_id' => $User->id, 'status' => ApplyModel::STATUS_ING);


        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('apply_package'); // 实例化User对象
        $aList = $Model->where($aWhere)->order('create_time desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList); // 赋值数据集

    }


    public function cancel_list(){
        $User = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/', 1000);
            return;
        }
        $aWhere = array('user_id' => $User->id, 'status' => ApplyModel::STATUS_FAIL);


        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('apply_package'); // 实例化User对象
        $aList = $Model->where($aWhere)->order('create_time desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList); // 赋值数据集
    }

    public function apply_package(){
        $User = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/', 1000);
            return;
        }
        $aSoft = SoftModel::getAllSoft();

        $this->assign("aSoft", Arr::changeIndexToKVMap($aSoft, 'id', 'name'));
    }

    public function apply_post() {
        $User  = $this->User;
        $num   = I("post.num");
        $other = I("post.other");
        $soft  = I("post.soft");

        if($User->level != UserModel::LEVEL_ONE) {
            $this->fail('无渠道申请权限',null,1001);
            return;
        }
        if(empty($num)) {
            $this->fail('参数错误',null,1001);
            return;
        }
        $num = intval($num);
        if($num < 1 || $num > 100) {
            $this->fail('每次申请渠道的个数必须是1-100','',1002);
            return;
        }
        $aSoftID = array_keys(Arr::changeIndexToKVMap(SoftModel::getAllSoft(), 'id', 'name'));
        if (empty($soft)) {
            $this->fail('参数错误',null,1001);
            return;
        }
        foreach ($soft as $val) {
            if (!in_array($val, $aSoftID)) {
                $this->fail('参数错误',null,1001);
                return;
            }
        }

        $aPost = array(
            'user_id'     => $User->id,
            'package_num' => $num,
            'other_info'  => $other,
            'status'      => ApplyModel::STATUS_ING,
            'create_time' => date('Y-m-d H:i:s'),
            'soft'        => implode(",", $soft),
        );

        $bRet = M("apply_package")->add($aPost);
        if(!$bRet) {
            $this->fail('提交失败', null, 9999);
            return;
        }
        $this->succ('更新成功');
    }


    public function receive() {
        $User       = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/', 1000);
            return;
        }
        $iChannelId = I("get.channel_id");
        $iCount = M("user")->where(array('id' => $iChannelId, 'parent_id' => $User->id, 'level' => UserModel::LEVEL_TWO))->count();
        if (!$iCount) {
            $this->fail("该渠道不存在");
            return;
        }
        $aChannelSoft = M("channel_soft")->where(array('user_id' => $User->id, 'channel_id' => $iChannelId))->select();
        $aData = array();
        $aSoft = SoftModel::getAllSoft();
        if (!empty($aChannelSoft)) foreach ($aChannelSoft as $aVal) {
            if (!isset($aSoft[$aVal['soft_id']])) {
                continue;
            }
            $aData[] = array(
                'soft_id' => $aVal['soft_id'],
                'name'    => $aSoft[$aVal['soft_id']]['name'],
            );
        }

        $this->assign("aData", $aData);
        $this->assign("iChannelId", $iChannelId);
    }

    public function channel() {
        $User       = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/', 1000);
            return;
        }
        $iChannelId = I("get.channel_id");
        $start_date = I("get.start_date", date('Y-m-d', strtotime("-1 days")));
        $end_date   = I("get.end_date", date('Y-m-d', strtotime("-1 days")));
        $iCount = M("user")->where(array('id' => $iChannelId, 'parent_id' => $User->id, 'level' => UserModel::LEVEL_TWO))->count();
        if (!$iCount) {
            $this->fail("该渠道不存在");
            return;
        }
        $aWhere = array('user_id' => $User->id, 'channel_id' => $iChannelId);
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
        $this->assign("iChannelId", $iChannelId);
        $this->assign("start_date", $start_date);
        $this->assign("end_date", $end_date);
        $this->assign("aSoft", SoftModel::getAllSoft());
    }

    public function edit() {
        $User       = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/', 1000);
            return;
        }
        $iChannelId = I("get.channel_id");
        $Model      = M("user");
        $Model->create();
        $Model->where(array('id' => $iChannelId, 'parent_id' => $User->id, 'level' => UserModel::LEVEL_TWO))->find();
        if (!$Model->id) {
            $this->fail("该渠道不存在");
            return;
        }

        $this->assign("iChannelId", $iChannelId);
        $this->assign("MUser", $Model);
    }

    public function edit_post() {
        $User       = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('操作失败', '/', 1001);
            return;
        }
        $iChannelId = I("post.channel_id");
        $sMark      = I("post.mark");
        $sName      = I("post.name");
        if (empty($sMark) && empty($sName)) {
            $this->fail('操作失败，数据不能为空', null, 1002);
            return;
        }

        $MUser = new \Admin\Model\UserModel();
        $MUser->create();
        $MUser->where(array('id' => $iChannelId, 'parent_id' => $User->id, 'level' => UserModel::LEVEL_TWO))->find();
        if (!empty($sMark)) {
            $MUser->setNoteInfo(array('mark' => $sMark));
        }
        if (!empty($sName)) {
            $MUser->name = $sName;
        }
        if ($MUser->save()) {
            $this->succ("成功");
        } else {
            $this->fail('操作失败', null, 1001);
        }
    }

    public function download() {
        $iSoftID = I("get.soft_id");
        $Model = M("soft");
        $Model->create();
        $Model->where(array('id' => $iSoftID, 'status' => SoftModel::STATUS_ONLINE))->find();

    }

}
