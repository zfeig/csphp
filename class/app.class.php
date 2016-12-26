<?php

class App
{
    public static function run()
    {
        header("Content-Type:text/html;charset=utf-8");
        //call other class
        $test = new Test();
        $test->hello();


        //get db config
        $dbconfig = C("db");
        csprint($dbconfig);

        //get data from mysql
        $db = MySql::instance();
        $data =$db->q("SELECT * FROM diaries WHERE channel=? AND diary_id = ? ",["gengmei",9559505],true);
        $data =$db->q("INSERT INTO `record`(count,type,lasttime,fid) VALUES(?,?,?,?) ",[11,2,0,2],false);
        csprint($data);
        cslog($data);

        //get http
//        $body = httpGet("http://www.baidu.com");
//        csprint(htmlentities($body));
    }
}

?>