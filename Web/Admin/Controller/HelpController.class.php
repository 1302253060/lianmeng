<?php
namespace Admin\Controller;

use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
use Admin\Model\HelpModel;
class HelpController extends BaseController {


    public function index() {
        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $Question = M('t_help_question'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $Question->where(array())->order('sort asc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $Question->where(array())->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
    }


    public function add() {
        $this->sMainTPL = './Web/Admin/View/Help/edit.php';
        $this->assign("bEdit", false);
        $this->assign("aType", HelpModel::$aType);
    }

    public function add_post() {
        $this->sTPL = null;
        $Question = M("t_help_question");
        $Question->create();
        $Question->content = html_entity_decode($Question->content);
        if (!empty($Question->id)) {
            $this->fail('参数错误');
            goto END;
        }

        $Question->create_time = date('Y-m-d H:i:s');
        $Question->update_time = date('Y-m-d H:i:s');
        if (!$Question->add()) {
            $this->fail('更新失败');
            goto END;
        }
        $this->succ('更新成功');

        END:
    }

    public function edit() {

        $iID = I('get.id');
        if ($iID === null) {
            $this->fail('参数ID错误');
            goto END;
        }
        $Question = M("t_help_question");
        $Question->getById($iID);
        $this->assign("Item", $Question);
        $this->assign("bEdit", true);
        $this->assign("aType", HelpModel::$aType);

        END:

    }

    public function edit_post()
    {
        $this->sTPL = null;
        $Question = M("t_help_question");
        $Question->create();
        $Question->content = html_entity_decode($Question->content);
        if (empty($Question->id)) {
            $this->fail('参数ID错误');
            goto END;
        }

        $Question->update_time = date('Y-m-d H:i:s');
        if (!$Question->save()) {
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

        M("t_help_question")->delete($iID) ?
            $this->succ('删除成功') :
            $this->fail('删除失败');
        END:
    }
}
