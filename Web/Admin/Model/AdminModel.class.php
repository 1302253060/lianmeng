<?php
namespace Admin\Model;

use Common\Helper\Arr;
use Common\Helper\Permission;
use Common\Helper\Session;
use Think\Model;

class AdminModel extends Model {

    public function __contruct() {

    }

    public function find($var) {
        if (!is_array($var)) {
            $aWhere = array('id' => $var);
        } else {
            $aWhere = $var;
        }
        $aData = M("admin")->where($aWhere)->find();
        foreach ($aData as $sKey => $val) {
            $this->$sKey = $val;
        }

        return $this;
    }

    public function is_super_admin() {
        return $this->is_super_admin;
    }


    public function setting() {
        return $this->setting ? unserialize($this->setting) : array();
    }

    /**
     * 返回用户权限对象
     *
     * @return Permission
     */
    public function perm()
    {
        if ( $this->is_super_admin )
        {
            # 超管
            $perm_setting = array(
                '_super_admin'=>1
            );
        }
        else
        {
            $perm_setting = $this->perm_setting ? unserialize($this->perm_setting) : array();

            # 删除特殊权限
            if ( isset($perm_setting['_super_admin']) )unset($perm_setting['_super_admin']);
        }

        $_permission = new Permission($perm_setting);

        return $_permission;
    }

    public function ifLogin($bAutoAddExpire = false)
    {
        if (Session::instance()->get('admin_member_id')) {
            return true;
        } else {
            return false;
        }
    }


    public function doLogin($sUsername, $sPassword, &$sErrMsg) {
        $bRS = true;
        $U = $this->find(array('username' => $sUsername));
        if (!$U->id) {
            $bRS = false;
            $sErrMsg = '您的账号不存在，请联系管理员开通';
            goto END;
        } else if ($U->shielded == 1) {
            $bRS = false;
            $sErrMsg = '您的账号禁止登录，请联系管理员开通';
            goto END;
        } else if ($U->password != md5($sPassword)) {
            $bRS = false;
            $sErrMsg = '您的密码错误，请重新输入';
            goto END;
        }
        $U->last_login_time = date('Y-m-d H:i:s');


        Session::instance()->setMember($U);
        Session::instance()->set('admin_member_id', $U->id);
        $U->where("id={$U->id}")->save();

        END:
        return $bRS;
    }

}

