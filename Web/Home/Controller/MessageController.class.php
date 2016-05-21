<?php
namespace Home\Controller;


class MessageController extends BaseController {

    protected $SITE_HEADNAV = 'User';

    public function index(){
        $User   = $this->User;
        $aWhere = array('receiv_user_id' => $User->id);

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('message'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $Model->where($aWhere)->order('create_time desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出


        $this->assign("aList", $aList);
        $this->assign("sPagination", $show);
        $this->assign("iAllCount", $count);
    }

    public function read_post() {
        $User = $this->User;
        $id = I('post.id');
        if(empty($id) || !is_numeric($id)) {
            $this->fail('参数错误');
            return;
        }
        $aData = M("message")->where(array('id' => $id))->find();
        if(empty($aData)) {
            $this->fail('该消息不存在');
            return;
        }
        if((int)$aData['status'] == 1) {
            $this->fail('该消息已设置为已读');
            return;
        }
        if($aData['receiv_user_id'] != $User->id) {
            $this->fail('您没有权限查看该消息');
            return;
        }
        $bRet = M("message")->where(array('id' => $id))->save(array('status' => 1, 'update_time' => date('Y-m-d H:i:s')));
        if(!$bRet) {
            $this->fail('更新失败!!!');
            return;
        }

        $iCount = M("message")->where(array('receiv_user_id' => $User->id,'status' => 0))->count();
        $this->succ('设为已读成功','',array('msg_num' => $iCount));
    }

}
