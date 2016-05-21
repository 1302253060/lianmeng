<?php
namespace Home\Controller;


use Admin\Model\UserModel;
use Common\Helper\Constant;
use Common\Helper\IDCard;

class AccountController extends BaseController {

    protected $SITE_HEADNAV = 'User';

    protected $SITE_FOOT_JS = array('/Public/statics/js/app/user_account.js');

    public function index(){
        $User = $this->User;

        $this->assign("User", $User);
    }

    public function mobile() {
        $User = $this->User;

        $this->assign("User", $User);
    }

    public function card() {

    }


    public function company() {
        $User = $this->User;
        if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
            $this->fail('你没有权限操作', '/');
            return;
        }

        $this->assign("User", $User);
    }

    public function update_post(){
        $aPost = array();
        $sQq   = I('post.qq');
        if (!empty($sQq)) {
            if (!IDCard::isNumber($sQq)) {
                $this->fail("请输入正确的QQ号码", null, 1001);
                goto END;
            }
        }
        $aPost['qq'] = $sQq;
        $sProvince = I('post.province');
        $sCity     = I('post.city');
        $sCounty   = I('post.county');
        if(empty($sProvince) || empty($sCity) || empty($sCounty)) {
            $this->fail("请填写省份和城市！", null, 1002);
            goto END;
        }
        $aPost['province'] = $sProvince;
        $aPost['city']     = $sCity;
        $aPost['county']   = $sCounty;
        $sAddress          = I('post.address');
        $aPost['address']   = $sAddress;

        $sEmail   = I('post.email');
        if (empty($sEmail)) {
            $this->fail('请填写正确的邮箱', null, 1004);
            goto END;
        }
        $aPost['email']   = $sEmail;

        $sSubbranch = I('post.subbranch');
        $sPayee     = I('post.payee');
        $sBankcard  = I('post.bankcard');
        if (empty($sSubbranch)) {
            $this->fail('请填写正确的开户行', null, 1005);
            goto END;
        }
        if (empty($sPayee)) {
            $this->fail('请填写正确的收款人信息', null, 1006);
            goto END;
        }
        if (empty($sBankcard)) {
            $this->fail('请填写正确的银行账号', null, 1007);
            goto END;
        }
        $aPost['subbranch']  = $sSubbranch;
        $aPost['payee']      = $sPayee;
        $aPost['bankcard']   = $sBankcard;

        $bRet = M("user")->where(array('id' => $this->User->id))->save($aPost);
        if (!$bRet) {
            $this->fail('更新失败，请与管理员联系', null, 1003);
            goto END;
        }
        $this->succ('success');
        END:
    }

    private $aMapErrMsg = array(
        65535 => '上传失败',
        0     => '',
    );

  public function img_upload() {
      $this->sTPL = null;
      $aRes = array(
          'errCode'  => 0,
          'msg'      => '',
          'data'     => array(),
      );

      $sPostName = 'idcard_img';
      $upload = new \Think\Upload();// 实例化上传类
      $upload->maxSize   = 3145728 ;// 设置附件上传大小3M
      $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
      $upload->rootPath  = Constant::UPLOAD_DIR; // 设置附件上传根目录
      $upload->savePath  = 'img/'; // 设置附件上传（子）目录
      // 上传文件
      $info   =   $upload->upload();

      $aData  = array();
      if ($info && isset($info[$sPostName])) {
          $aD          = $info[$sPostName];
          $aD['error'] = 0;
      } else {
          $aRes = array(
              'errCode'  => 1,
              'msg'      => '上传错误',
              'data'     => array(),
          );
          goto END;
      }
      $aData['fileinfo']           = $aD;
      $aData['fileinfo']['errmsg'] = isset($this->aMapErrMsg[$aD['error']]) ?
          $this->aMapErrMsg[$aD['error']] :
          'unknown';

      if ($aD['error'] == 0) {
          $sDir                               = Constant::UPLOAD_DIR;
          $sFile                              = $aD['savepath'] . $aD['savename'];
          $aData['fileinfo']['org_file_name'] = $sFile;
          $aData['fileinfo']['url']           = Constant::IMAGE_URL . trim(trim($sDir, '.'), '/') . '/' . $sFile;
          $aRes = array(
              'errCode'  => 0,
              'msg'      => '上传成功',
              'data'     => $aData,
          );
          goto END;
      } else {
          $aRes = array(
              'errCode'  => 1,
              'msg'      => '上传错误',
              'data'     => array(),
          );
          goto END;
      }

      END:
      echo json_encode($aRes);
  }


  public function company_post() {

      $User = $this->User;

      if ((int)$User->level === \Admin\Model\UserModel::LEVEL_TWO) {
          $this->fail('你没有权限操作', null, 10);
          goto RET;
      }

      if((int)$User->company_status === UserModel::COMPANY_PASS) {
          $this->fail("你已经通过验证", null, 4001);
          goto RET;
      }

      if((int)$User->company_status === UserModel::COMPANY_REVIEW) {
          $this->fail("你已经提交认证，请等待", null, 4003);
          goto RET;
      }

      $company_name = I("post.company_name");
      $company_abbr = I("post.company_abbr");
      $idcard_img1  = I("post.idcard_img1");
      $idcard_img2  = I("post.idcard_img2");
      $idcard_img3  = I("post.idcard_img3");

      if(empty($company_name) || empty($company_abbr) || empty($idcard_img1) || empty($idcard_img2) || empty($idcard_img3)) {
          $this->fail('信息填写不完整', null, 4002);
          goto RET;
      }
      $aPost = array(
          'company_name'     => $company_name,
          'company_abbr'     => $company_abbr,
          'business_license' => $idcard_img1,
          'tax_certificate'  => $idcard_img2,
          'organization_code'=> $idcard_img3,
          'company_status'   => UserModel::COMPANY_REVIEW,
      );

      $bRet = M("user")->where(array('id' => $User->id))->save($aPost);
      if($bRet) {
          $this->succ('上传成功');
      }else{
          $this->fail('上传失败', null, 10);
      }
      RET:
  }


    public function install() {

    }

    public function install_update_post() {
        $aPost = array();
        $pc_install   = I('post.pc_install');
        $pc_mark      = I('post.pc_mark');
        $app_install  = I('post.app_install');
        $app_mark     = I('post.app_mark');
        if (empty($pc_install) && empty($app_install)) {
            $this->fail("填写错误", null, 1003);
            goto END;
        }

        $User = $this->User;
        $User->setNoteInfo(
            array(
                'pc_install'  => $pc_install,
                'pc_mark'     => $pc_mark,
                'app_install' => $app_install,
                'app_mark'    => $app_mark,
            )
        );
        $bRet = $User->save();
        if (!$bRet) {
            $this->fail('更新失败，请与管理员联系', null, 1003);
            goto END;
        }
        $this->succ('success');
        END:
    }
}
