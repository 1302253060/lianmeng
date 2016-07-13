-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-07-13 04:09:24
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lianmeng`
--

-- --------------------------------------------------------

--
-- 表的结构 `effect_guid`
--

CREATE TABLE IF NOT EXISTS `effect_guid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `supply_id` int(11) NOT NULL,
  `guid` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `effect_guid`
--

INSERT INTO `effect_guid` (`id`, `date`, `supply_id`, `guid`) VALUES
(10, '2016-07-11', 0, 'efe29214204803fd43c82af5baa31327');

-- --------------------------------------------------------

--
-- 表的结构 `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `supply_id` varchar(20) COLLATE utf8_bin NOT NULL,
  `package_name` varchar(500) COLLATE utf8_bin NOT NULL,
  `guid` varchar(1000) COLLATE utf8_bin NOT NULL,
  `os_major_ver` int(11) NOT NULL,
  `os_minor_ver` int(11) NOT NULL,
  `os_bit` int(11) NOT NULL,
  `mac` varchar(20) COLLATE utf8_bin NOT NULL,
  `cpu` varchar(1000) COLLATE utf8_bin NOT NULL,
  `aHardDisk` varchar(2000) COLLATE utf8_bin NOT NULL,
  `mainboard` varchar(1000) COLLATE utf8_bin NOT NULL,
  `version` varchar(100) COLLATE utf8_bin NOT NULL,
  `virtual_machine` int(11) NOT NULL,
  `other` varchar(10000) COLLATE utf8_bin NOT NULL,
  `ip` varchar(100) COLLATE utf8_bin NOT NULL,
  `server` text COLLATE utf8_bin NOT NULL,
  `create_time` datetime NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`) COMMENT 'date',
  KEY `guid` (`guid`(333)) COMMENT 'guid'
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `report`
--

