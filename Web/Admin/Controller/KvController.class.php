<?php
namespace Admin\Controller;

use Admin\Model\KvModel;
use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
class KvController extends BaseController {


    public function index() {
        $aData = M("kv")->order("id desc")->select();
        foreach ($aData as $iKey => $aValue) {
            $aData[$iKey]['value'] = KvModel::parseValue($aValue['value'], $aValue['type']);
        }
        $this->assign("aData", $aData);
    }


    public function add() {

        $sKey = I('get.key');
        $Model = M("kv");
        if ($sKey) {
            $Model->getByKey($sKey);
            $bEdit = true;
        } else {
            $Model->create();
            $bEdit = false;
        }
        $Model->value = KvModel::parseValue($Model->value, $Model->type);

        $this->assign("aType", KvModel::$aTypeMap);
        $this->assign("bEdit", $bEdit);
        $this->assign("Item", $Model);
    }


    public function add_post() {
        $sEditKey = I('post.edit');

        $Model = M("kv");
        if ($sEditKey) {
            $Model->getByKey($sEditKey);
            if (empty($Model->key)) {
                $this->fail('获取key失败');
            }
        } else {
            $Model->create();
            $Model->key  = I('post.key');
            $Model->type = I('post.type');
        }
        $Model->key_name = I('post.key_name');
        $Model->online   = (int)I('post.online');
        if ($sReason = I('post.reason')) {
            $Model->note_info = serialize(array('reason' => $sReason));
        }

        if (!$Model->key_name) {
            $this->fail('请填写配置名');
        } else if (!$Model->key) {
            $this->fail('请填写配置key');
        } else if (!isset(KvModel::$aTypeMap[$Model->type])) {
            $this->fail('配置类型选择有误');
        }

        if ($Model->type == KvModel::TYPE_NORMAL) {
            $mValue = trim(I('post.value_0'));
        } else {
            $mValue = $this->getConfigTidy(I('post.config'));
        }
        $Model->value = KvModel::createValue($mValue, $Model->type);

        if ($sEditKey) {
            $mReturn = $Model->save();
        } else {
            $mReturn = $Model->add();
        }

        if ($mReturn) {
            $this->succ('更新成功');
        } else {
            $this->fail('更新失败');
        }
    }



    /**
     * 整理前端页面提交的config配置
     * @param array $aConfigOrg
     * @return array
     */
    private function getConfigTidy($aConfigOrg = array()) {
        $aConfigTidy = array();
        if ($aConfigOrg) foreach ($aConfigOrg as $aValue) {
            $aValue[0] = trim($aValue[0]);
            $aValue[1] = trim($aValue[1]);
            if ($aValue[0] === '' || !$aValue[1]) {
                continue;
            }
            $aConfigTidy[$aValue[0]] = $aValue[1];
        }
        return $aConfigTidy;
    }

}
