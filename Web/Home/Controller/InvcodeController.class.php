<?php
namespace Home\Controller;


use Admin\Model\UserModel;
use Common\Helper\Arr;
use Common\Helper\Constant;

class InvcodeController extends BaseController {

    protected $SITE_HEADNAV = 'User';

    public function get_code(){
        $User = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/');
            return;
        }
        $aWhere = $this->_getInvCodeCond();
        $iExpireDay = self::INV_CODE_EXPIRE_DAY;
        $aWhere['fetch_time'][0] = array('EGT', date('Y-m-d H:i:s',strtotime("-{$iExpireDay} day")));
        $aWhere['apply_user_id'] = 0;

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('inv_code'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $Model->where($aWhere)->order('fetch_time asc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $bGetInvcode = false;
        $iCount = $this->_getInvCodeCount();
        if($iCount >= Constant::DAY_GET_INV_CODE_NUM) {
            $bGetInvcode = true;
        }

        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
        $this->assign("iExpireDay", $iExpireDay);
        $this->assign("iMaxCount", Constant::DAY_GET_INV_CODE_NUM);
        $this->assign("bGetInvcode", $bGetInvcode);

    }

    public function activity(){
        $User       = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/');
            return;
        }
        $iExpireDay = self::INV_CODE_EXPIRE_DAY;
        $sEffTime   = date('Y-m-d H:i:s', strtotime("-{$iExpireDay} day"));
        $aWhere     = array('fetch_user_id' => $User->id, 'apply_user_id' => array('GT', 0), 'status' => 2);

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('inv_code'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $Model->where($aWhere)->order('apply_time asc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出


        if (!empty($aList)) {
            $aUser = M("user")
                        ->field("id, name")
                        ->where(array('id' => array('IN', array_keys(Arr::changeIndexToKVMap($aList, 'apply_user_id', 'apply_user_id')))))
                        ->select();
            $this->assign("aUser", Arr::changeIndexToKVMap($aUser, 'id', 'name'));
        }

        $this->assign("aList", $aList);
        $this->assign('sPagination',$show);// 赋值分页输出

    }


    private function _getInvCodeCond() {
        return array(
            'fetch_user_id' => $this->User->id,
            'fetch_time'    => array(array('EGT', date('Y-m-d 00:00:00')), array('LT', date('Y-m-d 00:00:00', strtotime('+1 day')))),
        );
    }

    private function _getInvCodeCount() {
        return M('inv_code')->where($this->_getInvCodeCond())->count();
    }

    public function get_code_post(){
        $User = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', null, 1000);
            return;
        }
        if(UserModel::isFreeze($User->status)) {
            $this->fail('你的账号已经被冻结，请联系管理员', '', 1000);
            return;
        }
        $iCount    = $this->_getInvCodeCount();
        $iMaxCount = Constant::DAY_GET_INV_CODE_NUM;
        if($iCount >= $iMaxCount) {
            $this->fail('您今日已领过邀请码，若想申请临时增发，请联系管理员。', '', 1001);
            return;
        }
        $aUpData = array(
            1,
            $this->User->id,
            date('Y-m-d H:i:s'),
            ($iMaxCount - $iCount),
        );
        if ($iCount < $iMaxCount) {
            $sSQL = vsprintf(
                'UPDATE inv_code SET `status` = %d, fetch_user_id = %d, fetch_time="%s" WHERE `status`=0 AND apply_user_id=0 AND fetch_user_id=0 LIMIT %d',
                $aUpData
            );
            $bRet = M("inv_code")->execute($sSQL);
            if ($bRet) {
                $this->succ('获取邀请码成功');
            } else {
                $this->fail('获取邀请码失败', '', 1002);
                return;
            }
        }
    }

}
