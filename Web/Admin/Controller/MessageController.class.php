<?php
namespace Admin\Controller;

use Admin\Model\KvModel;
use Admin\Model\MessageModel;
use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
class MessageController extends BaseController {

    private $_aChannel = array(
        MessageModel::CHANNEL_TYPE_ALL   => '全部渠道',
        MessageModel::CHANNEL_TYPE_ONE   => '一级渠道',
        MessageModel::CHANNEL_TYPE_TWO   => '二级渠道',
        MessageModel::CHANNEL_TYPE_OTHER => '其他渠道',
    );

    private $_aType = array(
        MessageModel::TYPE_MESSAGE => '站内信',
        MessageModel::TYPE_MOBILE  => '手机短信',
        MessageModel::TYPE_EMAIL   => '邮箱',
    );

    public function add() {
        $channel = I('post.channel', MessageModel::CHANNEL_TYPE_ALL);
        $this->assign("aChannel", $this->_aChannel);
        $this->assign("channel", $channel);
        $this->assign("aType", $this->_aType);

    }


    public function add_post() {
        $channel = I('post.channel');
        $title   = I('post.title');
        $content = I('post.content');
        $type    = I('post.type', MessageModel::TYPE_MESSAGE);

        $Model = M("message_list");
        $Model->create();
        if ($channel == MessageModel::CHANNEL_TYPE_OTHER) {
            $other_user = I('post.other_user');
            $Model->channel_list  = $other_user;
        }


        $Model->channel_type   = $channel;
        $Model->title   = $title;
        $Model->type    = $type;
        $Model->content = html_entity_decode($content);
        $Model->status  = MessageModel::STATUS_SEND_NO;
        $Model->create_time  = date('Y-m-d H:i:s');
        $Model->update_time  = date('Y-m-d H:i:s');

        if ($Model->add()) {
            $this->succ("发送成功，请耐心等待2-5分钟");
        } else {
            $this->fail("发送失败");
        }
    }

    public function index() {
        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Model = M('message_list'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $Model->where(array())->order('create_time desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Model->where(array())->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
    }


    public function detail() {
        $iMsgId = I('get.msg_id');
        if(empty($iMsgId)) {
            $this->fail('该站内信不存在');
            return;
        }

        $Model = M("message_list");
        $Model->getById($iMsgId);

        if(empty($Model->id)) {
            $this->fail('该站内信不存在');
            return;
        }

        $this->assign("MF", $Model);
        $this->assign("iTotal", M("message")->where(array('message_id' => $iMsgId))->count());
        $this->assign("iReadTotal", M("message")->where(array('message_id' => $iMsgId, 'status' => MessageModel::READ_STATUS_YES))->count());
    }

}
