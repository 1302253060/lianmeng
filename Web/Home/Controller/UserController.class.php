<?php
namespace Home\Controller;


use Admin\Model\MessageModel;
use Admin\Model\UserModel;
use Common\Helper\Common;
use Common\Helper\Message;
use Common\Helper\MobileCaptcha;
use Common\Helper\Session;

class UserController extends BaseController {

    const USER_TYPE_COMPANY  = 1;
    const USER_TYPE_PERSONAL = 2;
    protected $bGetUser = false;
    private $bInvCode;
    private $MInvCode;
    public function register(){
        $this->sTPL = null;
        $User = $this->getUser();
        if ($User !== false || !empty($User->id)) {
            redirect("/");
            return false;
        }
        $this->display();
    }

    public function register_post() {
        $aParams = array(
            'inv_code'        => I('post.inv_code'),
            'mobile'          => I('post.mobile'),
            'mobile_captcha'  => I('post.mobile_captcha'),
            'name'            => I('post.name'),
            'qq'              => I('post.qq'),
            'province'        => I('post.province'),
            'city'            => I('post.city'),
            'county'          => I('post.county'),
            'code'            => I('post.code'),
            'reg_type'        => I('post.reg_type'),
            'address'         => I('post.address'),
            'email'           => I('post.email'),
            'password'        => I('post.password'),
            'confirm_password'=> I('post.confirm_password'),
        );
        $aTmpPostData = Common::clearData($aParams);

        //必须按照顺序校验
        foreach($aParams as $sKey => $sVal) {
            $aPostData[$sKey] = isset($aTmpPostData[$sKey]) ? $aTmpPostData[$sKey] : null;
        }

        $bRet = $this->_checkCreateUserParams($aPostData);
        if(!$bRet) {
            goto END;
        }

        $bRet = $this->_createNewUserRegister($aPostData);
        if($bRet) MobileCaptcha::delete($aPostData['mobile']);
        goto END;

        END:

        cookie(self::LM_SEND_MSG_COOKIE_KEY, null);
    }


    private function _createNewUserRegister($aPostData) {
        $aRet = array();
        $MInvCode = $this->MInvCode;
        if($this->bInvCode && empty($MInvCode->code)) {
            $this->fail('邀请码无效', null, 5002);
            goto END;
        }

        //默认值
        $aTmp = array(
            'create_time'   => date('Y-m-d H:i:s'),
            'parent_id'     => 0,
            'level'         => UserModel::LEVEL_ONE,
            'status'        => 0,
            'client_ip'     => ip2long(get_client_ip()),
            'password'      => md5($aPostData['password']),
            'name'          => $aPostData['name'],
            'qq'            => $aPostData['qq'],
            'email'         => $aPostData['email'],
            'mobile'        => $aPostData['mobile'],
            'province'      => $aPostData['province'],
            'city'          => $aPostData['city'],
            'county'        => $aPostData['county'],
            'address'       => $aPostData['address'],
            'is_login'      => 1,
        );

        $MUser = M("user");
        if($this->bInvCode && $MInvCode->fetch_user_id > 0) {//有邀请码
            $ITUser = $this->ITUser;
            $aTmp['parent_id'] = $ITUser->id;
            $aTmp['level']     = UserModel::LEVEL_TWO;
        } elseif(!$this->bInvCode) {
            $aTmp['parent_id'] = 0;
            $aTmp['level']     = UserModel::LEVEL_ONE;
        } else {
            $this->fail('非法注册', null, 9999);
            goto END;
        }

        $iInserID = $MUser->add($aTmp);
        if(!$iInserID) {
            $this->fail('插入用户失败', null, 3002);
            goto END;
        }

        $MUser->parent_id = $iInserID;
        $MUser->where(array('id' => $iInserID))->save();

        if ($this->bInvCode) { //有邀请码
            //更改邀请码的信息
            $MInvCode->apply_user_id = $iInserID;
            $MInvCode->apply_time    = date('Y-m-d H:i:s');
            $MInvCode->status        = 2;
            if (!$MInvCode->where(array('code' => $MInvCode->code))->save()) {
                $this->fail('更新邀请码失败',null,3004);
                goto END;
            }
        }
        $this->succ('插入新用户成功');
        return true;
        END:
        return false;
    }


