<?php
namespace Home\Controller;

use Admin\Model\UserModel;
use Think\Controller;
use Common\Helper\Session;
use Common\Helper\Permission;

class BaseController extends Controller {

    const INV_CODE_EXPIRE_DAY = 10;
    protected $sTPL     = './Web/Home/View/__Layout_User__.php';
    protected $sMainTPL = null;
    protected $Session;
    protected $bNeedAuth = true;
    protected $bCheckLogin = true;
    protected $location  = array();
    protected $iDefaultNumberPerPage = 25;

    protected $aData = array();

    protected $SITE_HEADNAV = 'Index';

    const LM_SEND_MSG_COOKIE_KEY = 'LM_SEND_MSG';
    protected $bGetUser = true;
    protected $sLoginPageUrl = '/';

    protected $sRegPageUrl = '/Home/user/register';

    protected $SITE_FOOT_JS = array();

    public function __construct() {
        parent::__construct();

        $User         = null;
        $iUnreadCount = 0;
        if ($this->bGetUser || Session::instance()->get('home_member_id')) {
            $this->User = $this->getUser();
            if ($this->User === false) {
                $this->fail("请先登录系统", $this->sLoginPageUrl);
                return false;
            }
            if ($this->User->hidden == UserModel::LOGIN_HIDDEN) {
                $this->fail("您的用户已经被禁止登录, 如有疑问请跟管理员联系", '/home/user/login');
                return false;
            }
            $User = $this->User;
            $iUnreadCount = M("message")->where(array('receiv_user_id' => $this->User->id, 'status' => 0))->count();
            $this->assign('SIDEBAR', (int)$this->User->level === UserModel::LEVEL_ONE ? 'Manager' : 'Channel');
        }
        $this->sMainTPL = T();
        $this->assign("SITE_HEADNAV", $this->SITE_HEADNAV);
        $this->assign("SITE_FOOT_JS", $this->SITE_FOOT_JS);
        $this->assign("User", $User);
        $this->assign("iUnreadCount", $iUnreadCount);


    }


    /**
     * 设置是否需要进行权限验证
     * @param bool $bNeedAuth
     */
    public function setNeedAuth($bNeedAuth = true) {
        $this->bNeedAuth = $bNeedAuth;
    }

    public function getNeedAuth() {
        return $this->bNeedAuth;
    }


    public function __destruct() {
        if ($this->sTPL !== null) {
            $this->assign("sMainTPL", $this->sMainTPL);
            $this->display($this->sTPL);
        }

    }

    /**
     * 成功
     * @param string $sMsg
     * @param null $sUrl
     * @param array $aData
     */
    protected function succ($sMsg = '', $sUrl = null, $aData = array())
    {
        $this->_result(0, $aData, $sMsg, $sUrl);
    }

    /**
     * 失败
     * @param string $sMsg
     * @param null $sUrl
     * @param int $iCode
     */
    protected function fail($sMsg = '失败', $sUrl = null, $iCode = -1)
    {
        $this->_result($iCode, array(), $sMsg, $sUrl);
    }

    /**
     * 成功,但有警告
     * @param string $sMsg
     * @param null $sUrl
     * @param array $aData
     */
    protected function warn($sMsg = '', $sUrl = null, $aData = array())
    {
        $this->_result(2, $aData, $sMsg, $sUrl);
    }


    protected function _result($iCode, $aData, $sMsg, $sUrl)
    {
        if (IS_AJAX) {
            $this->sTPL = null;
            echo json_encode(array(
                'errCode'  => $iCode,
                'msg'   => $sMsg,
                'data'  => $aData,
            ));

        } else {
            if ($sUrl == null) {
                $sUrl = $_SERVER['HTTP_REFERER'];
            } else {
                $sUrl = $sUrl;
            }
            header("Content-Type', 'text/html; charset=utf-8");
            echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script>alert('{$sMsg}');window.location.href='{$sUrl}';</script>";
            exit();
//            redirect($sUrl);
        }

    }

    /**
     * 设置是否需要验证登录
     * @param bool $bCheckLogin
     */
    public function setCheckLogin($bCheckLogin = true) {
        $this->bCheckLogin = $bCheckLogin;
    }

    public function getCheckLogin() {
        return $this->bCheckLogin;
    }



    protected $User = null;
    protected function getUser()
    {
        $User = false;

        $uid = Session::instance()->get('home_member_id');
        if (!$uid) {
            goto END;
        }
        $User = new \Admin\Model\UserModel();
//        $User = D("user", "\\Admin\\Model\\UserModel");
        $User->create();

        $data=$User->where(array('id' => $uid, 'is_login' => 1))->find();

        if (empty($User->id)) {
            $User = false;
        }
        if (!empty($User->id)) {
            $User->update_time = date('Y-m-d H:i:s');
            $User->save();
            $User->create($data);
        }

        END:

        return $User;
    }




}



