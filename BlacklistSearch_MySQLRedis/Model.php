<?php

/**
 * this class defines server actions for project BlacklistSearch_MySQLRedis
 */
class LocalAction
{
    //simplify structure , no DAO used
    private static $mysqli = null;
    private static function getMysqli(){
        //----mysqli
        $localMySqoli = self::mysqli;
        if ( $localMySqoli == null ) {
            $dbhost = '127.0.0.1';
            $dbuser = 'root';
            $dbpass = '1234';
            $dbname = 'StressTest';
            $localMySqoli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            self::mysqli = $localMySqoli;
        }

        return $localMySqoli;
    }

    private static $_redis = null;
    private static function getRedis()
    { //redis DB
        $localRedis = self::_redis;
        if ($localRedis == null) {
            $localRedis = new Redis(); //redis
            $localRedis->connect('127.0.0.1', 6379);
            self::_redis = $localRedis;
        }
        return $localRedis;
    }

    //====================================================================解讀資料
    /*
    * this function generates another session id by using the current one , using 'uniqid' and 'md5'
    */
    public static function serializeData($url)
    { //解析method
        print 'serializeData : ' . $url . '<br>';

        $fileContent = file_get_contents($url, 0, null, 629);

        $contentLines = explode("\n", $fileContent); //like this :       1.0.0.4	# 2013-04-02, 1.0.0.4, AUS, 50

        $categoryList = []; //array //for cache filtering duplicattion

        //reference vars
        $singleData = null; //IPValueObject
        foreach ($contentLines as $key => $line) {
            if (trim($line) != '') { //當不是空白行時才做解讀
                $singleData = self::parseLine($line); //逐行解讀
                $singleData = self::classifyAndSave($singleData); //加工分類並儲存
                $categoryList[$singleData->categoryName] = $singleData; //依照類名做參照 迴圈完畢後 重複者 會被覆蓋
                //print $singleData->ipPrefix . " : " . $singleData->country;
                //print "<br>";
            }
        }

        //print '---------------==============================';

        self::saveToDB($categoryList);

    }

    private static function saveToDB($categoryList){
        $redis = self::getRedis();
        $file_location = '';
        foreach ($categoryList as $categoryName => $valueObject) { //$valueObject:IPValueObject
            $file_location = $redis->get($categoryName);
            if (is_null($file_location) || !$file_location) { //若Redis無紀錄 則代表沒有記錄過 或 還沒進mySQL撈過
                //if(self::checkExistInSql($valueObject->$country, $valueObject->$ip_prefix)==false){//進DB再找一次
                //寫入資料
                //print 'Data Insert : ' . $valueObject->ipPrefix . '  :  ' . $valueObject->country;
                //print "<br>";
                //當cache裡沒有記錄時才寫DB
                self::writeIntoSql($valueObject->country, $valueObject->ipPrefix, $valueObject->filePath);
                //}else{
                //print $categoryName.' data already exist';
                //}
                //print "<br>";
            }
        }
    }
    //======================================================END===========解讀資料

    //=============================================================查詢
    /*
    *查詢
    */
    public static function ipQuery($country, $ip)
    {
        //先在Redis快取中尋找
        $redisCheck = self::checkIpInRedis($ip);
        if ($redisCheck != -1) { //快取有對應值的話代表已有紀錄
            return $redisCheck ? true : false; //$redisCheck 0 1 -1
        }
        //若資料庫有更新則需先清空REDIS 或 設資料存活時間

        //print 'ipQuery';

        $ipPrefix = self::extractIpPrefix($ip);

        $categoryName = self::fileNameMaker($country, $ipPrefix); //要查詢的類名

        //print 'ipQuery : '.$categoryName;
        $filePath = self::checkExistInSql($country, $ipPrefix); //這邊會得到檔案路徑  或是  false

        return $filePath != false ? self::lookIntoFile($filePath, $ip) : false;
    }
    //================================================END==========查詢

    private static function extractIpPrefix($ip){
        $addressArray = explode(".", $ip); //篩選IPV4 與 IPV6
        return count($addressArray) > 2 ? $addressArray[0] : explode(":", $ip)[0]; //當長度<2 代表為IPV6格式
    }

    private static function setRedisCache($index, $value){
        $redis = self::getRedis();
        $redis->set($index, $value); //作快取動作 以利下次查詢
    }

    //=============================================================file operate
    /*
    *在txt檔中尋找對應IP
    */
    private static function lookIntoFile($filePath, $ip)
    {
        //先在Redis快取中尋找
        $redisCheck = self::checkIpInRedis($ip);
        if ($redisCheck != -1) { //快取有對應值的話代表已有紀錄  則不再往下作動
            return $redisCheck ? true : false; //$redisCheck 0 1 -1
        }
        //若資料庫有更新(delete)則需先清空REDIS 或 設資料存活時間   or there will always a existing record event has already deleted from DB

        //-1代表Redis裡沒有紀錄
        //再於儲存路徑中查找
        $result = false;

        if( file_exists($filePath) ){
            $fileContent = file_get_contents($filePath);
            if (stripos($fileContent, $ip)) {
                $result = true;
            }
        }

        self::setRedisCache($ip, $result);//作快取動作 以利下次查詢

        return $result;
    }

