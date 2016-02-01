<?php

    include_once('Model.php');
    $country = trim($_POST['country']);
    $ip = trim($_POST['ip']);
    //print 'queryIP';
    //LocalAction::serializeData('full_blacklist_database.txt');//讀取txt資訊
    //var_dump( LocalAction::ipQuery( 'MAR' , '999.9r9.g99.9h9' ) );//查詢資料
    echo LocalAction::ipQuery($country, $ip) ? 'true' : 'false';
    //echo $country.' : '.$ip;

?>
