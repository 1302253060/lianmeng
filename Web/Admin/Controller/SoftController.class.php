<?php
namespace Admin\Controller;

use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
class SoftController extends BaseController {

    private $aStatus = array(
        -1                          => '全部',
        SoftModel::STATUS_ONLINE    => '线上',
        SoftModel::STATUS_OFFLINE   => '下线',
    );
    private $aType = array(
        SoftModel::TYPE_PC    => 'PC端',
        SoftModel::TYPE_APP   => 'APP端',
    );

    public function index() {

        $status = I("get.status", -1);
        $kw     = I("get.kw");
        $sort   = I("get.sort");

        $iST = (!empty($status) || $status == 0) ? (int)$status : -1;
        $sKW = !empty($kw) ? trim($kw) : '';
        $sSort = !empty($sort) ? trim($sort) : '';

        $aWhere = array();
        if (!empty($sKW)) {
            $aWhere['name'] = array('like', "%{$sKW}%");
            $aWhere['id']   = array('like', "%{$sKW}%");
            $aWhere['_logic'] = 'or';
            $map = $aWhere;
        }
        if ($iST != -1) {
            if (!empty($aWhere)) {
                $map['_complex'] = $aWhere;
            }
            $map['status']   = $iST;
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }

        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $User = M('soft'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $User->where($map)->order('show_order asc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $User->where($map)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
        $this->assign("aStatus", $this->aStatus);
        $this->assign("status", $iST);
        $this->assign("kw", $sKW);
        $this->assign("sort", $sSort);
    }

    public function update_order() {
        $iID = (int)I('post.pk');
        if ($iID === 0) {
            $this->fail('参数ID错误');
            goto END;
        }
        $iOrder = (int)I('post.value');
        if ($iOrder === 0) {
            $this->fail('参数order错误');
            goto END;
        }

        $Soft  = M("soft");
        $aSoft = $Soft->where(array('id' => $iID))->find();
        if (empty($aSoft)) {
            $this->fail('参数ID错误');
            goto END;
        }

        if ($aSoft['show_order'] == $iOrder) {
            $this->succ('无需更新');
            goto END;
        }
        $Soft->show_order = $iOrder;

        $Soft->where(array('id' => $iID))->save() ?
            $this->succ('更新成功') :
            $this->fail('更新失败');

        END:
    }

    public function Add()
    {

        $aStatus = $this->aStatus;
        unset($aStatus[-1]);

        $this->assign("aStatus", $aStatus);
        $this->assign("aType", $this->aType);
        $this->assign("bEdit", false);
        $this->sMainTPL = './Web/Admin/View/Soft/edit.php';
    }

    public function edit() {
        $aStatus = $this->aStatus;
        unset($aStatus[-1]);
        $iID = (int)I('get.id');
        if ($iID === 0) {
            $this->fail('参数ID错误');
            goto END;
        }
        $Soft = M("soft");
        $Soft->getById($iID);
        $this->assign("Item", $Soft);
        $this->assign("aStatus", $aStatus);
        $this->assign("aType", $this->aType);
        $this->assign("bEdit", true);

        END:

    }

    public function add_post() {
        $this->sTPL = null;
        $Soft = M("soft");
        $Soft->create();

        $Soft->content = html_entity_decode($Soft->content);
        $Soft->config = json_encode($this->getConfigTidy($Soft->config));
        $Soft->update_time = date('Y-m-d H:i:s');

        if (!empty($Soft->id)) {
            $this->fail('参数错误');
            goto END;
        }

        if (!$Soft->add()) {
            $this->fail('更新失败');
            goto END;
        }
        $this->succ('更新成功');

        END:
    }


    public function edit_post() {
        $this->sTPL = null;
        $Soft = M("soft");
        $Soft->create();

        $Soft->content = html_entity_decode($Soft->content);
        $Soft->config = json_encode($this->getConfigTidy($Soft->config));
        $Soft->update_time = date('Y-m-d H:i:s');

        if (empty($Soft->id)) {
            $this->fail('参数ID错误');
            goto END;
        }

        if (!$Soft->save()) {
            $this->fail('更新失败');
            goto END;
        }
        $this->succ('更新成功');

        END:
    }

    /**
     * 整理前端页面提交的config配置
     * @param array $aConfigOrg
     * @return array
     */
    private function getConfigTidy($aConfigOrg = array()) {
        $aConfigTidy = array();
        if ($aConfigOrg) foreach ($aConfigOrg as $aValue) {
            if (!$aValue[0] || !$aValue[1]) {
                continue;
            }
            $aConfigTidy[$aValue[0]] = $aValue[1];
        }
        return $aConfigTidy;
    }

}
