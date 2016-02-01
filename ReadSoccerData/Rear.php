<?php
/**
 * Created by PhpStorm.
 * User: aris_chen
 * Date: 2014/9/4
 * Time: 上午 10:53
 */
echo "Entry Point<br>";

include("simple_html_dom.php");

$mysqli = null;
function getMysqli(){
    //----mysqli
    global $mysqli;
    if ( $mysqli ) {
        return $mysqli;
    }
    $dbhost = '127.0.0.1';
    $dbuser = 'root';
    $dbpass = '1234';
    $dbname = 'SoccerData';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    return $mysqli;
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

    //echo "  -- : ", $_inquiry, "<br>";

    $datetime = date("Y-m-d H:i:s", mktime(date('H') + 8, date('i'), date('s'), date('m'), date('d'), date('Y')));
    echo $datetime, "<br>";

    $_content = htmlentities($_content, ENT_QUOTES, "utf-8");//html_entity_decode();
    //$_content = mysql_real_escape_string($_content);//htmlspecialchars($text )
    $_content = getMysqli()->escape_string($_content);//htmlspecialchars($text )

    writeIntoSql($datetime, $_content);
}

function writeIntoSql($dateTime, $content){
    $sql = "INSERT INTO `Soccer`
			(_date , _content)
			VALUES
			( ?, ?)";

    $mysqli = getMysqli();
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $dateTime, $content);

    echo $stmt->execute();

    $stmt->close();
}
//------------------------------END-------1.2

//----------------------------------------1.3
//mysqli
function Inqury()
{
    $mysqli = getMysqli();
    $sql = "SELECT * FROM `Soccer`";
    $dataArray = [];
    if ($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            echo "---<br>";
            echo $row['_index'] . " : " . $row['_date'] . " : " . $row['_content'];
            echo "<br>";

            $row['_content'] = htmlspecialchars($row['_content']);//restore HTML texts
            $row['_content'] = html_entity_decode($row['_content']);//reverse the process

            array_push($dataArray, $row);
        }

        $result->close();
    }
    return json_encode($dataArray);
}
//mysqli
function InquryByID($_id)
{
    $mysqli = getMysqli();
    $sql = "SELECT * FROM `Soccer` WHERE _index=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $_id);
    $stmt->execute();

    $stmt->bind_result($index, $date, $content);

    $dataArray = [];
    $row = null;
    while ($stmt->fetch()) {
        $row = [];
        $row['_index'] = $index;
        $row['_date'] = $date;
        $row['_content'] = html_entity_decode( htmlspecialchars($content) );
        array_push($dataArray, $row);
    }

    $stmt->close();

    return json_encode($dataArray);
}
//-----------------------------END--------1.3

ParseData();
//Inqury();
//InquryByID(2);

?>
