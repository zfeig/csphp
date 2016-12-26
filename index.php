<?php
define("APP_FUNC", true);
define("APP_PATH", dirname(__FILE__) . DIRECTORY_SEPARATOR);
define("APP_CONFIG", APP_PATH . "config" . DIRECTORY_SEPARATOR);
require_once "functions.php";//引入全局函数
require_once "autoload.php";//引入自动加载类
App::run();//入口文件
?>