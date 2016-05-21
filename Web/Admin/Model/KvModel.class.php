<?php
namespace Admin\Model;

use Common\Helper\Arr;
use Think\Model;

class KvModel extends Model
{

    /**
     * 类型
     */
    const TYPE_NORMAL   = 0;
    const TYPE_JSON     = 1;
    const TYPE_SERIALIZE = 2;

    public static $aTypeMap = array(
        self::TYPE_NORMAL   => '字符串',
        self::TYPE_JSON   => 'JSON',
        self::TYPE_SERIALIZE   => '序列化',
    );

    const D2GF_ALL_LEVEL_1 = 'd2gf_all_level_1';
    /**
     * 状态
     */
    const STATUS_NORMAL = 1; #有效配置
    const STATUS_INVALID = 0; #无效配置

    const DATAIMPORT_MISS = 'dataimport_miss'; #每日返量数据缺失


    /**
     * 获取value
     * @param $sKey
     * @param int $iType @todo 此字段后续优化要删掉
     * @param int $iStatus
     * @return bool|mixed|string
     */
    public function findV($sKey, $iType = self::TYPE_NORMAL, $iStatus = self::STATUS_NORMAL)
    {
        $aWhere = array(
            'status'    => $iStatus,
            'key'       => $sKey,
        );
        $aKv = M("kv")->where($aWhere)->find();

        if (empty($aKv)) {
            return false;
        }

        return self::parseValue($aKv['value'], $aKv['type']);
    }

    /**
     * 解析value
     * @param $sValue
     * @param int $iType
     * @return mixed
     */
    public static function parseValue($sValue, $iType = self::TYPE_NORMAL) {
        switch ((int)$iType) {
            case self::TYPE_NORMAL :
                $sReturn = $sValue;
                break;
            case self::TYPE_JSON :
                $sReturn = json_decode($sValue, true);
                break;
            case self::TYPE_SERIALIZE :
                $sReturn = unserialize($sValue);
                break;
            default :
                $sReturn = $sValue;
                break;
        }
        return $sReturn;
    }

    /**
     * 生成value
     * @param $sValue
     * @param int $iType
     * @return mixed
     */
    public static function createValue($sValue, $iType = self::TYPE_NORMAL) {
        switch ($iType) {
            case self::TYPE_NORMAL :
                $sReturn = $sValue;
                break;
            case self::TYPE_JSON :
                $sReturn = json_encode($sValue);
                break;
            case self::TYPE_SERIALIZE :
                $sReturn = serialize($sValue);
                break;
            default :
                $sReturn = $sValue;
                break;
        }
        return $sReturn;
    }

    /**
     * 设置value
     * @param $sKey
     * @param $sValue
     * @param bool $bForceInsert
     * @param $sKeyName
     * @param int $iStatus
     * @return bool|int
     */
    public function setV($sKey, $sValue, $bForceInsert = false, $sKeyName = '', $iStatus = self::STATUS_NORMAL, $iType = self::TYPE_NORMAL) {
        $Model  = M("kv");
        $bCheck = $Model->where(array('key' => $sKey))->count();
        if ($bForceInsert) {
            if ($bCheck) {
                return false;
            }
        }

        if (!$bCheck) {
            $bForceInsert = true;
        }

        if ($bForceInsert) {
            $bResult = $Model->add(array('key'   => $sKey, 'value' => $sValue, 'key_name' => $sKeyName, 'status' => $iStatus, 'type' => $iType));
        } else {
            $bResult = $Model->where(array('key' => $sKey))->save(array('value' => $sValue, 'status' => $iStatus));
        }

        return $bResult;
    }

}