    private static function fileNameMaker($country, $ip_prefix)
    { //統一檔名命名方法
        return $country . '_' . $ip_prefix;
    }

    private static function checkIpInRedis($ip)
    {
        //print ('chekcIpInRedis');
        $result = -1; //-1代表Redis裡沒有紀錄
        $redis = self::getRedis();
        if ($redis->exists($ip)) { //如果有鍵值代表已有查詢結果 則直接回傳查詢結果
            return $redis->get($ip); //boolean
        }
        return $result;
    }
    //=================================================END=========file operate


    //=============================================================parsing Actions
    /**
     *讀出IP第一段數字(1-255)與國家代號
     * @param string $lineString
     * @return IPValueObject
     */
    private static function parseLine($lineString)
    { //like this :       1.0.0.4	# 2013-04-02, 1.0.0.4, AUS, 50
        //$parsedline;
        $line = explode("#", $lineString);

        $ip = $line[0]; //1.0.0.4
        $ipPrefix = self::extractIpPrefix($ip);

        $tail = $line[1]; //2013-04-02, 1.0.0.4, AUS, 50 //完整的內容
        $country = explode(",", $tail)[2]; //AUS

        return new IPValueObject(trim($ip), trim($ipPrefix), $tail, trim($country));
    }

    /**
     *同國家 且 同ipPrefix  尋找同類的記錄檔 然後將IP寫入txt
     * @param IPValueObject $dataPack
     * @return string $categoryName
     */
    private static function classifyAndSave($dataPack)
    { //like this :       1.0.0.4	# 2013-04-02, 1.0.0.4, AUS, 50
        $ipPrefix = $dataPack->ipPrefix;
        $country = $dataPack->country;
        $ip = $dataPack->ip;

        $categoryName = self::fileNameMaker($country, $ipPrefix); //國家代號_IPPrefix   依照類名分辨(後續分類與篩選重複依靠這個)
        $folder = 'IPPrefix/'; ///var/www/html/Aris/BlacklistSearch_MySQLRedis_/
        $fileType = '.txt';

        $filePath = $folder . $categoryName . $fileType; //國家代號_IPPrefix.txt    //預定的路徑

        if( self::lookIntoFile($filePath, $ip) == false ){//記錄檔沒有該筆IP數據才寫入
            file_put_contents($filePath, "\n" . $ip, FILE_APPEND);
        }
        //print ' == '.file_put_contents($filePath, "\n".$dataPack['ip'], FILE_APPEND);
        //print ' ===> '.$filePath;

        //將寫入txt的結果寫回數值包
        $dataPack->categoryName = trim($categoryName);
        $dataPack->filePath = trim($filePath);

        return $dataPack; //回傳數值包
    }

    //================================================END==========parsing Actions

    //=============================================================DB Actions
    /*
    *check if there's any result in database
    */
    private static function checkExistInSql($country, $ipPrefix)
    { //檢查資料是否存在
        $redis = self::getRedis();

        $categoryName = self::fileNameMaker($country, $ipPrefix);
        $file_location = $redis->get($categoryName); //用Redis來查詢

        if (is_null($file_location) || !$file_location) { //當在Redis中找無資料時  才向mySQL索取
            //mysqli
            $mysqli = self::getMysqli();
            $sql = "SELECT * FROM black_ip_list";
            $sqlCategoryName;
            if ($result = $mysqli->query($sql)) {
                while ($row = $result->fetch_assoc()) {
                    $sqlCategoryName = self::fileNameMaker($row['country'], $row['ip_prefix']);
                    $redis->set($sqlCategoryName, $row['file_location']);
                }
                $result->close();
            }
        }

        $file_location = $redis->get($categoryName);

        //print($file_location);
        //print "-----------<br>";

        return is_null($file_location) ? false : $file_location;
    }

    /*
    *write into SQL
    */
    private static function writeIntoSql($country, $ip_prefix, $file_location)
    {
        //mysqli
        $mysqli = self::getMysqli();
        $sql = "INSERT INTO black_ip_list
	  				( country, ip_prefix, file_location )
	  				VALUES
	  				(?, ?, ?)";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('sss', $country, $ip_prefix, $file_location);
        $result = $stmt->execute();

        if ($result) {
            $categoryName = self::fileNameMaker($country, $ip_prefix);
            self::setRedisCache($categoryName, $file_location);
        }
        return $result ? true : false;//to prevent 0,1
    }

    //===================================================END=======SQL Actions
}

//end class LocalAction


class IPValueObject
{
    public $ip; //string
    public $ipPrefix; //string
    public $tail; //string
    public $country; //string

    public $categoryName; //string
    public $filePath; //string

    public function __construct($_ip, $_ipPrefix, $_tail, $_country)
    {
        $this->ip = $_ip;
        $this->ipPrefix = $_ipPrefix;
        $this->tail = $_tail;
        $this->country = $_country;
    }
}//end class IPValueObject
