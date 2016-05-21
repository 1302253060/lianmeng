<?php
namespace Cli\Controller;

use Admin\Model\MessageModel;
use Common\Helper\Arr;
use Common\Helper\Mail;
use Think\Controller;
use Admin\Model\UserModel;
class MessageController extends Controller {
    public function send(){
        ini_set('memory_limit', '512M');
        $aList = M("message_list")->where(array('status' => MessageModel::STATUS_SEND_NO))->select();
        $bRet  = false;
        foreach ($aList as $aVal) {
            M("message_list")->where(array(array('status' => MessageModel::STATUS_SEND_NO)))->save(array('status' => MessageModel::STATUS_SEND_ING));
            switch ((int)$aVal['type']) {
                case MessageModel::TYPE_MESSAGE:
                    $bRet = $this->_handleMessage($aVal);
                    break;
                case MessageModel::TYPE_MOBILE:

                    break;
                case MessageModel::TYPE_EMAIL:
                    $bRet = $this->_handleEmail($aVal);
                    break;
                default:
                    break;
            }

            if ($bRet) {
                $insetData = array('status' => MessageModel::STATUS_SEND_SUCC);
            } else {
                $insetData = array('status' => MessageModel::STATUS_SEND_FAIL);
            }
            M("message_list")->where(array(array('status' => MessageModel::STATUS_SEND_ING)))->save($insetData);
        }
    }

    private function _handleMessage($aData) {
        $aUserID = $this->_getUserID($aData['channel_type'], $aData['channel_list']);

        if (empty($aUserID)) {
            return false;
        }
        $aInsert = array();
        foreach ($aUserID as $userid) {
            $aInsert[] = array(
                'message_id'     => $aData['id'],
                'send_user_id'   => MessageModel::SEND_USER_ADMIN,
                'receiv_user_id' => $userid,
                'title'          => $aData['title'],
                'content'        => $aData['content'],
                'status'         => MessageModel::READ_STATUS_NO,
                'create_time'    => date('Y-m-d H:i:s'),
            );
        }

        if (M("message")->addAll($aInsert)) {
            return true;
        } else {
            return false;
        }

    }


    private function _handleEmail($aData) {
        $aUserID = $this->_getUserID($aData['channel_type'], $aData['channel_list']);

        if (empty($aUserID)) {
            return false;
        }
        $aInsert = array();
        foreach ($aUserID as $userid) {
            $aUser = M("user")->field("email")->where(array('id' => $userid))->find();
            Mail::send($aUser['email'], $aData['title'], $aData['content']);
        }

        return true;

    }

    private function _getUserID($iType, $channel_list) {
        $aUserID = array();
        switch ((int)$iType) {
            case MessageModel::CHANNEL_TYPE_ALL:
                $aUserID = $this->_getChannelTypeAll();
                break;
            case MessageModel::CHANNEL_TYPE_ONE:
                $aUserID = $this->_getChannelTypeOne();
                break;
            case MessageModel::CHANNEL_TYPE_TWO:
                $aUserID = $this->_getChannelTypeTwo();
                break;
            case MessageModel::CHANNEL_TYPE_OTHER:
                $aUserID = $this->_getChannelTypeOther($channel_list);
                break;
            default:
                break;
        }
        return $aUserID;
    }

    private function _getChannelTypeAll() {
        $aUser = M("user")->field('id')->where(array('is_login' => 1))->select();
        return array_keys(Arr::changeIndexToKVMap($aUser, 'id', 'id'));
    }

    private function _getChannelTypeOne() {
        $aUser = M("user")->field('id')->where(array('is_login' => 1, 'level' => UserModel::LEVEL_ONE))->select();
        return array_keys(Arr::changeIndexToKVMap($aUser, 'id', 'id'));
    }

    private function _getChannelTypeTwo() {
        $aUser = M("user")->field('id')->where(array('is_login' => 1, 'level' => UserModel::LEVEL_TWO))->select();
        return array_keys(Arr::changeIndexToKVMap($aUser, 'id', 'id'));
    }

    private function _getChannelTypeOther($channel_list) {
        return explode("\r\n", $channel_list);
    }
}
