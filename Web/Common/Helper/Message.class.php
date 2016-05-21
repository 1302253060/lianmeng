<?php
namespace Common\Helper;

class Message
{
    const PRODUCT = '第二官方';
    static $aMessageTpl = array(
        'register_tpl' => array(
            'sSignName' => '身份验证',
            'sCode'     => 'SMS_6691166',
        ),
    );

    public static function send($userid = 0, $sSignName, $sSmsParam = '', $aMobie, $sCode)
    {
        require "./vendor/message/TopSdk.php";

        if (empty($aMobie) || count($aMobie) > 199) { // 最多200个号码
            return false;
        }

        $sMobile = implode(',', $aMobie);
        $c = new \TopClient();

        $c->appkey    = '23334125';
        $c->secretKey = '3ce28e883b38c6eb3ff0a634ebd9c1bc';
        $c->format    = 'json';
        $req = new \AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend($userid);
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($sSignName);
        $req->setSmsParam($sSmsParam);
        $req->setRecNum($sMobile);
        $req->setSmsTemplateCode($sCode);
        $resp = $c->execute($req);

        if (isset($resp->code))
            {
            return false;
        } else {
            return true;
        }
    }
}
