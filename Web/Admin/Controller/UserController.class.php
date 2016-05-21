<?php
namespace Admin\Controller;

use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
class UserController extends BaseController {


    public function index() {
        $this->assign("list", M("admin")->select());
    }

    public function edit() {

        $iId = I('get.id');
        $Admin = new \Admin\Model\AdminModel();
        $this->assign("member", $Admin->find($iId));
    }


    public function edit_perm_form() {

        $member_id = I('get.id');
        $member = D("admin")->find($member_id);

        $perm_setting = array();
        $perm = new Permission($perm_setting);
        $this->sTPL = null;
        include("./Web/Admin/View/User/permForm.php");
    }

    public function edit_post() {
        try {
            /**@var \Admin\Model\AdminModel */
            $Admin = new \Admin\Model\AdminModel();
            $member = $Admin->find(I('get.id'));
            $member->perm_setting = unserialize($member->perm_setting);

            if (!$member->id>0)
            {
                # 创建新用户
                if ( !$_POST['username'] )
                {
                    throw new \Exception('用户名不能空', 0);
                }
                if ( !$_POST['password'] )
                {
                    throw new \Exception('密码不能空', 0);
                }

                if ( M("admin")->where(array('username' => $_POST['username']))->count() )
                {
                    throw new \Exception('此用户名已存在，请换一个', 0);
                }
            }

            $member->nickname = $_POST['nickname'];
            $member->shielded = $_POST['shielded'];
            if ( $_POST['password'] ) {
                $member->password = md5($_POST['password']);
            }
            if ( $member->id>0 && $member->id==Session::instance()->member()->id )
            {
                # 自己
                $this->show_edit_perm = false;
            }
            else if ( Session::instance()->member()->perm()->is_super_perm() )
            {
                # 超管
                $this->show_edit_perm = true;
            }
            else
            {
                if ( $member->id>0 )
                {
                    if ( $this->check_is_over_perm( $member ) )
                    {
                        $over_perm = true;
                    }
                    else
                    {
                        $over_perm = false;
                    }
                }
                else
                {
                    $over_perm = true;
                }

                if ( $over_perm )
                {
                    if ( $member->id>0 && $member->id!=Session::instance()->member()->id )
                    {

                        $this->show_edit_perm = true;
                    }
                    else
                    {
                        $this->show_edit_perm = true;
                    }
                }
                else
                {
                    $this->show_edit_perm = false;
                }
            }

            # 修改权限模式
            if ( $this->show_edit_perm )
            {
                # 修改权限
                $this->change_member_perm($member);
            }
            elseif ( !$member->id>0 )
            {
                $member->perm_setting = null;
            }


            $member->perm_setting = serialize($member->perm_setting ? : array());

            try
            {
                # 保存数据
                if ( $member->id>0 )
                {
                    # 修改用户
                    $member->where("id={$member->id}")->save();
                }
                else
                {

                    # 设置用户名
                    $member->username = $_POST['username'];

                    # 密码
                    $member->password = md5($_POST['password']);

                    # 锁定=否
                    $member->shielded = 0;

                    # 插入用户数据
                    $member->add();
                }

                $msg = '操作成功';
                $code = 1;
            }

            catch (\Exception $e)
            {
                throw $e;
            }
        }
        catch (\Exception $e)
        {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }


        $code ? $this->succ('操作成功') : $this->fail($msg, null, $code);
    }



    /**
     * 修改权限
     *
     * @param \Admin\Model\AdminModel $member
     * @throws \Exception
     */
    protected function change_member_perm( &$member)
    {
        if ( $member->id>0 && $member->id == Session::instance()->member() ) {
            throw new \Exception('系统不允许管理员操作自己的权限', -1);
        }


        # 不是自定义的权限，全部清理掉
        if ( $_POST['zdy_perm']!=1 )
        {
            unset($_POST['perm_setting']);
        }

        if ( Session::instance()->member()->perm()->is_super_perm() )
        {
            # 超管
            if ( $member->is_super_admin != $_POST['is_super_admin'] )
            {
                $member->is_super_admin = $_POST['is_super_admin']?1:0;
                if ( $member->is_super_admin )
                {
                    # 标记为设置为超级管理员
                    $this->change_to_super_admin = true;
                }
            }

            $perm_setting = $_POST['perm_setting'];

        }
        else
        {
            # 非超管处理

            if ( $member->is_super_admin )
            {
                throw new \Exception('您不具备操作此管理员的权限', -1);
            }

            if ( $_POST['is_super_admin'] )
            {
                throw new \Exception('您不具备提升管理员为超管的权限', -1);
            }


            if ( !$this->check_auth_for_perm($member) )
            {
                throw new \Exception('您不具备当前相应权限', -1);
            }

            if ( $_POST['perm_setting'] && is_array($_POST['perm_setting']) )
            {
                # 检查提交的额外权限
                $perm_setting = self::check_perm_data($_POST['perm_setting']);
            }

        }

        # 设置数据
        if ($_POST['save_direct'] != 1) {
            $member->perm_setting = $perm_setting;
        }
    }


    /**
     * 检查用户是否有操作用户权限的权限
     *
     * @param ORM_Admin_Member_Data $gourp
     * @return boolean
     */
    protected function check_auth_for_perm( $member)
    {
        $member_perm = Session::instance()->member()->perm();
        if ( $member_perm->is_super_perm() )
        {
            # 超管
            return true;
        }

        if ( $member->id > 0 )
        {
            # 修改组
            if ( $member_perm->is_own('administrator.change_user_perm') )
            {
                return true;
            }
        }
        else
        {
            #添加
            if ( $member_perm->is_own('administrator.add_new_user') )
            {
                return true;
            }
        }

        return false;
    }





    /**
     * 整理并检查权限数据
     *
     * @param array $perm
     * @throws \Exception
     * @return array
     */
    public static function check_perm_data( array $perm )
    {
        $my_perm = Session::instance()->member()->perm();
        $perm_config =  CFG('perm');

        if ( Session::instance()->member()->perm()->is_super_perm() )
        {
            $is_super = true;
        }
        else
        {
            $is_super = false;
        }

        # 提交的权限中有超管权限
        if ( isset($perm['_super_admin']) ) {
            unset($perm['_super_admin']);
        }

        foreach ( $perm as $key => $item )
        {
            if ( is_array($item) )
            {
                foreach ( $item as $k => $v )
                {
                    if ( isset($perm_config[$key][$k]) )
                    {
                        # 忽略掉没有的项目
                        unset($perm[$key][$k]);
                        continue;
                    }
                    else
                    {
                        $perm[$key][$k] = 1;
                    }

                    # 判断当前用户是否有此权限，超管就不用检查了
                    if ( !$is_super && !$my_perm->is_own($key.'.'.$k) )
                    {
                        # 权限名称
                        $pname = $perm_config[$key][$k];
                        if ( is_array($pname) )
                        {
                            $pname = (string)$pname['innerHTML'];
                        }
                        throw new \Exception('您不具备此权限:“'.$pname.'”，操作已取消', -1);
                    }
                }
            }
        }

        return $perm;
    }

    public function add() {
        $this->sMainTPL = "./Web/Admin/View/User/edit.php";
    }
}
