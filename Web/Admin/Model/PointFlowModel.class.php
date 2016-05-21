<?php
namespace Admin\Model;

use Common\Helper\Arr;
use Common\Helper\Permission;
use Common\Helper\Session;
use Common\Helper\Constant;
use Think\Model;

class PointFlowModel extends Model {

    #is_sub 是否为扣分
    const IS_SUB_NO    = 0; #正积分
    const IS_SUB_YES    = 1; #负积分


    #type 类型
    const TYPE_ADD_INSTALL   = 0; #安装积分
    const TYPE_ADD_ORDER     = 1; #提款失败，积分返回
    const TYPE_ADD_SALARY    = 2; #月推广收入
    const TYPE_ADD_BONUS     = 3; #系统奖励
    const TYPE_SUB_ORDER     = -1; #提款
    const TYPE_SUB_TAKEOUT   = -3; #系统扣除


    public static $aAllType = array(
        self::TYPE_ADD_INSTALL  => '日安装积分',
        self::TYPE_ADD_ORDER    => '提款失败积分返回',
        self::TYPE_ADD_SALARY   => '月推广积分',
        self::TYPE_ADD_BONUS    => '系统奖励',
        self::TYPE_SUB_ORDER    => '提款',
        self::TYPE_SUB_TAKEOUT  => '系统扣除',
    );

    #addpoint 错误码
    const ADD_POINT_ERR_PARAM       = 1; #参数错误
    const ADD_POINT_ERR_NOT_ENOUGH  = 6; #账户余额不够扣
    const ADD_POINT_ERR_DB_UPDATE   = 7; #更新数据库失败

    public static $aAllAddPointError = array(
        self::ADD_POINT_ERR_PARAM           => '参数错误',
        self::ADD_POINT_ERR_NOT_ENOUGH      => '账户余额不足',
        self::ADD_POINT_ERR_DB_UPDATE       => '更新数据库失败',
    );

    /**
     * 加减牛币
     * @param $iUserID
     * @param $iPoint
     * @param $iType
     * @param string $sDetail
     * @param null $sDate   流水生成日期，默认当天，如无特别需求，不要设置该字段
     * @param int $iErrCode   错误码，0 :正常
     * @return bool
     */
    public function addPoint($iUserID, $fPoint, $iType, $sDetail = '', $sDate = null, &$iErrCode = 0) {
        $iErrCode = 0;

        $User = M("user");
        $User->getById($iUserID);

        if (empty($User->id)) {
            $iErrCode = self::ADD_POINT_ERR_PARAM;
            goto END;
        }

        $fPoint = (float)$fPoint;
        if (!($fPoint > 0)) {
            $iErrCode = self::ADD_POINT_ERR_PARAM;
            goto END;
        }

        if (!$sDate) {
            $sDate = date('Y-m-d');
        } else {
            $sDate = date('Y-m-d', strtotime($sDate));
        }

        if ($sDate == '1970-01-01') {
            $iErrCode = self::ADD_POINT_ERR_PARAM;
            goto END;
        }

        if (!self::$aAllType[$iType]) {
            $iErrCode = self::ADD_POINT_ERR_PARAM;
            goto END;
        }

        $PointFlow = M("point_flow");
        $PointFlow->create();
        $PointFlow->user_id     = $User->id;
        $PointFlow->date        = $sDate;
        $PointFlow->point       = $fPoint;
        $PointFlow->type        = $iType;
        $PointFlow->is_sub      = $iType >= 0 ? self::IS_SUB_NO : self::IS_SUB_YES;

        #账户牛币不够扣除
        if ($PointFlow->is_sub == self::IS_SUB_YES) {
            $aUserPoint = M("user_point")->where(array('user_id' => $PointFlow->user_id))->find();
            $iUserPoint = empty($aUserPoint) ? 0 : $aUserPoint['point'];

            if ($iUserPoint < $fPoint) {
                $iErrCode = self::ADD_POINT_ERR_NOT_ENOUGH;
                goto END;
            }
        }

        if ($sDetail) {
            $PointFlow->type_detail = serialize(array('detail' => $sDetail));
        }

        try {
            $PointFlow->startTrans();

            #修改用户总积分
            $UserPoint = M("user_point");
            $UserPoint->create();
            $aOldData = $UserPoint->where(array('user_id' => $PointFlow->user_id))->find();
            if (empty($aOldData)) {
                $UserPoint->user_id         = $PointFlow->user_id;
                $UserPoint->point           = $PointFlow->point;
                $UserPoint->order_point     = 0;
                $bUserPointResult           = $UserPoint->add();
            } else {
                $bUserPointResult = $PointFlow->execute(
                    sprintf("UPDATE user_point SET point = point %s %f WHERE user_id = %d",
                        $PointFlow->is_sub == self::IS_SUB_YES ? '-' : '+',
                        $PointFlow->point,
                        $PointFlow->user_id
                    )
                );
            }
            if ($bUserPointResult === false) {
                throw new \RuntimeException("Insert user_point error");
            }

            #添加流水
            if (!$PointFlow->add()) {
                throw new \RuntimeException("Insert tec_point_flow error");
            }

            # 提交
            $PointFlow->commit();
            goto END;
        } catch (\RuntimeException $E) {
            $PointFlow->rollback();
            $iErrCode = self::ADD_POINT_ERR_DB_UPDATE;
            goto END;
        }

        END:

        if ($iErrCode) {
            return false;
        } else {
            return true;
        }
    }

}

