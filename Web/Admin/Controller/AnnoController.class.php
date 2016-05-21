<?php
namespace Admin\Controller;

use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
class AnnoController extends BaseController {


    public function index() {
        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $User = M('anno'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $User->where(array())->order('create_time desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $User->where(array())->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
    }

    public function add() {
        $this->sMainTPL = './Web/Admin/View/Anno/edit.php';
        $this->assign("bEdit", false);
    }

    public function edit() {
        $iID = I('get.id');
        if ($iID === null) {
            $this->fail('参数ID错误');
            goto END;
        }
        $Anno = M("anno");
        $Anno->getById($iID);
        $this->assign("Item", $Anno);
        $this->assign("bEdit", true);

        END:
    }

    public function add_post()
    {

        $this->sTPL = null;
        $Anno = M("anno");
        $Anno->create();
        $Anno->content = html_entity_decode($Anno->content);
        if (!empty($Anno->id)) {
            $this->fail('参数错误');
            goto END;
        }

        $Anno->create_time = date('Y-m-d H:i:s');
        $Anno->update_time = date('Y-m-d H:i:s');
        if (!$Anno->add()) {
            $this->fail('更新失败');
            goto END;
        }
        $this->succ('更新成功');

        END:
    }

    public function edit_post()
    {

        $this->sTPL = null;
        $Anno = M("anno");
        $Anno->create();

        $Anno->content = html_entity_decode($Anno->content);
        if (empty($Anno->id)) {
            $this->fail('参数ID错误');
            goto END;
        }

        $Anno->update_time = date('Y-m-d H:i:s');
        if (!$Anno->save()) {
            $this->fail('更新失败');
            goto END;
        }
        $this->succ('更新成功');

        END:
    }

    public function delete() {
        $iID = I('post.id');
        if (empty($iID)) {
            $this->fail('参数ID错误');
            goto END;
        }

        M("anno")->delete($iID) ?
            $this->succ('删除成功') :
            $this->fail('删除失败');
        END:
    }
}
