<?php
namespace Home\Controller;


use Admin\Model\SoftModel;

class PacketController extends BaseController {

    protected $SITE_HEADNAV = 'Packet';
    protected $bGetUser = false;

    public function index(){
        $type = I("get.type", 'pc');

        $aWhere = array('status' => SoftModel::STATUS_ONLINE);
        if ($type == 'pc') {
            $aWhere['type'] = SoftModel::TYPE_PC;
        } elseif ($type == 'app') {
            $aWhere['type'] = SoftModel::TYPE_APP;
        } else {
            $this->fail("操作错误", '/');
            return false;
        }
        $aSoft  = M("soft")->where($aWhere)->order("show_order desc")->select();


        $this->assign("aSoft", $aSoft);
        $this->assign("type", $type);
    }

    public function detail() {
        $iID = I("get.id");
        if (empty($iID)) {
            $this->fail("非法ID", '/');
            return false;
        }
        $aWhere = array('status' => SoftModel::STATUS_ONLINE, 'id' => $iID);
        $aSoft  = M("soft")->where($aWhere)->find();
        if (empty($aSoft)) {
            $this->fail("数据不存在或者已经下线", '/');
            return false;
        }
        $this->assign("aSoft", $aSoft);
    }
}
