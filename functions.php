<?php

if (!defined("APP_FUNC")) {
    die("access deny!");
}

//定义全局函数

/**
 * @读取指定文件配置项
 * @param $file 配置文件名，不包含后缀
 * @param $key 配置的key
 */
function C($file,$key=""){
    static $config = array();
    $fileName = APP_CONFIG.$file.'.php';
    if(isset($config[$file])) {
        if ($key && isset($config[$file][$key])) {
            return $config[$file][$key];
        }else{
            return $config[$file];
        }
    }else{
        if (!is_file($fileName)) {
          exit('config not exist: ' . $fileName);
        }
        $config[$file] = require_once $fileName;

        if (isset($config[$file][$key])) {
          return $config[$file][$key];
        }
        return $config[$file];
    }
}


/**
 * @记录日志
 * @param $arr 打印数据，字符串或数组
 */
function cslog($arr)
{
    $msg = null;
    $file = __DIR__ . DIRECTORY_SEPARATOR . C('common', 'log_name') . "-" . date('Y-m-d', time()) . ".log";
    if (!file_exists($file)) {
        touch($file);
    }
    if (is_array($arr)) {
        $arr = var_export($arr, true);
    } else if (!is_string($arr)) {
        $arr = (string)$arr;
    }
    $msg = "\n" . $arr . "\n";
    file_put_contents($file, $msg, FILE_APPEND);
}


/**
 * @ 打印数据
 * @param $arr
 */
function csprint($arr){
    if(is_array($arr)){
        echo "<pre/>";
        print_r($arr);
    }else if(!is_string($arr)){
        (string)$arr;
    }else{
        echo "\n<br/>{$arr}</br/>\n";
    }
}


/**
 * @模拟get请求
 * @param $url
 * @return mixed|string
 */
function httpGet($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $https = substr($url, 0, 8) == "https://" ? true : false;
    if ($https) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}


/**
 * @模拟post请求
 * @param $url
 * @param array $query
 * @param array $header
 * @return mixed
 */
function httpPost($url, $query = array(), $header = array("Content-Type" => "application/x-www-form-urlencoded"))
{
    $ch = curl_init();
    $query = http_build_query($query);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSLVERSION, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}


?>