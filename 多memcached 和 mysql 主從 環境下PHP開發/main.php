<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 2014/11/14
 * Time: 下午 2:42
 */
//require 'init.php';
include('Memcached.php');
include('Mysql.php');

echo 'entry point';

$mem = new Memcached;
/* $mem->set('en_xx','bucuo');
echo($mem->get('en_xx'));
$mem->set('cn_jjyy','wokao');
echo($mem->get('cn_jjyy'));
*/

$sq = new Mysql;
$sql = "insert into pair(girl,boy) values('sunny','aris')";
$mdsql = md5($sql);
if(!$result=$mem->get('cn_'.$mdsql)){
    $sq->mquery($sql); //插入到主mysql
    $result = $sq->fetArray("select * from pair"); //查詢 是 從mysql
    foreach($result as $var){
        echo $var['girl'];
    }
    $mem->set('cn_'.$mdsql,$result); //添加到 名為 cn 的 memcached 伺服器
}else{
    foreach($result as $var){
        echo $var['girl'];
    }
}
