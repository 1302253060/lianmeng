<?php
namespace Admin\Controller;

use Think\Controller;
use Common\Helper\Session;
use Common\Helper\Permission;

class BaseController extends Controller {

    protected $sTPL     = './Web/Admin/View/__Layout_User__.php';
    protected $sMainTPL = null;
    protected $Session;
    protected $bNeedAuth = true;
    protected $bCheckLogin = true;
    protected $location  = array();
    protected $iDefaultNumberPerPage = 25;

    public function __construct() {
        parent::__construct();

        if ($this->getCheckLogin()) {
            $Admin = new \Admin\Model\AdminModel();
            if (!$Admin->ifLogin(true)) {
                header("Location: /admin/login/index?ret_url=" . urlencode($_SERVER['REQUEST_URI']));
                exit();
            }
            $this->sMainTPL = T();
            $this->getUserSideMenu();
            $this->AdminUser = Session::instance()->member();
        }

        $this->Session = Session::instance();

        # 权限验证
        if ($this->getNeedAuth()) {
            $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
            if (!Session::instance()->member()->perm()->is_own(Permission::getPermByUri($uri)) ) {
                Session::instance()->member()->bCurrentPerm = false;
                $this->sMainTPL = null;
                $this->__destruct();
                exit();
            } else {
                Session::instance()->member()->bCurrentPerm = true;
            }
        } else {
            Session::instance()->member()->bCurrentPerm = true;
        }
    }

    public function getUserSideMenu() {
        $admin_menu = C('MENU');
        $url        = strtolower($_SERVER['REQUEST_URI']);
        $location   = $this->location;


        $this->header_check_perm($admin_menu);
        $menu = $this->header_get_sub_menu($admin_menu, $url);
        if ( !$menu )
        {
            # 如果还是没有，则获取首页面
            $tmp_default = current($admin_menu);
            $menu = $this->header_get_sub_menu($admin_menu,$tmp_default['href']);
            if (!isset($page_title))$page_title = '管理首页';
        }
        if ( !$menu ) $menu = array();
        $top_menu = current($menu);

        if (!$location || !is_array($location))
        {
            $location = array();
        }

        $this_key_len = count($menu) + count($location);

        if ( $page_title )
        {
            $location[] = $page_title;
            $this_key_len += 1;
        }
        elseif( $location )
        {
            end($location);
            $tmp_menu = current($location);
            $page_title = is_array($tmp_menu)?$tmp_menu['innerHTML']:(string)$tmp_menu;
        }
        else
        {
            $i=0;
            $tmp_menu = $admin_menu;
            foreach ($menu as $key){
                $i++;
                $tmp_menu = $tmp_menu[$key];
                if ($i==$this_key_len)
                {
                    # 获取标题
                    $page_title = strip_tags($tmp_menu['innerHTML'],'');
                }
            }
        }

        $this->assign("admin_menu", $admin_menu);
        $this->assign("top_menu", $top_menu);
        $this->assign("menu", $menu);
        $this->assign("title", $page_title . ' - 联盟');

    }



    /**
     * 设置是否需要进行权限验证
     * @param bool $bNeedAuth
     */
    public function setNeedAuth($bNeedAuth = true) {
        $this->bNeedAuth = $bNeedAuth;
    }

    public function getNeedAuth() {
        return $this->bNeedAuth;
    }


    /**
     * 获取子目录
     *
     * @param array $admin_menu
     * @param string $url
     * @param int $found
     * @return array
     */
    protected function header_get_sub_menu( array $admin_menu , $url , &$found=-1 ) {
        $menu =  $this->header_get_sub_menu_direct($admin_menu, $url, $found, $sDirectUrl);
        if ($sDirectUrl) {
            $direct = false;
            $found = -1;
            return $this->header_get_sub_menu_direct($admin_menu, $sDirectUrl, $found, $direct);
        } else {
            return $menu;
        }
    }

