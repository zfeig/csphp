<?php

class MySql
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

    static public function instance($config = array())

    {

        if (!self::$instance) {

            self::$instance = new self($config);

        }


        return self::$instance;

    }


    private function __construct($config = array())

    {

        $this->config = C('db');
        if(!empty($this->config) && !empty($config)){
            $this->config = array_merge($this->config,$config);
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

            die("cant't find config file!");

        }

        $c = $this->config;
        $dsn = $c["db_type"] . ":host=" . $c["db_host"] . ";dbname=" . $c['db_name'];
        try {
            $this->db = new PDO($dsn, $c["db_user"], $c["db_pwd"]);
        } catch (PDOException $e) {
            die("connection failed,please check");
            cslog($e->getMessage());
        }
        $this->db->query('set names ' . $c['db_charset']);
    }



    /**
     * @查询sql语句
     * @param $sql  select * from xx where id= ? and type = ?
     * @param $params array(25,"car")
     * @param bool $fetch true则获取查询结果
     * @return array
     */
    public  function q($sql,$params,$fetch = false){
        $res = $this->db->prepare($sql);
        if(count($params)>0){
            foreach($params as $k => $v){

                $index= $k+1;
                //echo $index." bind ".$v."<br/>";
                $res->bindValue($index,$v);
            }
        }

        $res->execute();
        if($fetch){
            $retData =array();
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                array_push($retData,$row);
            }
            return $retData;
        }
    }


    /**
     * @支持原生方法调用
     * @param $name
     * @param $params
     * @return mixed
     */
    public function __call($name, $params)

    {
        if (method_exists($this->db, $name)) {
            return call_user_func_array(array($this->db, $name), $params);
        }

    }





}


?>