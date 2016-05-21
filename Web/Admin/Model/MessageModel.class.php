<?php
namespace Admin\Model;

use Common\Helper\Arr;
use Common\Helper\Permission;
use Common\Helper\Session;
use Common\Helper\Constant;
use Think\Model;

class MessageModel extends Model {

    const CHANNEL_TYPE_ALL   = 0;
    const CHANNEL_TYPE_ONE   = 1;
    const CHANNEL_TYPE_TWO   = 2;
    const CHANNEL_TYPE_OTHER = 3;


    const STATUS_SEND_NO   = 0;
    const STATUS_SEND_SUCC = 1;
    const STATUS_SEND_FAIL = 2;
    const STATUS_SEND_ING  = 3;

    const TYPE_MESSAGE = 1;
    const TYPE_MOBILE  = 2;
    const TYPE_EMAIL   = 3;

    const READ_STATUS_NO  = 0;
    const READ_STATUS_YES = 1;

    const SEND_USER_SYSTEM = 0;
    const SEND_USER_ADMIN  = 1;



}

