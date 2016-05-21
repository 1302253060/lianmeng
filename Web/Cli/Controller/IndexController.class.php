<?php
namespace Admin\Controller;

use Think\Controller;
use Common\Helper\PHPExcel;
use Common\Helper\Mail;
use Home\Model\UserModel;
class IndexController extends Controller {
    public function index(){
//        $a = new UserModel();
//        $a = Mail::send(array('969774007@qq.com'), 'aaaaa', '11111');
//        var_dump($a);
//        PHPExcel::arr2Excel(array(array('aaa'=>'111', 'bbbb' => '1111111')),'1.xls','d:/');exit;
//        echo S("name");exit;
//        S("name", '111', 300);
        $this->ajaxReturn(array('1'=>M("activity", '', 'DB_CONFIG1')->select()), 'JSON');
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
}
