<?php
namespace Admin\Model;

use Common\Helper\Arr;
use Common\Helper\Permission;
use Common\Helper\Session;
use Common\Helper\Constant;
use Think\Log;
use Think\Model;
use Think\Think;

class UserOrderModel extends Model {
    const ORDER_ING  = 0;
    const ORDER_SUCC = 1;
    const ORDER_FAIL = 2;


    static $Model;
    const STATUS_ORDER_UN_GENT          = 1;

    /**
     * @param Item_User $User
     * @param int       $iPoint
     * @param int       $iErr
     * @param string    $sErr
     *
     * @return bool
     */
    public static function toBank($User, $iPoint, &$iErr, &$sErr)
    {
        $iPoint = (int)$iPoint;
        $iUID   = (int)$User->id;
        $sDate  = date('Y-m-d');

        self::$Model = M("user_point");

        # pre
        list($iOrderID, $sOrderBID) = self::apply_award($iPoint, $iUID, $sDate, $iErr, $sErr);
        if ($iOrderID===false || $sOrderBID===false) {
            goto END;
        }

        END:
        return $iErr === 0;
    }

    /**
     * @param int    $iPoint
     * @param int    $iUID
     * @param string $sDate
     * @param int    $iErr
     * @param int    $sErr
     *
     * @return bool | int  order_id
     */
    public static function apply_award($iPoint, $iUID, $sDate, &$iErr, &$sErr)
    {
        $sChr = "\t";

        $iErr      = 0;
        $sErr      = '';
        $sOrderBID = false;
        $iOrderID  = false;

        if ($iPoint % 1000 !== 0) {
            $iErr = self::STATUS_ORDER_UN_GENT;
            $sErr = '打款金额错误';
            goto END;
        }

        $LogOrder = new Log();
        $sIP = get_client_ip();
        $sOrderBID = null;

        $sDebug = "uid=$iUID{$sChr}point=$iPoint{$sChr}date=$sDate{$sChr}ip=$sIP";

        try {
            Log::write("pre transfer begin{$sChr}$sDebug");

            self::$Model->startTrans();
            # 扣除用户积分
            $aRow = self::$Model->query("SELECT * FROM user_point WHERE user_id = $iUID FOR UPDATE");
            if (empty($aRow)) {
                throw new \RuntimeException('获取用户余额错误');
            }
            $iOrgPoint = (int)$aRow[0]['point'];
            if ($iOrgPoint < $iPoint) {
                throw new \RuntimeException('账户牛币不足');
            }

            if (!self::$Model->execute(
                "
                UPDATE user_point
                    SET point = point - $iPoint, order_point = order_point + $iPoint
                    WHERE user_id = $iUID AND point >= $iPoint
                "
            )
            ) {
                throw new \RuntimeException("更新用户牛币失败");
            }

            # 生成订单流水
            $sOrderInfo = json_encode(array('point' => $iPoint, 'result' => array()));
            $sOrderBID  = self::gentOrderBID($iUID);

            if (!self::$Model->execute(
                "INSERT INTO user_order
                    (order_bid, user_id, point, order_info, status) VALUES
                    ('$sOrderBID', $iUID, $iPoint, '$sOrderInfo', 0)
                "
            )
            ) {
                throw new \RuntimeException("Insert user_order error");
            }
            $iOrderID = self::$Model->getLastInsID();

            # 生成积分变更流水
            if (!self::$Model->execute(
                sprintf(
                    "
                    INSERT INTO point_flow
                        (user_id, date, point, is_sub, type, type_id,type_detail) VALUES
                        (%d, '%s', %d, %d, %d, %d,'%s')
                    ",
                    $iUID,
                    $sDate,
                    $iPoint,
                    1,
                    Constant::DB_POINT_FLOW_SUB_ORDER,
                    $iOrderID,
                    serialize(array('detail' => '申请提取流量'))
                )
            )
            ) {
                throw new \RuntimeException("Insert order_flow error");
            }
            # 提交
            self::$Model->commit();

            Log::write("pre transfer succ{$sChr}$sDebug{$sChr}order_bid=$sOrderBID");

        } catch (\Exception $E) {
            self::$Model->rollBack();
            $iErr = self::STATUS_ORDER_UN_GENT;
            $sErr = $E->getMessage();
            Log::write("pre transfer fail{$sChr}$sDebug{$sChr}order_bid=$sOrderBID{$sChr}msg='$sErr'");
            goto END;
        }

        END:
        return array($iOrderID, $sOrderBID);
    }

    /**
     * @param \PDO  $PDO
     * @param array $aRS
     * @param int   $iOrderID
     * @param int   $iStatus
     *
     * @throws \RuntimeException
     */
    protected static function updateOrderInfo($PDO, $aRS, $iOrderID, $iStatus)
    {
        $STMT = $PDO->query("SELECT order_info FROM user_order WHERE id = $iOrderID FOR UPDATE");
        if (!$STMT) {
            throw new \RuntimeException('Select order_info error');
        }
        $aRow = $STMT->fetch(\PDO::FETCH_ASSOC);

        # 订单先前已处理
        if ($aRS['transfer_status'] == 20302 && $aRow['status'] != 0) {
            return;
        }

        $sOrderInfo = json_encode($aRS);

        if ($PDO->exec(
                "UPDATE user_order SET `status` = $iStatus ,
                    `last_transfer_status` = {$aRS['transfer_status']},
                    `order_info` = '$sOrderInfo'
                 WHERE id = $iOrderID"
            ) === false
        ) {
            throw new \RuntimeException("Update user_order status to $iStatus failed[$iOrderID]");
        }
    }

    public static function gentOrderBID($iUID)
    {
        list($sUS, $sS) = explode(' ', (string)microtime());
        $sStr = sprintf('%s%s%s%s', rand(0, 255), (int)$sS, (int)$iUID, (int)($sUS * 1000));
        return base_convert($sStr, 10, 36);
    }
}