    /**
     * 获取子目录,如果存在direct，返回direct（用户不显示菜单的链接指向设置的菜单）
     *
     * @param array $admin_menu
     * @param string $url
     * @param int $found
     * @param $direct
     * @return array
     */
    protected function header_get_sub_menu_direct( array $admin_menu , $url , &$found=-1, &$direct = '' )
    {
        $menu = array();
        $sub_menu = false;
        foreach ($admin_menu as $k=>$v)
        {

            if ( is_array($v) )
            {
                if ( isset($v['href']) && $v['href']==$url )
                {
                    if (isset($v['direct']) && $v['direct'] && $direct !== false) {
                        $direct = $v['direct'];
                        break;
                    }
                    # 如果当前URL和$v['href']的设置完全相同，则返回
                    $menu = array($k);
                    $found = true;
                    break;
                }
                else
                {
                    $url_len = (isset($v['href']) && $v['href'] !== null) ? strlen($v['href']) : 0;
                    if( (!isset($v['href']) && null===$url) || (isset($v['href']) && substr($url,0,$url_len)==$v['href']) )
                    {
                        # 如果当前URL和$v['href']的前部分相同，则记录下来
                        if ( $url_len>$found )
                        {
                            if (isset($v['direct']) && $v['direct'] && $direct !== false) {
                                $direct = $v['direct'];
                            }
                            $found = $url_len;
                            $sub_menu = array($k);
                        }
                    }

                    $submenu = $this->header_get_sub_menu_direct( $v, $url, $found, $direct );
                    if ( $submenu )
                    {
                        !is_array($submenu) && $submenu = array();
                        if ( true===$found )
                        {
                            $menu = array($k);
                            $menu = array_merge($menu,$submenu);
                            break;
                        }
                        else
                        {
                            $sub_menu = array_merge(array($k),$submenu);
                        }
                    }
                }
            }
        }
        if (!empty($direct)) {
            return $direct;
        }
        if ( $menu )
        {
            return $menu;
        }
        elseif( $sub_menu )
        {
            return $sub_menu;
        }
        else
        {
            return false;
        }
    }



    /**
     * 检查权限，将没有权限的菜单移出
     *
     * @param array $admin_menu
     */
    protected function header_check_perm( &$admin_menu)
    {
        $perm = Session::instance()->member()->perm();
        $havearr = false;
        foreach ( $admin_menu as $k=>&$v )
        {
            if ( is_array($v) )
            {
                if (isset($v['perm']))
                {
                    $perm_key = $v['perm'];
                    unset($v['perm']);
                    if ( false!==strpos($perm_key,'||') )
                    {
                        $perm_key = explode('||', $perm_key);
                        $have_perm = false;
                        foreach ($perm_key as $p)
                        {
                            if ( $perm->is_own($p) )
                            {
                                $have_perm = true;
                                continue;
                            }
                        }
                        if (!$have_perm)
                        {
                            unset($admin_menu[$k]);
                            continue;
                        }
                    }
                    elseif ( false!==strpos($perm_key,'&&') )
                    {
                        $perm_key = explode('&&', $perm_key);
                        foreach ($perm_key as $p)
                        {
                            if ( !$perm->is_own($p) )
                            {
                                unset($admin_menu[$k]);
                                continue 2;
                            }
                        }
                    }
                    else
                    {
                        # 检查权限
                        if ( !$perm->is_own($perm_key) )
                        {
                            unset($admin_menu[$k]);
                            continue;
                        }
                    }
                }
                if ( false===$this->header_check_perm( $v ) )
                {
                    unset($admin_menu[$k]);
                }
                else
                {
                    $havearr = true;
                }
            }
            elseif ( $k=='href' )
            {
                if ( $v !='#' && !preg_match('#^[a-z0-9]+://.*$#', $v) )
                {
                    $v = $v;
                }
            }

        }
        if ( false==$havearr && (!isset($admin_menu['href']) || $admin_menu['href']=='#' ) )
        {
            return false;
        }
    }


    public function __destruct() {
        if ($this->sTPL !== null) {
            $this->assign("sMainTPL", $this->sMainTPL);
            $this->display($this->sTPL);
        }

    }

    /**
     * 成功
     * @param string $sMsg
     * @param null $sUrl
     * @param array $aData
     */
    protected function succ($sMsg = '', $sUrl = null, $aData = array())
    {
        $this->_result(1, $aData, $sMsg, $sUrl);
    }

    /**
     * 失败
     * @param string $sMsg
     * @param null $sUrl
     * @param int $iCode
     */
    protected function fail($sMsg = '失败', $sUrl = null, $iCode = -1)
    {
        $this->_result($iCode, array(), $sMsg, $sUrl);
    }

    /**
     * 成功,但有警告
     * @param string $sMsg
     * @param null $sUrl
     * @param array $aData
     */
    protected function warn($sMsg = '', $sUrl = null, $aData = array())
    {
        $this->_result(2, $aData, $sMsg, $sUrl);
    }


    protected function _result($iCode, $aData, $sMsg, $sUrl)
    {
        if (IS_AJAX) {
            $this->sTPL = null;
            echo json_encode(array(
                'code'  => $iCode,
                'msg'   => $sMsg,
                'data'  => $aData,
            ));

        } else {
            if ($sUrl == null) {
                $sUrl = $_SERVER['HTTP_REFERER'];
            } else {
                $sUrl = $sUrl;
            }
            header("Content-Type', 'text/html; charset=utf-8");
            echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script>alert('{$sMsg}');window.location.href='{$sUrl}';</script>";
            exit();
//            redirect($sUrl);
        }

    }

    /**
     * 设置是否需要验证登录
     * @param bool $bCheckLogin
     */
    public function setCheckLogin($bCheckLogin = true) {
        $this->bCheckLogin = $bCheckLogin;
    }

    public function getCheckLogin() {
        return $this->bCheckLogin;
    }

}
