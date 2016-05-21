<?php

namespace Common\Helper;
class Common {

    public static $aWeek = array('日', '一', '二', '三', '四', '五', '六');

    public static function safeDivision($a, $b, $iLen = 2) {
        if ($b == 0) {
            return 0;
        } else {
            return round($a / $b, $iLen);
        }
    }


    /**
     * 生成相应的目录
     * @param $sFilePath
     * @return bool string
     */
    public static function createDir($sFilePath) {
        clearstatcache($sFilePath);
        if (!$sFilePath) {
            return false;
        }
        $sDir = dirname($sFilePath);
        clearstatcache($sDir);
        if (is_dir($sDir)) {
            goto END;
        }

        if (!mkdir($sDir, 0777, true)) {
            return false;
        }

        END:
        return $sFilePath;
    }


    public static function isMobileNum($iNum) {
        $iNum = trim($iNum);
        $r = preg_match('/^\d{11}$/', $iNum);
        return $r ? true : false;
    }

    public static function isTelNum($tel) {
        $regxArr = array(
            //'sj'  => '/^(\+?86-?)?(18|15|13)[0-9]{9}$/',
            'tel' => '/^(010|02\d{1}|0[3-9]\d{2})-\d{3,12}(-\d+)?$/',
            //'400' => '/^400(-\d{3,4}){2}$/',
        );

        foreach($regxArr as $regx) {
            if(preg_match($regx,$tel)) {
                return true;
            }
        }
        return false;
    }


    public static function isQQNum($iNum) {
        $iNum = trim($iNum);
        $r = preg_match('/^\d{5,12}$/', $iNum);
        return $r ? true : false;
    }


    public static function ajaxDataConvert($iErrorno,$sError,$sMsg = '',$isRet = 0) {
        $aTmp = array('errno' => $iErrorno ,
            'error' => $sError ,
            'msg' => $sMsg);
        if($isRet) {
            return $aTmp;
        } else {
            echo json_encode($aTmp);
        }

    }




    /**
     * 下载文件
     **/

    public static function downloadFile($sFile, $sDownloadFileName='')
    {
        if (!file_exists($sFile)) {
            return false;
        }
        $sBaseName = $sDownloadFileName ? $sDownloadFileName : basename($sFile);
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=".$sBaseName);
        readfile($sFile);
    }

    public static function clearData($mData, $sDel = ' ')
    {
        if (is_array($mData)) {
            foreach ($mData as $key => $data) {
                $mData[$key] = trim($data, $sDel);
            }
        }else{
            return trim($mData);
        }
        return $mData;
    }


    public static function cutStr(
        $str,//截取字符串
        $iLen,//要截取的长度
        $sPad='...',
        $sCharset='utf-8'
    ) {
        $iStrLen = mb_strlen($str,$sCharset);
        if ($iStrLen <= $iLen) {
            return $str;
        }
        return mb_substr($str, 0, $iLen, $sCharset) . $sPad;
    }


    /**
     * 判断一个数组是否递增key的数组
     *
     *     // Returns TRUE
     *     Arr::is_assoc(array('username' => 'john.doe'));
     *
     *     // Returns FALSE
     *     Arr::is_assoc('foo', 'bar');
     *
     * @param   array   array to check
     * @return  boolean
     */
    public static function is_assoc(array $array)
    {
        // Keys of the array
        $keys = array_keys($array);

        // If the array keys of the keys match the keys, then the array must
        // not be associative (e.g. the keys array looked like {0:0, 1:1...}).
        return array_keys($keys) !== $keys;
    }

    /**
     * Merges one or more arrays recursively and preserves all keys.
     * Note that this does not work the same as [array_merge_recursive](http://php.net/array_merge_recursive)!
     *
     *     $john = array('name' => 'john', 'children' => array('fred', 'paul', 'sally', 'jane'));
     *     $mary = array('name' => 'mary', 'children' => array('jane'));
     *
     *     // John and Mary are married, merge them together
     *     $john = Arr::merge($john, $mary);
     *
     *     // The output of $john will now be:
     *     array('name' => 'mary', 'children' => array('fred', 'paul', 'sally', 'jane'))
     *
     * @param   array  initial array
     * @param   array  array to merge
     * @param   array  ...
     * @return  array
     */
    public static function merge(array $a1, array $a2)
    {
        $result = array();
        for ($i = 0, $total = func_num_args(); $i < $total; $i++)
        {
            // Get the next array
            $arr = func_get_arg($i);

            // Is the array associative?
            $assoc = self::is_assoc($arr);

            foreach ($arr as $key => $val)
            {
                if (isset($result[$key]))
                {
                    if (is_array($val) AND is_array($result[$key]))
                    {
                        if (Arr::is_assoc($val))
                        {
                            // Associative arrays are merged recursively
                            $result[$key] = Arr::merge($result[$key], $val);
                        }
                        else
                        {
                            // Find the values that are not already present
                            $diff = array_diff($val, $result[$key]);

                            // Indexed arrays are merged to prevent duplicates
                            $result[$key] = array_merge($result[$key], $diff);
                        }
                    }
                    else
                    {
                        if ($assoc)
                        {
                            // Associative values are replaced
                            $result[$key] = $val;
                        }
                        elseif ( ! in_array($val, $result, TRUE))
                        {
                            // Indexed values are added only if they do not yet exist
                            $result[] = $val;
                        }
                    }
                }
                else
                {
                    // New values are added
                    $result[$key] = $val;
                }
            }
        }

        return $result;
    }

}
