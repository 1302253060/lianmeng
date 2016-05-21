<?php
namespace Admin\Controller;

use Think\Controller;
use Common\Helper\Permission;
use Common\Helper\Session;
use Admin\Model\SoftModel;
use Common\Helper\Constant;
class FileController extends BaseController {

    protected $bNeedAuth = false;

    private $aMapErrMsg = array(
        65535 => '上传失败',
        0     => '',
    );

    public function upload_image() {
        $this->sTPL = null;

        $sPostName = I('post.postname');
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   = 3145728 ;// 设置附件上传大小3M
        $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  = Constant::UPLOAD_DIR; // 设置附件上传根目录
        $upload->savePath  = 'image/'; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();

        $aData  = array();
        if ($info && isset($info[$sPostName])) {
            $aD          = $info[$sPostName];
            $aD['error'] = 0;
        } else {
            $aD = array('error' => 65535);
        }
        $aData['fileinfo']           = $aD;
        $aData['fileinfo']['errmsg'] = isset($this->aMapErrMsg[$aD['error']]) ?
                                            $this->aMapErrMsg[$aD['error']] :
                                            'unknown';

        if ($aD['error'] == 0) {
            $sDir                               = Constant::UPLOAD_DIR;
            $sFile                              = $aD['savepath'] . $aD['savename'];
            $aData['fileinfo']['org_file_name'] = $sFile;
            $aData['fileinfo']['url']           = Constant::IMAGE_URL . trim(trim($sDir, '.'), '/') . '/' . $sFile;
        }

        echo json_encode($aData);


    }


    public function upload_file() {
        $this->sTPL = null;

        $sPostName = I('post.postname');
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =  104857600;// 设置附件上传大小100M
        $upload->exts      = array('exe', 'apk');// 设置附件上传类型
        $upload->rootPath  = Constant::UPLOAD_DIR; // 设置附件上传根目录
        $upload->savePath  = $sPostName == 'uploadUrlZuJian' ? 'package/zujian/' : 'package/'; // 设置附件上传（子）目录
        $upload->saveName  = null;
        // 上传文件
        $info   =   $upload->upload();

        $aData  = array();
        if ($info && isset($info[$sPostName])) {
            $aD          = $info[$sPostName];
            $aD['error'] = 0;
        } else {
            $aD = array('error' => 65535);
        }
        $aData['fileinfo']           = $aD;
        $aData['fileinfo']['errmsg'] = isset($this->aMapErrMsg[$aD['error']]) ?
                                        $this->aMapErrMsg[$aD['error']] :
                                        'unknown';

        if ($aD['error'] == 0) {
            $sDir                               = Constant::UPLOAD_DIR;
            $sFile                              = $aD['savepath'] . $aD['savename'];
            $aData['fileinfo']['org_file_name'] = $sFile;
            $aData['fileinfo']['md5']           = md5_file(trim($sDir, '/') . '/' . $sFile);
            $aData['fileinfo']['url']           = Constant::IMAGE_URL . trim(trim($sDir, '.'), '/') . '/' . $sFile;
        }
        echo json_encode($aData);

    }


}