    private function _checkCreateUserParams($aPostData) {
        if(!is_array($aPostData)) {
            $this->fail('POST数据有误', null, 5000);
            return false;
        }
        foreach($aPostData as $key => $value) {
            switch ($key) {
                case 'reg_type':
                    if (!in_array($value, array(
                        self::USER_TYPE_COMPANY,
                        self::USER_TYPE_PERSONAL
                    ))) {
                        $this->fail('表单参数错误', null, 5002);
                        return false;
                    }
                    break;
                case 'inv_code' :
                    if ($aPostData['reg_type'] == self::USER_TYPE_COMPANY) {
                        $this->bInvCode = false; //无邀请码注册
                        break;
                    }
                    $this->bInvCode = true;
                    if(!$this->_checkInvCode()) {
                        return false;
                    }
                    break;
                case 'code' :
                    if (empty($value) || !$this->_checkVerify($value)) {
                        $this->fail('图片验证码填写错误', null, 5064);
                        return false;
                    }
                    break;
                case 'mobile' :
                    if (empty($value) || !Common::isMobileNum($value)) {
                        $this->fail('请填写手机号', null, 5004);
                        return false;
                    }
//                    $iLevel = $aPostData['reg_type'] == self::USER_TYPE_COMPANY ? UserModel::LEVEL_ONE : UserModel::LEVEL_TWO;
                    $iUniqueMobile = M("user")->where(array('mobile' => $value))->count();
                    if($iUniqueMobile) {
                        $this->fail('手机号已绑定且验证!', null, 5005);
                        return false;
                    }
                    break;
                case 'mobile_captcha' :
                    $aMobileCapchaRet = $this->_checkMobileCaptcha($aPostData['mobile'], $value);
                    if(!empty($aMobileCapchaRet['error']) || $aMobileCapchaRet['error'] != 0) {
                        $this->fail('手机验证码填写错误!', null, 5006);
                        return false;
                    }
                    break;
                case 'name' :
                    $iStrlen = mb_strlen($value,'utf-8');
                    if(empty($value)) {
                        $this->fail('请填写用户名!', null, 5007);
                        return false;
                    } elseif (!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$value) || $iStrlen < 2 || $iStrlen > 4) {
                        $this->fail('用户名必须是2-4个汉字!', null, 5012);
                        return false;
                    }
                    break;
                case 'qq' :
                    if(!empty($value) && !Common::isQQNum($value)) {
                        $this->fail('请填写QQ!', null, 5008);
                        return false;
                    }
                    break;
                case 'province' :
                    if(empty($value)) {
                        $this->fail('请填写省份信息', null, 5009);
                        return false;
                    }
                    break;
                case 'city' :
                    if(empty($value)) {
                        $this->fail('请填写城市信息', null, 5010);
                        return false;
                    }
                    break;
                case 'county' :
                    if(empty($value)) {
                        $this->fail('请填写县级信息', null, 5010);
                        return false;
                    }
                    break;
                case 'address' :
                    if(empty($value)) {
                        $this->fail('请填写用户详细地址', null, 5010);
                        return false;
                    }
                    break;
                case 'email' :
                    if(empty($value)) {
                        $this->fail('请填写正确的邮箱地址', null, 5040);
                        return false;
                    }
                    break;
                case 'password' :
                    if(empty($value)) {
                        $this->fail('请填写密码', null, 5041);
                        return false;
                    }
                    break;
                case 'confirm_password' :
                    if(empty($value) || $aPostData['password'] != $aPostData['confirm_password']) {
                        $this->fail('两次输入的密码不一致', null, 5042);
                        return false;
                    }
                    break;
                default:
                    break;
            }
        }
        return true;
    }

    private function _checkInvCode($iRet = false) {

        $sInvCode = I('post.inv_code');
        if(empty($sInvCode)) {
            $this->fail('邀请码为空，请重新输入', null, 2001);
            goto END;
        }
        $iExpireDay = self::INV_CODE_EXPIRE_DAY;
        $sEffTime = strtotime("-{$iExpireDay} day");

        $MInvCode = M("inv_code");
        $MInvCode->create();
        //查询有效邀请码
        $MInvCode->where(array('code' => $sInvCode, 'status' => 1))->find();
        if(empty($MInvCode->code)) {
            $this->fail('此邀请码失效，请联系客服重发邀请码', null, 2002);
            goto END;
        }
        if(strtotime($MInvCode->fetch_time) < $sEffTime) {
            $this->fail('此邀请码已过期失效，请联系客服重发邀请码',null,2003);
            goto END;
        }
        $this->MInvCode   = $MInvCode;

        $MUser = M("user");
        $MUser->create();
        $MUser->where(array('id' => $MInvCode->fetch_user_id))->find();
        if(empty($MUser->id)
            || $MUser->level == UserModel::LEVEL_TWO
            || !UserModel::isAllowLogin($MUser->hidden)
        ) {
            $this->fail('邀请码输入错误，请重新输入', null, 2004);
            goto END;
        }
        $this->ITUser     = $MUser;

        if($iRet) {
            $this->succ('验证成功');
        }
        return true;

        END:
        return false;
    }

    private function _checkMobileCaptcha($iMobile, $iVal) {
        $aRet       = array();

        if(empty($iMobile) || !Common::isMobileNum($iMobile)) {
            $aRet = array('error' => 1003, 'errmsg' => '手机号不正确');
            goto RET;
        }
        if(empty($iVal)) {
            $aRet = array('error' => 1009, 'errmsg' => '输入的验证码为空');
            goto RET;
        }

        $bRet = MobileCaptcha::check($iMobile, $iVal);
        if(!$bRet) {
            $aRet = array('error' => 1010, 'errmsg' => '输入的验证码不正确');
            goto RET;
        }

        $aRet = array('error' => 0, 'errmsg' => '验证成功');

        RET:
        return $aRet;
    }

    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串
    private function _checkVerify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }


    public function check_inv_code_post() {
        $this->_checkInvCode(true);
    }


    #验证手机验证码
    public function check_captcha_post(){
        $iVal         = I('post.mobile_captcha');
        $iMobile      = I('post.mobile');
        $aRet         = $this->_checkMobileCaptcha($iMobile, $iVal);
        if(!is_array($aRet) || ($aRet['error'] != 0)) {
            $this->fail($aRet['errmsg'], null, $aRet['error']);
            goto RET;
        }
        $this->succ($aRet['errmsg']);
        RET:
    }


    public function login_post() {
        $iMobile   = I('post.mobile');
        $sPassword = I('post.password');
        $code      = I('post.code');
        if (empty($iMobile) || !Common::isMobileNum($iMobile)) {
            $this->fail("手机号格式错误", null, 6001);
            goto END;
        }
        if (empty($sPassword)) {
            $this->fail("密码不能为空", null, 6002);
            goto END;
        }
        if (empty($code) || !$this->_checkVerify($code)) {
            $this->fail('图片验证码填写错误', null, 5064);
            goto END;
        }

        $aUser = M("user")->where(array('mobile' => $iMobile, 'password' => md5($sPassword), 'is_login' => 1))->find();
        if ($aUser['id']) {
            Session::instance()->set('home_member_id', $aUser['id']);
            $this->succ("登录成功");
        } else {
            $this->fail("用户名或者密码错误", null, 6003);
        }
        END:
    }


    public function check_mobile_post() {
        $reg_type = I('post.reg_type', self::USER_TYPE_COMPANY);
        if ($reg_type == self::USER_TYPE_PERSONAL && !$this->_checkInvCode()) {
            goto END;
        }

        $iMobile  = I('post.mobile');

//        $iLevel   = $reg_type == self::USER_TYPE_COMPANY ? UserModel::LEVEL_ONE : UserModel::LEVEL_TWO;

        if (empty($iMobile) || !Common::isMobileNum($iMobile)) {
            $this->fail('请填写手机号', null, 5004);
            goto END;
        }
        $iUniqueMobile = M("user")->where(array('mobile' => $iMobile))->count();
        if($iUniqueMobile) {
            $this->fail('手机号已绑定且验证!', null, 5005);
            goto END;
        } else {
            $this->succ('该手机号可以正常注册');
            goto END;
        }

        END:
    }

    public function get_captcha_post() {
        $iMobile    = I('post.mobile');
        $iOldMobile = I('post.old_mobile');
        $User = $this->getUser();

        // 已经绑定判断老的手机号是否一致
        if(!empty($iOldMobile) && !empty($User->id)) {
            if(!$User->mobile || $User->mobile != $iOldMobile) {
                $this->fail('新旧手机不一致', null, 1001);
                goto RET;
            }
        }
        $sRedisKey = self::LM_SEND_MSG_COOKIE_KEY . '_send_message_' . $iMobile;
        $bSendMsg = S($sRedisKey);
        if($bSendMsg) {
            $this->fail('60秒内已发送过', null, 1002);
            goto RET;
        }
        if(empty($iMobile) || !Common::isMobileNum($iMobile)) {
            $this->fail('手机号不正确', null, 1003);
            goto RET;
        }
        $bMsgRet = $this->_getMobileCaptcha($iMobile);
        if(!$bMsgRet) {
            $this->fail('手机验证码发送失败', null, 1005);
            goto RET;
        }
        S($sRedisKey, 1, 60);
        $this->succ('发送成功');
        RET:
    }

    private function _getMobileCaptcha($iMobile) {
        $iVal = MobileCaptcha::get($iMobile, 6, 300);
        if(!$iVal) {
            return false;
        }

        $bMsgRet = Message::send(
            0,
            Message::$aMessageTpl['register_tpl']['sSignName'],
            json_encode(array('code' => $iVal, 'product' => Message::PRODUCT)),
            array($iMobile),
            Message::$aMessageTpl['register_tpl']['sCode']
        );

        return $bMsgRet;
    }

    public function loginout() {
        Session::instance()->destory();
        header("Location: /");
    }


    public function check_mobile_captcha_update_post() {
        $iMobile    = I('post.mobile');
        $iOldMobile = I('post.old_mobile');
        $iVal       = I('post.mobile_captcha');
        $aRet       = $this->_checkMobileCaptcha($iMobile, $iVal);
        if(!is_array($aRet) || ($aRet['error'] != 0)) {
            $this->fail($aRet['errmsg'], null, $aRet['error']);
            goto RET;
        }

        $User = $this->getUser();
        if(!empty($User->id)) {
            $MUser = $User;
        } else {
            $this->fail('用户不存在!!!', null, 1006);
            goto RET;
        }
        # 用户已绑定过手机,校验旧手机号是否一致
        $sTempMobile = $MUser->mobile;
        if(empty($sTempMobile) || $sTempMobile != $iOldMobile) {
            $this->fail('新旧手机不一致', null, 1001);
            goto RET;
        }

        $bUniqueMobile = M("user")->where(array('mobile' => $iMobile))->count();
        if($bUniqueMobile) {
            $this->fail('手机号已绑定且验证', null, 1007);
            goto RET;
        }
        if (!M("user")->where(array('id' => $User->id))->save(array('mobile' => $iMobile))) {
            $this->fail('修改失败', null, 1008);
            goto RET;
        }
        # 验证成功后把cookie设为空
        $bSendMsg = cookie(self::LM_SEND_MSG_COOKIE_KEY);
        if($bSendMsg) {
            cookie(self::LM_SEND_MSG_COOKIE_KEY, null);
        }
        $this->succ('更新成功');
        RET:
    }


    public function forget_password() {
        $this->sTPL = null;
        $User = $this->getUser();
        if ($User !== false || !empty($User->id)) {
            redirect("/");
            return false;
        }
        $this->display();
    }



    public function check_mobile_code_post() {

        $iMobile  = I('post.mobile');
        $iCode    = I('post.code');

        if (empty($iMobile) || !Common::isMobileNum($iMobile)) {
            $this->fail('请填写手机号', null, 5004);
            goto END;
        }
        if (empty($iCode) || !$this->_checkVerify($iCode)) {
            $this->fail('图片验证码填写错误', null, 5064);
            goto END;
        }

        $iUniqueMobile = M("user")->where(array('mobile' => $iMobile))->count();
        if($iUniqueMobile) {
            $this->succ('该手机号存在');
            goto END;
        } else {
            $this->fail('该手机号没有注册', null, 8001);
            goto END;
        }

        END:
    }

    #验证手机验证码
    public function check_forget_captcha_post(){
        $iVal         = I('post.mobile_captcha');
        $iMobile      = I('post.mobile');
        $aRet         = $this->_checkMobileCaptcha($iMobile, $iVal);
        if(!is_array($aRet) || ($aRet['error'] != 0)) {
            $this->fail($aRet['errmsg'], null, $aRet['error']);
            goto RET;
        }

        $sRedisKey = self::LM_SEND_MSG_COOKIE_KEY . '_send_forget_message_' . $iMobile;
//        S($sRedisKey, 1, 180);
        session($sRedisKey, 1);

        $this->succ($aRet['errmsg']);
        RET:
    }


    public function set_password_post() {
        $sPassword    = I('post.password');
        $sConfirmPassword = I('post.confirm_password');
        $iMobile      = I('post.mobile');
        if (empty($iMobile) || empty($sPassword) || empty($sConfirmPassword)) {
            $this->fail('信息填写有误', null, 9001);
            goto RET;
        }

        if ($sPassword != $sConfirmPassword) {
            $this->fail('两次输入的密码不一致', null, 9002);
            goto RET;
        }

        $sRedisKey = self::LM_SEND_MSG_COOKIE_KEY . '_send_forget_message_' . $iMobile;
//        $sRet = S($sRedisKey);
        $sRet = session($sRedisKey);

        if (!$sRet) {
            $this->fail('非法操作', null, 9003);
            goto RET;
        }

        $bRet = M("user")->where(array('mobile' => $iMobile, 'is_login' => 1))->save(array('password' => md5($sPassword)));
        if ($bRet) {
            $this->succ('操作成功');
            goto RET;
        } else {
            $this->fail('非法操作', null, 1000);
            goto RET;
        }
        RET:
    }
}
