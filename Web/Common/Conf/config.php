<?php
return array(
    //'配置项'=>'配置值'
    //数据库配置
    'db_type'  => 'mysql',
    'db_user'  => 'root',
    'db_pwd'   => '',
    'db_host'  => '127.0.0.1',
    'db_port'  => '3306',
    'db_name'  => 'lianmeng',
    'DB_PREFIX' => '',
    'db_charset'=>'utf8',

    // redis配置
    'DATA_CACHE_PREFIX' => 'Redis_',//缓存前缀
    'DATA_CACHE_TYPE'   =>'Redis',//默认动态缓存为Redis
    'REDIS_RW_SEPARATE' => false, //Redis读写分离 true 开启
    'REDIS_HOST'        =>'127.0.0.1', //redis服务器ip，多台用逗号隔开；读写分离开启时，第一台负责写，其它[随机]负责读；
    'REDIS_PORT'        =>'6379',//端口号
    'REDIS_TIMEOUT'     =>'300',//超时时间
    'REDIS_PERSISTENT'  =>false,//是否长连接 false=短连接
    'REDIS_AUTH'        =>'',//AUTH认证密码
    'DATA_CACHE_TIME'   => 3600,      // 数据缓存有效期 0表示永久缓存

    'TMPL_TEMPLATE_SUFFIX'=>'.php',
//    'TMPL_ENGINE_TYPE' =>'PHP',

    'URL_MODEL' => '2',


);