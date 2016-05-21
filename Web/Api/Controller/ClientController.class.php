<?php
namespace Api\Controller;


class ClientController extends BaseController {


    public function index() {
        require "./Web/Common/Data/protobuf/message/pb_message.php";
        require "./Web/Common/Data/protobuf/pb_proto_lianmeng.php";


        $sPBString = @file_get_contents('php://input');
        $Info = new \Info();
        $Info->parseFromString($sPBString);

        $channel_id   = $Info->channel_id();
        $soft_name    = $Info->soft_name();
        $unique_code  = $Info->unique_code();
        $os_major_ver = $Info->os_major_ver();
        $os_minor_ver = $Info->os_minor_ver();
        $os_bit       = $Info->os_bit();
        $mac          = $Info->mac();
        $cpu_size     = $Info->cpu_size();
        $aCpu         = array();
        for($i = 0; $i < $cpu_size; $i++) {
            $aCpu[$i] = $Info->cpu($i);
        }

        $hard_disk_size = $Info->hard_disk_size();
        $aHardDisk      = array();
        for($i = 0; $i < $hard_disk_size; $i++) {
            $aHardDisk[$i] = $Info->hard_disk($i);
        }

        $mainboard      = $Info->mainboard();
        $version        = $Info->version();
        $virtual_machine= $Info->virtual_machine();

        $aOtherText     = array();
        $other_text_size= $Info->other_text_size();
        for($i = 0; $i < $other_text_size; $i++) {
            $aOtherText[$Info->other_text($i)->key()] = (string)$Info->other_text($i)->value();
        }

        $secret_key = $Info->secret_key();
        $time       = $Info->time();
        if (time() - $time > 60) {
            echo "time out";
            exit();
        }

        $secret = md5($channel_id . $soft_name . $unique_code . $mac . $version . $time . $this->sKey);

        if ($secret_key != $secret) {
            echo "secret error";
            exit();
        }
        $ip = get_client_ip();
        $sFile = "D:/project/fanliang/fanliang_" . date('YmdH') . '.txt';
        $sDate =   $channel_id . "\t"
                 . $soft_name . "\t"
                 . $unique_code . "\t"
                 . $os_major_ver . "\t"
                 . $os_minor_ver . "\t"
                 . $os_bit . "\t"
                 . $mac . "\t"
                 . json_encode($aCpu) . "\t"
                 . json_encode($aHardDisk) . "\t"
                 . $mainboard . "\t"
                 . $version . "\t"
                 . $virtual_machine . "\t"
                 . json_encode($aOtherText) . "\t"
                 . $ip . "\t"
                 . json_encode($_SERVER) . "\n";
        file_put_contents($sFile, $sDate, FILE_APPEND);

    }
}
