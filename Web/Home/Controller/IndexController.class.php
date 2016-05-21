<?php
namespace Home\Controller;


use Admin\Model\SoftModel;
use Common\Helper\Session;

class IndexController extends BaseController {

    protected $bGetUser = false;
    protected $SITE_FOOT_JS = array('/Public/statics/js/app/main.js');
    public function index(){
        $User = $this->getUser();
        if ($User && $User->id) {
            $this->assign("User", $User);
        }
        $aSoft = M("soft")->field("id,logo,name,price")->where(array('status' => 1))->limit(8)->select();
        $this->assign("aSoft", $aSoft);
    }
}
