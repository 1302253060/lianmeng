<?php
namespace Home\Controller;


use Admin\Model\HelpModel;
use Common\Helper\Arr;

class HelpController extends BaseController {

    protected $SITE_HEADNAV = 'Help';
    protected $bGetUser = false;

    public function index(){
        $aType     = HelpModel::$aType;
        $aAllData  = M("t_help_question")->field("id, type, title")->where(array('status' => HelpModel::STATUS_ONLINE))->order("sort desc, create_time desc")->select();
        $aData     = array();
        foreach ($aAllData as $aVal) {
            $aData[$aVal['type']][] = $aVal;
        }
        unset($aAllData);
        $aRec = M("t_help_question")->field("id, type, title")->where(array('status' => HelpModel::STATUS_ONLINE))->order("sort desc, create_time desc")->limit(8)->select();
        $this->assign("aData", $aData);
        $this->assign("aType", $aType);
        $this->assign("aRec", $aRec);
    }

    public function help_list() {
        $aType  = HelpModel::$aType;
        $type   = I("get.type");
        $search = I("get.search");
        $aWhere = array();
        if (!empty($type)) {
            $aWhere['type'] = $type;
        }

        if (!empty($search)) {
            $aWhere['title'] = array('like', "%{$search}%");
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('t_help_question'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $Model->field("id, type, title")->where($aWhere)->order('sort desc,create_time desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出

        $aRec = M("t_help_question")->field("id, type, title")->where(array('status' => HelpModel::STATUS_ONLINE))->order("sort desc, create_time desc")->limit(8)->select();

        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
        $this->assign("aType", $aType);
        $this->assign("type", $type);
        $this->assign("aRec", $aRec);
    }

    public function detail() {
        $iID = I("get.id");
        $aData  = M("t_help_question")->where(array('status' => HelpModel::STATUS_ONLINE, 'id' => $iID))->find();
        if (empty($aData)) {
            $this->fail("操作错误", '/');
            return false;
        }
        $aRec = M("t_help_question")->field("id, type, title")->where(array('status' => HelpModel::STATUS_ONLINE))->order("sort desc, create_time desc")->limit(8)->select();

        $this->assign("aData", $aData);
        $this->assign("aRec", $aRec);
    }
}
