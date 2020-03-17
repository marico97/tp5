<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('LOG_PATH', __DIR__ . '/../log/');

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
//error_reporting设置应该报告的错误，下面表示除了 E_NOTICE，报告其他所有错误
error_reporting(E_ALL ^ E_NOTICE);
//输出错误
ini_set('display_errors', 1);

//结束开发以后下面打开

//error_reporting(E_ALL ^ E_NOTICE);
////禁止把错误输出到页面
//ini_set('display_errors', 0);
////设置错误信息输出到文件
//ini_set('log_errors', 1);
//
////指定错误日志文件名
//$error_dir = '/logs/err/';
//$error_file = $error_dir . date('Ymd').'.log';
////目录不存在就创建
//if (!is_dir($error_dir)){
//    mkdir($error_dir, 0777, true);
//}
////文件不存在就创建之
//if(!file_exists($error_file)){
//    $fp = fopen($error_file, 'w+');
//    if($fp){
//        fclose($fp);
//    }
//}
//
////设置错误输出文件
//ini_set("error_log", $error_file);

