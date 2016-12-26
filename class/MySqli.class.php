<?php

class MySqli
{
    static public $instance = FALSE;

    //数据库链接句柄

    public $db = FALSE;

    private $config = FALSE;

    /**
     * 获取单例
     * @param  string $configFile [数据库配置文件]
     * @return [type]             [description]
     */

    static public function instance($configFile = '')

    {

        if (!self::$instance) {

            self::$instance = new self($configFile);

        }


        return self::$instance;

    }


    private function __construct($configFile = '')

    {

        $this->config = C('db');

        if ($configFile) {

            $this->config = array_merge($this->config, C($configFile));

        }


        $this->connet();


    }


    /**
     * 链接数据库
     * @return [type] [description]
     */

    private function connet()

    {

        if (empty($this->config)) {

            die('未获取到数据库配置文件');

        }


        $c = $this->config;


        $port = $c['db_port'] ? ":{$c['db_port']}" : ':3306';

        $this->db = new mysqli(($c['db_host'] . $port), $c['db_user'], $c['db_pwd'], $c['db_name']);


        if (mysqli_connect_errno()) {

            die(mysqli_connect_error());

        }


        $this->db->query('set names ' . $c['db_charset']);


    }


    /**
     * 用作与调用数据库原始方法
     * @param  [type] $name   [description]
     * @param  [type] $params [description]
     * @return [type]         [description]
     */

    public function __call($name, $params)

    {
        if (method_exists($this->db, $name)) {
            return call_user_func_array(array($this->db, $name), $params);
        }

    }

}


?>