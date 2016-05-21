<?php

// 定义应用目录
define('APP_PATH','./Web/');
// 定义运行时目录
define('RUNTIME_PATH','./Runtime/');
// 开启调试模式
define('APP_DEBUG',false);
// 更名框架目录名称，并载入框架入口文件

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/vendor/topthink/ThinkPHP/thinkphp/ThinkPHP.php';