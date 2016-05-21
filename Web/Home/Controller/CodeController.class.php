<?php
namespace Home\Controller;


class CodeController extends BaseController {

    protected $bGetUser = false;

    public function index(){
        $Verify =     new \Think\Verify();
        $Verify->fontSize = 16;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->codeSet = '0123456789';
        $Verify->entry();
    }
}
