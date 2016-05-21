<?php
namespace Admin\Controller;

use Think\Controller;
use Common\Helper\Session;
class LoginController extends BaseController {

    protected $bCheckLogin = false;
    protected $bNeedAuth = false;

    public function index() {
        $Admin = new \Admin\Model\AdminModel();
        if ($Admin->ifLogin()) {
            header("Location: /admin/user/list");
        }
        $this->sTPL = null;
        $this->display();
    }

    public function index_post() {

        $sRetUrl = I('get.ret_url');
        $sUsername = I('post.username');
        $sPassword = I('post.password');
        $sDefaultJumpUrl = empty($sRetUrl) ? '/' : $sRetUrl;

        if (empty($sUsername) || empty($sPassword)) {
            $this->fail('请输入用户名或者密码');
        } else {
            $Admin = new \Admin\Model\AdminModel();
            $Admin->doLogin($sUsername, $sPassword, $sErrMsg) ?
                $this->succ('登录成功', $sDefaultJumpUrl) :
                $this->fail($sErrMsg);
        }
    }

    public function out() {
        Session::instance()->destory();
        header("Location: /admin/login/index");
    }
}
