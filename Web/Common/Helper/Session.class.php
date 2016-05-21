<?php
namespace Common\Helper;

use Admin\Model;
/**
 * Admin Session类
 */
class Session
{
    /**
     * @var Session
     */
    protected static $instance;

    public static $config;

    protected static $flash;

    /**
     * Session驱动
     *
     * @var Session_Driver_Default
     */
    protected $driver;

    /**
     * @var \Admin\Model\AdminModel
     */
    protected static $member;

    /**
     * @return Session
     */
    public static function instance()
    {
        // Create a new instance
        if ( Session::$instance == null ) {
            Session::$instance = new Session();
        }
        return Session::$instance;
    }

    public function __construct($vars = null)
    {
        // This part only needs to be run once
        if ( Session::$instance === null ) {
            $this->start();
        }
    }

    /**
     * 设置用户
     * @param $member
     * @return Session
     */
    public function setMember($member)
    {
        self::$member = $member;
        return $this;
    }

    /**
     * 获取用户对象
     *
     * @return \Admin\Model\AdminModel
     */
    public function member()
    {
        if (!self::$member) {
//            $this->get('admin_member_id')
            $Admin = new \Admin\Model\AdminModel();
            $this->setMember($Admin->find($this->get('admin_member_id')));
        }
        return self::$member;
    }


    public function start() {
        session_name('AdminLianMengUUID');
        return session_start();
    }

    public function set($sKey, $sValue) {
        $_SESSION[$sKey] = $sValue;
    }

    public function get($sKey) {
        return isset($_SESSION[$sKey]) ? $_SESSION[$sKey] : null;
    }

    public function write() {
        session_write_close();
    }

    public function destory() {
        return session_destroy();
    }
}