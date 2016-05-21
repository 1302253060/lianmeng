<?php
namespace Common\Helper;

class Mail
{
    public static function send($aRecv, $sTitle, $sContent, $sFrom = '13137798393@163.com', $sFromDesc = '第二官方', $aAttrPath = null, $aRecvCC = array())
    {
        $Mail          = new \PHPMailer();
        $Mail->CharSet = "utf-8";
        $Mail->SetFrom($sFrom, "=?UTF-8?B?" . base64_encode($sFromDesc) . "?=");
        $Mail->Username = '13137798393@163.com';
        $Mail->Password = 'HJX388186';
        $Mail->Host = 'smtp.163.com';
        $Mail->SMTPAuth = true;
        $Mail->isSMTP();
        $Mail->SMTPSecure = "ssl";
        $Mail-> Port = '465';
        $sTxtContent = strip_tags($sContent);
        $Mail->MsgHTML($sContent);
        $Mail->AltBody = $sTxtContent;
        $Mail->Subject = $sTitle;
        if (!is_array($aRecv)) {
            $aRecv = array($aRecv);
        }
        foreach ($aRecv as $sName => $sMail) {
            $Mail->AddAddress($sMail, is_int($sName) ? '' : ("=?UTF-8?B?" . base64_encode($sName) . "?="));
        }

        if (!is_array($aRecvCC)) {
            $aRecvCC = array($aRecvCC);
        }
        foreach ($aRecvCC as $sName => $sMail) {
            $Mail->AddCC($sMail, is_int($sName) ? '' : ("=?UTF-8?B?" . base64_encode($sName) . "?="));
        }

        $aAttrPath = (array)$aAttrPath;
        foreach ($aAttrPath as $sValue) {
            if (!empty($sValue)) {
                $Mail->addAttachment($sValue);
            }
        }


//        $mail->isSMTP(); // Set mailer to use SMTP
//        $mail->Host = 'smtp.163.com'; // Specify main and backup SMTP servers
//        $mail->SMTPAuth = true; // Enable SMTP authentication
//        $mail->Username = '13137798393@163.com'; // SMTP username
//        $mail->Password = 'HJX388186'; // SMTP password
//        $mail->SMTPSecure = 'ssl'; // Enable encryption, 'ssl' also accepted
//        $mail->Port = '465'; // Enable encryption, 'ssl' also accepted
//        $mail->From = '13137798393@163.com';
//        $mail->FromName = 'Mailer';
//        $mail->addAddress('969774007@qq.com', 'Joe User'); // Add a recipient
//        $mail->addReplyTo('969774007@qq.com', 'Information');
////        $mail->addCC('cc@example.com');
////        $mail->addBCC('bcc@example.com');
//        $mail->WordWrap = 50; // Set word wrap to 50 characters
////        $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
////        $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
//        $mail->isHTML(true); // Set email format to HTML
//        $mail->Subject = 'Here is the subject';
//        $mail->Body = 'This is the HTML message body <b>in bold!</b>';
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//        if(!$mail->send()) {
//            echo 'Message could not be sent.';
//            echo 'Mailer Error: ' . $mail->ErrorInfo;
//        } else {
//            echo 'Message has been sent';
//        }
        return $Mail->Send();
    }

    /**
     * 转化array数据成table html
     * @param $aData
     * @return string
     */
    public static function arr2Table($aData) {
        if (!$aData) {
            return false;
        }
        $aData = (array)$aData;

        $sStyle = <<<EOF
            <style>
                    *{font-family:微软雅黑;}
                    table tr th{background-color:#c6d9f1;font-family:微软雅黑;font-size: 16px;}
                    td{ text-align: center;font-family:微软雅黑;font-size: 14px; padding: 10px;}
                    .span1{font-family:微软雅黑;}
                </style>
EOF;

        $aHead = (array)array_keys(current($aData));
        $sTable = <<<EOF
                <table border="1" cellpadding="0" cellspacing="0">
                    <tr>
EOF;
        foreach ($aHead as $sHead) {
            $sTable .= <<<EOF
            <th>{$sHead}</th>
            
EOF;
        }
        $sTable .= '</tr>';
        foreach ($aData as $aValue) {
            $sTable .= '<tr>';
            $aValue = (array)$aValue;
            foreach ($aValue as $sValue2) {
                $sTable .= <<<EOF
                <td>{$sValue2}</td>

EOF;

            }
            $sTable .= '</tr>';
        }
        $sTable .= '</table>';

        return $sStyle . $sTable;
    }
}
