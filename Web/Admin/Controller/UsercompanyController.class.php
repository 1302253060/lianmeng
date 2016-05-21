<?php
namespace Admin\Controller;

use Admin\Model\UserModel;
use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
class UsercompanyController extends BaseController {

    private $aCompanyStatus = array(
        -1                        => '全部',
        UserModel::COMPANY_NO     => '未提交认证',
        UserModel::COMPANY_REVIEW => '审核中',
        UserModel::COMPANY_FAIL   => '审核失败',
        UserModel::COMPANY_PASS   => '审核通过',
    );

    public function index() {

        $aQueryType = array(
            'id'     => 'ID',
            'name'   => '姓名',
            'qq'     => 'QQ',
            'mobile' => '手机',
        );

        $aWhere = array();
        if (I('get.value')) {
            if (!isset($aQueryType[I('get.type')])) {
                return $this->fail('类型选择有误');
            }
            $aWhere[I('get.type')] = I('get.value');
        }
        $aWhere['level'] = UserModel::LEVEL_ONE;

        $company_status = I('get.company_status', -1);
        if ($company_status != -1) {
            $aWhere['company_status'] = $company_status;
        }
        $company_name = I('get.company_name');
        if (!empty($company_name)) {
            $aWhere['company_name'] = array('like', "%{$company_name}%");
        }

        $p = I('get.p');
        if (empty($p)) {
            $p = 1;
        }
        $iDefaultNumberPerPage = $this->iDefaultNumberPerPage;
        $User = M('user'); // 实例化User对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $aList = $User->where($aWhere)->order('create_time desc')->page($p.',' . $iDefaultNumberPerPage)->select();
        $count = $User->where($aWhere)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count, $iDefaultNumberPerPage);// 实例化分页类 传入总记录数和每页显示的记录数
        $show  = $Page->show();// 分页显示输出
        $this->assign('sPagination',$show);// 赋值分页输出
        $this->assign('aList', $aList);// 赋值数据集
        $this->assign("aQueryType", $aQueryType);
        $this->assign("aCompanyStatus", $this->aCompanyStatus);
    }

    public function edit() {
        $iID   = (int)I('get.id');
        $User  = M("user");
        $User->getById($iID);
        $this->assign("bEdit", true);
        $this->assign("Item",  $User);
    }


    public function edit_post() {
        $this->sTPL = null;

        $iID = I('post.id');
        if (empty($iID)) {
            $this->fail('参数ID错误');
            goto END;
        }
        $User = M("user");
        $data = $User->create();

        $aOldData = $User->find($iID);

        if (empty($aOldData)) {
            $this->fail(sprintf('[条目:%d 不存在]', $iID));
            goto END;
        }


        $User->update_time = date('Y-m-d H:i:s');
        if (!$User->save($data)) {
            $this->fail('更新失败');
            goto END;
        }
        $this->succ('更新成功');

        END:
    }
}
