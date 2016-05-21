<?php
namespace Home\Controller;


class AnnoController extends BaseController {

    protected $SITE_HEADNAV = 'Anno';
    protected $bGetUser = false;

    public function index(){
        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('anno'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $Model->where(array('status' => array('neq', 0)))->order('status desc,create_time desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where(array())->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
    }

    public function detail(){
        $iID   = I("get.id");
        $aData = M("anno")->where(array('id' => $iID, 'status' => array('neq', 0)))->find();
        if (empty($aData)) {
            $this->fail("操作错误", '/');
            return false;
        }
        $this->assign('aData', $aData);
    }

}
