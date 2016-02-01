<?php
/**
 * Created by PhpStorm.
 * User: aris_chen
 * Date: 2014/9/4
 * Time: ¤W¤È 10:53
 */
//this is a model
print "DB_connection<br>";

include("simple_html_dom.php");

$_dbConneted = false;
function ConnectDB()
{
    if ($_dbConneted == true) {
        return;
    }

    $dbhost = '127.0.0.1';
    $dbuser = 'root';
    $dbpass = '1234';
    $dbname = 'SoccerData';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
    mysql_query("SET NAMES 'utf8_unicode_ci'");
    mysql_select_db($dbname);

    $_dbConneted = true;
    return $conn;
}

//----------------------------------------1.2
function ParseData()
{
    $_fileSrc = "https://tw.sports.yahoo.com/soccer/worldcup/standings/";
    echo "1-2 : -- ", $_fileSrc, "<br>";

    $_parserHtml = file_get_html($_fileSrc);

    $_inquiry = $_parserHtml->find("div[class=bd yom-tabview yui3-tabview-content]");
    $_content = "";

    foreach ($_inquiry as $_element) {
        //echo $element , '<br>';
        $_content = $_content . $_element;
    }

    echo "  -- : ", $_inquiry, "<br>";

    $datetime = date("Y-m-d H:i:s", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y')));
    echo $datetime, "<br>";

    ConnectDB();
    $_content = htmlentities($_content, ENT_QUOTES, "utf-8"); //html_entity_decode();
    $_content = mysql_real_escape_string($_content); //htmlspecialchars($text )
    $sql = "INSERT INTO `Soccer`
			(_date , _content)
			VALUES
			( '$datetime' , '$_content')";
    $result = mysql_query($sql) or die('MySQL query error');
    //echo $sql."<br>";
    echo "Damn !!";
    echo $result;
}

//------------------------------END-------1.2

//----------------------------------------1.3
function Inqury()
{
    //echo "1.3-1";
    ConnectDB();

    $sql = "SELECT * FROM `Soccer`";
    $result = mysql_query($sql) or die('MySQL qsuery error');

    //echo $result;
    //echo "--: <br>";
    $_dataArray = array();
    while ($row = mysql_fetch_assoc($result)) {
        //echo "---<br>";
        //echo $row['_index']." : ".$row['_dates']." : ".$row['_content'];
        //echo "<br>";

        //$row['_content'] = htmlspecialchars($row['_content']);//restore HTML texts
        //$row['_content'] = html_entity_decode($row['_content']);//reverse the process

        array_push($_dataArray, $row);
    }

    //return json_encode( $_dataArray );
    return $_dataArray;
}

function InquryByID($_id)
{
    //echo "1.3-2";
    ConnectDB();

    $sql = "SELECT _content FROM `Soccer` WHERE _index='$_id'";
    $result = mysql_query($sql) or die('MySQL qsuery error');

    //echo $result;
    //echo "--: <br>";

    $_dataArray = array();
    while ($row = mysql_fetch_assoc($result)) { //mysql_fetch_array //assoc
        //echo "---<br>";
        //echo $row['_index']." : ".$row['_date']." : ".$row['_content'];
        //echo "<br>";

        $row['_content'] = htmlspecialchars($row['_content']); //restore HTML texts
        $row['_content'] = html_entity_decode($row['_content']); //reverse the process

        array_push($_dataArray, $row['_content']);
    }

    //echo "<br>";
    //return json_encode( $_dataArray );
    return $_dataArray;
}

//-----------------------------END--------1.3

//ParseData();
//Inqury();
//InquryByID(2);

?>