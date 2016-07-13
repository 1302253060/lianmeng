<?php
namespace Admin\Model;

use Common\Helper\Arr;
use Common\Helper\Permission;
use Common\Helper\Session;
use Common\Helper\Constant;
use Think\Model;

class UserModel extends Model {

    const STATUS_FREEZE = 1;
    const STATUS_NORMAL = 0;

    const LEVEL_ONE = 1;
    const LEVEL_TWO = 2;

    const IDCARD_PASS = 1;

    const LOGIN_HIDDEN = 1; // 禁止登录
    const LOGIN_NORMAL = 0; // 正常

    const COMPANY_PASS   = 1; // 公司认证通过
    const COMPANY_REVIEW = 2; // 公司认证已经提交
    const COMPANY_FAIL   = 3; // 公司认证失败
    const COMPANY_NO     = 0; // 未提交过认证


    static $PCINSTALL = array(
        '捆绑', '地推', '门店', '预装', '诱导', '网推', '网吧', '虚拟机'
    );
    static $APPINSTALL = array(
        '推荐量', '市场量', '推送量', '手机厂商量', '手机门店量', '手机虚拟机量', '其他量'
    );

    public static function isFreeze($iStatus) {
        if ((int)$iStatus === self::STATUS_FREEZE) {
            return true;
        } else if ((int)$iStatus === self::STATUS_NORMAL) {
            return false;
        }
    }


    public static function isIdcardOk($iStatus) {
        if ((int)$iStatus === self::IDCARD_PASS) {
            return true;
        } else {
            return false;
        }
    }


    public static function getLevelName($iLevel) {
        $sName = '';
        switch((int)$iLevel) {
            case self::LEVEL_ONE:
                $sName = '一级渠道';
                break;
            case self::LEVEL_TWO:
                $sName = '二级渠道';
                break;
            default:
                break;
        }
        return $sName;
    }

    public static function getParent($iUserID) {
        return M("user")->find($iUserID);
    }


    public static function isAllowLogin($iHidden) {
        if ((int)$iHidden === self::LOGIN_NORMAL) {
            return true;
        } else {
            return false;
        }
    }

    public static function getCompanyStatusName($iStatus) {
        $sName = '';
        switch((int)$iStatus) {
            case self::COMPANY_NO:
                $sName = '未提交';
                break;
            case self::COMPANY_PASS:
                $sName = '通过';
                break;
            case self::COMPANY_REVIEW:
                $sName = '审核中';
                break;
            case self::COMPANY_FAIL:
                $sName = '审核失败';
                break;
            default:
                break;
        }
        return $sName;
    }

    public function changeStatus($iStatus, $sReason = '') {
        $bReturn = false;
        switch ($iStatus) {
            case self::STATUS_NORMAL :
                $bReturn = $this->unfreeze($sReason);
                break;
            case self::STATUS_FREEZE :
                $bReturn = $this->freeze($iStatus, $sReason);
                break;
            default :
                break;
        }
        return $bReturn === true ? true : false;
    }


    /**
     *  解冻
     *  @param  string $sReason 原因
     *  @return bool
     **/
    public function unfreeze($sReason = '') {
        $bReturn = false;

        if (!self::isFreeze($this->status)) {
            goto END;
        }

        $this->status           = self::STATUS_NORMAL;
        $this->unfreeze_time    = date('Y-m-d H:i:s');

        $this->setNoteInfo(array(
            'unfreeze_reason'    => $sReason,
        ));

        $bReturn = $this->save() === true ? true :false;

        END:
        return $bReturn;
    }



    /**
     * 冻结
     * @param int $iStatus
     * @param string $sReason
     * @param bool $bCheckSafe 是否需要验证安全期
     * @return bool
     */
    public function freeze($iStatus = self::STATUS_FREEZE, $sReason = '') {
        $bReturn = false;

        if (self::isFreeze($this->status)) {
            goto END;
        }

        switch ($iStatus) {
            case self::STATUS_FREEZE:
                break;
            default :
                goto END;
                break;
        }

        $this->status       = $iStatus;
        $this->freeze_time  = date('Y-m-d H:i:s');

        $aNoteInfo = $this->getNoteInfo();

        $aNoteInfo['freeze_reason'] = $sReason;

        $this->setNoteInfo($aNoteInfo, true);

        $bReturn = $this->save() === true ? true : false;

        END:
        return $bReturn;
    }


    public function setNoteInfo(array $aInfo, $bReplace = false)
    {
        if ($this->note_info) {
            $aNoteInfo = unserialize($this->note_info);
        } else {
            $aNoteInfo = array();
        }

        if ($bReplace) {
            $this->note_info = serialize($aInfo);
        } else {
            $this->note_info = serialize(array_merge($aNoteInfo, $aInfo));
        }
    }
    public function getNoteInfo()
    {
        if ($this->note_info) {
            return unserialize($this->note_info);
        } else {
            return array();
        }
    }

    public function checkExchangeAuth($iPoint = 0) {
        $aError = array();
        if(!self::isIdcardOk($this->idcard_ok)) {
            $aError = array(
                'errCode' => 1001,
                'errMsg'  => '请先绑定身份证,再进行提现操作',
                'data'    => array()
            );
            goto END;
        }
        if(self::isFreeze($this->status)) {
            $aError = array(
                'errCode' => 1002,
                'errMsg'  => '用户已冻结或未审核,请联系管理员',
                'data'    => array()
            );
            goto END;
        }
        if(!$this->subbranch || !$this->bankcard || !$this->payee) {
            $aError = array(
                'errCode' => 1003,
                'errMsg'  => '请先绑定银行卡，再进行提现操作',
                'data'    => array()
            );
            goto END;
        }
        # 提款超过限额
//        if ($this->getMonthOrderPoint(null, true) + $iPoint > Model_TecPointFlow::POINT_MAX_EXCHANGE) {
//            $aError = $this->fail('您本月已兑换牛币(含本次)超过 ' . Model_TecPointFlow::POINT_MAX_EXCHANGE . ' 牛币' , null, 1004);
//            goto END;
//        }
        $aError = array(
            'errCode' => 1004,
            'errMsg'  => '请先绑定银行卡，再进行提现操作',
            'data'    => array()
        );
        END:
        return $aError;
    }


    public function ifLogin($bAutoAddExpire = false)
    {
        if (Session::instance()->get('home_member_id')) {
            return true;
        } else {
            return false;
        }
    }

    public function isD2gfLevelOne() {
        $Model   = new \Admin\Model\KvModel();
        $sUserID = $Model->findV(KvModel::D2GF_ALL_LEVEL_1);
        if (!$sUserID) {
            return false;
        }
        $aUserID = explode("\n", $sUserID);
        if (in_array($this->id, $aUserID)) {
            return true;
        }
        return false;
    }
}