INSERT INTO `report` (`id`, `supply_id`, `package_name`, `guid`, `os_major_ver`, `os_minor_ver`, `os_bit`, `mac`, `cpu`, `aHardDisk`, `mainboard`, `version`, `virtual_machine`, `other`, `ip`, `server`, `create_time`, `date`) VALUES
(24, '10005', 'd2gf_IQIYIsetup_10005.exe', 'efe29214204803fd43c82af5baa31327', 6, 1, 1, '9a17b542e815', '["BFEBFBFF00040651"]', '["SCSI\\\\DISK&VEN_SAMSUNG&PROD_MZ7TE128HMGR-000\\\\4&28428033&0&000000"]', '20AMS39800', '1.0.0.1', 0, '{"user_name":"huangjianxiang","shell_exe_path":"D:\\\\\\u5b89\\u88c5\\u5305\\\\"}', '183.167.211.20', '{"_FCGI_X_PIPE_":"\\\\\\\\.\\\\pipe\\\\IISFCGI-f79ac4a8-6d9f-49bb-9ee4-9c016e5dcb2a","PHP_FCGI_MAX_REQUESTS":"10000","PHPRC":"C:\\\\PHP\\\\php5.4\\\\","ALLUSERSPROFILE":"C:\\\\Documents and Settings\\\\All Users","APP_POOL_ID":"DefaultAppPool","ClusterLog":"C:\\\\WINDOWS\\\\Cluster\\\\cluster.log","CommonProgramFiles":"C:\\\\Program Files\\\\Common Files","COMPUTERNAME":"GHCN2K--5088","ComSpec":"C:\\\\WINDOWS\\\\system32\\\\cmd.exe","FP_NO_HOST_CHECK":"NO","NUMBER_OF_PROCESSORS":"2","OS":"Windows_NT","Path":"C:\\\\WINDOWS\\\\system32;C:\\\\WINDOWS;C:\\\\WINDOWS\\\\System32\\\\Wbem;C:\\\\Program Files\\\\Microsoft SQL Server\\\\80\\\\Tools\\\\BINN;D:\\\\Program Files\\\\Huweishen.com\\\\PHPWEB\\\\php","PATHEXT":".COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH","PROCESSOR_ARCHITECTURE":"x86","PROCESSOR_IDENTIFIER":"x86 Family 6 Model 62 Stepping 4, GenuineIntel","PROCESSOR_LEVEL":"6","PROCESSOR_REVISION":"3e04","ProgramFiles":"C:\\\\Program Files","SystemDrive":"C:","SystemRoot":"C:\\\\WINDOWS","TEMP":"C:\\\\WINDOWS\\\\TEMP","TMP":"C:\\\\WINDOWS\\\\TEMP","USERPROFILE":"C:\\\\Documents and Settings\\\\Default User","windir":"C:\\\\WINDOWS","ORIG_PATH_INFO":"\\/index.php\\/api\\/client","HTTP_X_REWRITE_URL":"\\/index.php\\/api\\/client","HTTP_USER_AGENT":"Mozilla\\/5.0 AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/42.0.2311.135 Safari\\/537.36","HTTP_HOST":"www.d2gf.com","HTTP_CONTENT_TYPE":"charset=UTF-8","HTTP_CONTENT_LENGTH":"292","HTTP_PRAGMA":"no-cache","HTTP_CONNECTION":"keep-alive","HTTP_CACHE_CONTROL":"no-cache","SCRIPT_FILENAME":"D:\\\\d2gf\\\\index.php","DOCUMENT_ROOT":"D:\\\\d2gf","REQUEST_URI":"\\/index.php\\/api\\/client","URL":"\\/index.php","REMOTE_PORT":"17296","REMOTE_USER":"","SERVER_SOFTWARE":"Microsoft-IIS\\/6.0","SERVER_PROTOCOL":"HTTP\\/1.1","SERVER_PORT_SECURE":"0","SERVER_PORT":"80","SERVER_NAME":"www.d2gf.com","SCRIPT_NAME":"\\/index.php","REQUEST_METHOD":"POST","REMOTE_HOST":"183.167.211.20","REMOTE_ADDR":"183.167.211.20","QUERY_STRING":"","PATH_TRANSLATED":"D:\\\\d2gf\\\\index.php\\\\api\\\\client","PATH_INFO":"client","LOGON_USER":"","LOCAL_ADDR":"119.10.55.72","INSTANCE_META_PATH":"\\/LM\\/W3SVC\\/70251328","INSTANCE_ID":"70251328","HTTPS_SERVER_SUBJECT":"","HTTPS_SERVER_ISSUER":"","HTTPS_SECRETKEYSIZE":"","HTTPS_KEYSIZE":"","HTTPS":"off","GATEWAY_INTERFACE":"CGI\\/1.1","CONTENT_TYPE":"charset=UTF-8","CONTENT_LENGTH":"292","CERT_SUBJECT":"","CERT_SERIALNUMBER":"","CERT_ISSUER":"","CERT_FLAGS":"","CERT_COOKIE":"","AUTH_USER":"","AUTH_PASSWORD":"","AUTH_TYPE":"","APPL_PHYSICAL_PATH":"D:\\\\d2gf\\\\","APPL_MD_PATH":"\\/LM\\/W3SVC\\/70251328\\/Root","FCGI_ROLE":"RESPONDER","PHP_SELF":"\\/index.php\\/api\\/client","REQUEST_TIME_FLOAT":1468255717.7306,"REQUEST_TIME":1468255717}\n', '2016-07-12 01:28:00', '2016-07-11'),
(23, '0', 'd2gf_IQIYIsetup.exe', 'efe29214204803fd43c82af5baa31327', 6, 1, 1, '9a17b542e815', '["BFEBFBFF00040651"]', '["SCSI\\\\DISK&VEN_SAMSUNG&PROD_MZ7TE128HMGR-000\\\\4&28428033&0&000000"]', '20AMS39800', '1.0.0.1', 0, '{"user_name":"huangjianxiang","shell_exe_path":"D:\\\\\\u5b89\\u88c5\\u5305\\\\"}', '183.167.211.20', '{"_FCGI_X_PIPE_":"\\\\\\\\.\\\\pipe\\\\IISFCGI-f79ac4a8-6d9f-49bb-9ee4-9c016e5dcb2a","PHP_FCGI_MAX_REQUESTS":"10000","PHPRC":"C:\\\\PHP\\\\php5.4\\\\","ALLUSERSPROFILE":"C:\\\\Documents and Settings\\\\All Users","APP_POOL_ID":"DefaultAppPool","ClusterLog":"C:\\\\WINDOWS\\\\Cluster\\\\cluster.log","CommonProgramFiles":"C:\\\\Program Files\\\\Common Files","COMPUTERNAME":"GHCN2K--5088","ComSpec":"C:\\\\WINDOWS\\\\system32\\\\cmd.exe","FP_NO_HOST_CHECK":"NO","NUMBER_OF_PROCESSORS":"2","OS":"Windows_NT","Path":"C:\\\\WINDOWS\\\\system32;C:\\\\WINDOWS;C:\\\\WINDOWS\\\\System32\\\\Wbem;C:\\\\Program Files\\\\Microsoft SQL Server\\\\80\\\\Tools\\\\BINN;D:\\\\Program Files\\\\Huweishen.com\\\\PHPWEB\\\\php","PATHEXT":".COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH","PROCESSOR_ARCHITECTURE":"x86","PROCESSOR_IDENTIFIER":"x86 Family 6 Model 62 Stepping 4, GenuineIntel","PROCESSOR_LEVEL":"6","PROCESSOR_REVISION":"3e04","ProgramFiles":"C:\\\\Program Files","SystemDrive":"C:","SystemRoot":"C:\\\\WINDOWS","TEMP":"C:\\\\WINDOWS\\\\TEMP","TMP":"C:\\\\WINDOWS\\\\TEMP","USERPROFILE":"C:\\\\Documents and Settings\\\\Default User","windir":"C:\\\\WINDOWS","ORIG_PATH_INFO":"\\/index.php\\/api\\/client","HTTP_X_REWRITE_URL":"\\/index.php\\/api\\/client","HTTP_USER_AGENT":"Mozilla\\/5.0 AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/42.0.2311.135 Safari\\/537.36","HTTP_HOST":"www.d2gf.com","HTTP_CONTENT_TYPE":"charset=UTF-8","HTTP_CONTENT_LENGTH":"285","HTTP_PRAGMA":"no-cache","HTTP_CONNECTION":"keep-alive","HTTP_CACHE_CONTROL":"no-cache","SCRIPT_FILENAME":"D:\\\\d2gf\\\\index.php","DOCUMENT_ROOT":"D:\\\\d2gf","REQUEST_URI":"\\/index.php\\/api\\/client","URL":"\\/index.php","REMOTE_PORT":"39627","REMOTE_USER":"","SERVER_SOFTWARE":"Microsoft-IIS\\/6.0","SERVER_PROTOCOL":"HTTP\\/1.1","SERVER_PORT_SECURE":"0","SERVER_PORT":"80","SERVER_NAME":"www.d2gf.com","SCRIPT_NAME":"\\/index.php","REQUEST_METHOD":"POST","REMOTE_HOST":"183.167.211.20","REMOTE_ADDR":"183.167.211.20","QUERY_STRING":"","PATH_TRANSLATED":"D:\\\\d2gf\\\\index.php\\\\api\\\\client","PATH_INFO":"client","LOGON_USER":"","LOCAL_ADDR":"119.10.55.72","INSTANCE_META_PATH":"\\/LM\\/W3SVC\\/70251328","INSTANCE_ID":"70251328","HTTPS_SERVER_SUBJECT":"","HTTPS_SERVER_ISSUER":"","HTTPS_SECRETKEYSIZE":"","HTTPS_KEYSIZE":"","HTTPS":"off","GATEWAY_INTERFACE":"CGI\\/1.1","CONTENT_TYPE":"charset=UTF-8","CONTENT_LENGTH":"285","CERT_SUBJECT":"","CERT_SERIALNUMBER":"","CERT_ISSUER":"","CERT_FLAGS":"","CERT_COOKIE":"","AUTH_USER":"","AUTH_PASSWORD":"","AUTH_TYPE":"","APPL_PHYSICAL_PATH":"D:\\\\d2gf\\\\","APPL_MD_PATH":"\\/LM\\/W3SVC\\/70251328\\/Root","FCGI_ROLE":"RESPONDER","PHP_SELF":"\\/index.php\\/api\\/client","REQUEST_TIME_FLOAT":1468255501.4025,"REQUEST_TIME":1468255501}\n', '2016-07-12 01:28:00', '2016-07-11'),
(22, '10005', 'd2gf_IQIYIsetup_10005.exe', 'efe29214204803fd43c82af5baa31327', 6, 1, 1, '9a17b542e815', '["BFEBFBFF00040651"]', '["SCSI\\\\DISK&VEN_SAMSUNG&PROD_MZ7TE128HMGR-000\\\\4&28428033&0&000000"]', '20AMS39800', '1.0.0.1', 0, '{"user_name":"huangjianxiang","shell_exe_path":"D:\\\\\\u5b89\\u88c5\\u5305\\\\"}', '183.167.211.20', '{"_FCGI_X_PIPE_":"\\\\\\\\.\\\\pipe\\\\IISFCGI-f79ac4a8-6d9f-49bb-9ee4-9c016e5dcb2a","PHP_FCGI_MAX_REQUESTS":"10000","PHPRC":"C:\\\\PHP\\\\php5.4\\\\","ALLUSERSPROFILE":"C:\\\\Documents and Settings\\\\All Users","APP_POOL_ID":"DefaultAppPool","ClusterLog":"C:\\\\WINDOWS\\\\Cluster\\\\cluster.log","CommonProgramFiles":"C:\\\\Program Files\\\\Common Files","COMPUTERNAME":"GHCN2K--5088","ComSpec":"C:\\\\WINDOWS\\\\system32\\\\cmd.exe","FP_NO_HOST_CHECK":"NO","NUMBER_OF_PROCESSORS":"2","OS":"Windows_NT","Path":"C:\\\\WINDOWS\\\\system32;C:\\\\WINDOWS;C:\\\\WINDOWS\\\\System32\\\\Wbem;C:\\\\Program Files\\\\Microsoft SQL Server\\\\80\\\\Tools\\\\BINN;D:\\\\Program Files\\\\Huweishen.com\\\\PHPWEB\\\\php","PATHEXT":".COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH","PROCESSOR_ARCHITECTURE":"x86","PROCESSOR_IDENTIFIER":"x86 Family 6 Model 62 Stepping 4, GenuineIntel","PROCESSOR_LEVEL":"6","PROCESSOR_REVISION":"3e04","ProgramFiles":"C:\\\\Program Files","SystemDrive":"C:","SystemRoot":"C:\\\\WINDOWS","TEMP":"C:\\\\WINDOWS\\\\TEMP","TMP":"C:\\\\WINDOWS\\\\TEMP","USERPROFILE":"C:\\\\Documents and Settings\\\\Default User","windir":"C:\\\\WINDOWS","ORIG_PATH_INFO":"\\/index.php\\/api\\/client","HTTP_X_REWRITE_URL":"\\/index.php\\/api\\/client","HTTP_USER_AGENT":"Mozilla\\/5.0 AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/42.0.2311.135 Safari\\/537.36","HTTP_HOST":"www.d2gf.com","HTTP_CONTENT_TYPE":"charset=UTF-8","HTTP_CONTENT_LENGTH":"292","HTTP_PRAGMA":"no-cache","HTTP_CONNECTION":"keep-alive","HTTP_CACHE_CONTROL":"no-cache","SCRIPT_FILENAME":"D:\\\\d2gf\\\\index.php","DOCUMENT_ROOT":"D:\\\\d2gf","REQUEST_URI":"\\/index.php\\/api\\/client","URL":"\\/index.php","REMOTE_PORT":"17296","REMOTE_USER":"","SERVER_SOFTWARE":"Microsoft-IIS\\/6.0","SERVER_PROTOCOL":"HTTP\\/1.1","SERVER_PORT_SECURE":"0","SERVER_PORT":"80","SERVER_NAME":"www.d2gf.com","SCRIPT_NAME":"\\/index.php","REQUEST_METHOD":"POST","REMOTE_HOST":"183.167.211.20","REMOTE_ADDR":"183.167.211.20","QUERY_STRING":"","PATH_TRANSLATED":"D:\\\\d2gf\\\\index.php\\\\api\\\\client","PATH_INFO":"client","LOGON_USER":"","LOCAL_ADDR":"119.10.55.72","INSTANCE_META_PATH":"\\/LM\\/W3SVC\\/70251328","INSTANCE_ID":"70251328","HTTPS_SERVER_SUBJECT":"","HTTPS_SERVER_ISSUER":"","HTTPS_SECRETKEYSIZE":"","HTTPS_KEYSIZE":"","HTTPS":"off","GATEWAY_INTERFACE":"CGI\\/1.1","CONTENT_TYPE":"charset=UTF-8","CONTENT_LENGTH":"292","CERT_SUBJECT":"","CERT_SERIALNUMBER":"","CERT_ISSUER":"","CERT_FLAGS":"","CERT_COOKIE":"","AUTH_USER":"","AUTH_PASSWORD":"","AUTH_TYPE":"","APPL_PHYSICAL_PATH":"D:\\\\d2gf\\\\","APPL_MD_PATH":"\\/LM\\/W3SVC\\/70251328\\/Root","FCGI_ROLE":"RESPONDER","PHP_SELF":"\\/index.php\\/api\\/client","REQUEST_TIME_FLOAT":1468255717.7306,"REQUEST_TIME":1468255717}\n', '2016-07-12 01:28:00', '2016-07-11'),
(21, '0', 'd2gf_IQIYIsetup.exe', 'efe29214204803fd43c82af5baa31327', 6, 1, 1, '9a17b542e815', '["BFEBFBFF00040651"]', '["SCSI\\\\DISK&VEN_SAMSUNG&PROD_MZ7TE128HMGR-000\\\\4&28428033&0&000000"]', '20AMS39800', '1.0.0.1', 0, '{"user_name":"huangjianxiang","shell_exe_path":"D:\\\\\\u5b89\\u88c5\\u5305\\\\"}', '183.167.211.20', '{"_FCGI_X_PIPE_":"\\\\\\\\.\\\\pipe\\\\IISFCGI-f79ac4a8-6d9f-49bb-9ee4-9c016e5dcb2a","PHP_FCGI_MAX_REQUESTS":"10000","PHPRC":"C:\\\\PHP\\\\php5.4\\\\","ALLUSERSPROFILE":"C:\\\\Documents and Settings\\\\All Users","APP_POOL_ID":"DefaultAppPool","ClusterLog":"C:\\\\WINDOWS\\\\Cluster\\\\cluster.log","CommonProgramFiles":"C:\\\\Program Files\\\\Common Files","COMPUTERNAME":"GHCN2K--5088","ComSpec":"C:\\\\WINDOWS\\\\system32\\\\cmd.exe","FP_NO_HOST_CHECK":"NO","NUMBER_OF_PROCESSORS":"2","OS":"Windows_NT","Path":"C:\\\\WINDOWS\\\\system32;C:\\\\WINDOWS;C:\\\\WINDOWS\\\\System32\\\\Wbem;C:\\\\Program Files\\\\Microsoft SQL Server\\\\80\\\\Tools\\\\BINN;D:\\\\Program Files\\\\Huweishen.com\\\\PHPWEB\\\\php","PATHEXT":".COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH","PROCESSOR_ARCHITECTURE":"x86","PROCESSOR_IDENTIFIER":"x86 Family 6 Model 62 Stepping 4, GenuineIntel","PROCESSOR_LEVEL":"6","PROCESSOR_REVISION":"3e04","ProgramFiles":"C:\\\\Program Files","SystemDrive":"C:","SystemRoot":"C:\\\\WINDOWS","TEMP":"C:\\\\WINDOWS\\\\TEMP","TMP":"C:\\\\WINDOWS\\\\TEMP","USERPROFILE":"C:\\\\Documents and Settings\\\\Default User","windir":"C:\\\\WINDOWS","ORIG_PATH_INFO":"\\/index.php\\/api\\/client","HTTP_X_REWRITE_URL":"\\/index.php\\/api\\/client","HTTP_USER_AGENT":"Mozilla\\/5.0 AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/42.0.2311.135 Safari\\/537.36","HTTP_HOST":"www.d2gf.com","HTTP_CONTENT_TYPE":"charset=UTF-8","HTTP_CONTENT_LENGTH":"285","HTTP_PRAGMA":"no-cache","HTTP_CONNECTION":"keep-alive","HTTP_CACHE_CONTROL":"no-cache","SCRIPT_FILENAME":"D:\\\\d2gf\\\\index.php","DOCUMENT_ROOT":"D:\\\\d2gf","REQUEST_URI":"\\/index.php\\/api\\/client","URL":"\\/index.php","REMOTE_PORT":"39627","REMOTE_USER":"","SERVER_SOFTWARE":"Microsoft-IIS\\/6.0","SERVER_PROTOCOL":"HTTP\\/1.1","SERVER_PORT_SECURE":"0","SERVER_PORT":"80","SERVER_NAME":"www.d2gf.com","SCRIPT_NAME":"\\/index.php","REQUEST_METHOD":"POST","REMOTE_HOST":"183.167.211.20","REMOTE_ADDR":"183.167.211.20","QUERY_STRING":"","PATH_TRANSLATED":"D:\\\\d2gf\\\\index.php\\\\api\\\\client","PATH_INFO":"client","LOGON_USER":"","LOCAL_ADDR":"119.10.55.72","INSTANCE_META_PATH":"\\/LM\\/W3SVC\\/70251328","INSTANCE_ID":"70251328","HTTPS_SERVER_SUBJECT":"","HTTPS_SERVER_ISSUER":"","HTTPS_SECRETKEYSIZE":"","HTTPS_KEYSIZE":"","HTTPS":"off","GATEWAY_INTERFACE":"CGI\\/1.1","CONTENT_TYPE":"charset=UTF-8","CONTENT_LENGTH":"285","CERT_SUBJECT":"","CERT_SERIALNUMBER":"","CERT_ISSUER":"","CERT_FLAGS":"","CERT_COOKIE":"","AUTH_USER":"","AUTH_PASSWORD":"","AUTH_TYPE":"","APPL_PHYSICAL_PATH":"D:\\\\d2gf\\\\","APPL_MD_PATH":"\\/LM\\/W3SVC\\/70251328\\/Root","FCGI_ROLE":"RESPONDER","PHP_SELF":"\\/index.php\\/api\\/client","REQUEST_TIME_FLOAT":1468255501.4025,"REQUEST_TIME":1468255501}\n', '2016-07-12 01:28:00', '2016-07-11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
