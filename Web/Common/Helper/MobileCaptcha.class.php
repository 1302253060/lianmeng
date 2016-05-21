<?php
namespace Common\Helper;
use Common\Helper\Common;


class MobileCaptcha {

    const REDIS_PRE_KEY = 'mobile_captcha_';

    const EXPIRE_TIME = 1800;

    /**
     * 获取到生成的验证码,并放入redis
     * @param @iMobile int 电话号码
     * @param @iExpire int 过期时间 秒
     * @return int
     */
    public static function get($iMobile,$iNumLen = 6,$iExpire = 180) {
        !is_numeric($iExpire) && $iExpire = 180;
        if(!Common::isMobileNum($iMobile)) return 0;
        $iNum = self::_getRandNum($iNumLen);
        $ret  = S(self::REDIS_PRE_KEY.$iMobile, $iNum, $iExpire);
        return $ret ? $iNum : 0;
    }

    public static function delete($iMobile) {
        return S(self::REDIS_PRE_KEY.$iMobile, null);
    }

    public static function getCaptcha($iMobile) {
        return S(self::REDIS_PRE_KEY.$iMobile);
    }


    /**
     * 检查验证码是否正确
     * @param @iMobile int 电话号码
     * @param @iVal int 验证码
     * @return bool
     */
    public static function check($iMobile, $iVal) {
        $ret = S(self::REDIS_PRE_KEY.$iMobile);
        return ($ret !== false && $ret == $iVal)  ? true : false;
    }

    private static function _getRandNum($iNumLen = 6) {
        $iNumLen = (int)abs($iNumLen);
        empty($iNumLen) && $iNumLen = 1;
        $sNum = '';
        for($i=0;$i<$iNumLen;$i++) {
            $sNum .= mt_rand(0,9);
        }
        return $sNum;
    }

}

// end of script
