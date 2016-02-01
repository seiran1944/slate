<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 2014/11/14
 * Time: 下午 1:43
 */

$memcached = array(  //用memcached 的 多 進程類比 多台memcached 伺服器     cn     en   為  記憶體伺服器名
    'cn'=>array('127.0.0.1',11211),
    'en'=>array('127.0.0.1',11212)
);
$mysql    = array( // mysql 的主從 我的環境是 ： xp 主    linux 從  mysql 5  php5
    'master'=>array('127.0.0.1','root','1234','MasterSlave'),
    'slave_1'=>array('127.0.0.1','root','1234','MasterSlave')  //可以靈活添加多台從伺服器
);
