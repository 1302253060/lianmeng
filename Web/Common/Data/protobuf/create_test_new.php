<?php
require_once('./parser/pb_parser.php');
$parser = new PBParser();
//$parser->parse('./test_new.proto');
$parser->parse('./lianmeng.proto');
echo 'ok';

?>