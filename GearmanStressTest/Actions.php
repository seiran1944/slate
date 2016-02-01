<?php

	class LocalAction { 
		/*
	  	private static $instance; //for singleton
	  	
	  	private __construct() { 
	  		$this->ConnectDB();
	  		self::$instance = $this;
	  	} 
	  	// getInstance method
		public static function getInstance(){ 
			return (!self::$instance) ? new self() : self::$instance;
		}
		*/
		
		/*private static $_dbConneted = false;
		private static function ConnectDB(){//db connection
			if( self::$_dbConneted == true ){
				return;
			}

			$dbhost = '127.0.0.1';
			$dbuser = 'root';
			$dbpass = '1234';
			$dbname = 'StressTest';
			$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');
			mysql_query("SET NAMES 'utf8_unicode_ci'");
			mysql_select_db($dbname);
	    		
			self::$_dbConneted = true;
			return $conn;
		}*/

        private static $mysqli = null;
        private static function getMysqli(){
            //----mysqli
            $localMySqoli = self::mysqli;
            if ( $localMySqoli ) {
                return $localMySqoli;
            }
            $dbhost = '127.0.0.1';
            $dbuser = 'root';
            $dbpass = '1234';
            $dbname = 'StressTest';
            $localMySqoli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            self::mysqli = $localMySqoli;

            return $localMySqoli;
        }
		

		/*
		* this function generates another session id by using the current one , using 'uniqid' and 'md5'
		*/
		public static function sidEncrypt(){	//Session ID maker
	  		//$_sessionID = session_id();
	  		//session_start();
	  		/*
		    if(empty($_sessionID)){
		    	$_sessionID = session_id();
		    	//break;
		    } 
		    */

		    $_hash = '';
		    //if( !is_null($_sessionID) ){
		    	//$_hash = uniqid( md5( $_sessionID ) );
		    	$_hash = md5( uniqid(  rand() ) ) ;//32 char 256 bit
			    $_hash = substr( $_hash , 0 , 16 );//16 char 128 bit
		    	//$_sessionID = session_id( $_hash );
		    	echo "<br>"." : EncryptSessionID has done. : ".$_hash."\n";
		    	return $_hash;
		    //}else{
		    	//echo "<br>SessionID Error !! \n\n";
		    	//return "sidEncrypt : Error";
		    //}
		}

		/*
		*this will save an the url pic under the folder 'temp' using an 'uniqid' name. 
		*/
		public static function saveImg( $_imgSrc = "http://s2.gigacircle.com/media/s2_53f2e7917dad8.jpg" ){//img saving  //default value for test
	  		$_picture = file_get_contents($_imgSrc);
	  		$_uniName = uniqid(); 
			file_put_contents( ('temp/'.$_uniName.'.jpg') , $_picture );
				
			echo "<br>save pic to temp\n";
			return 'saveImg';
		}

		/*
		*saving action log to db
		*/
		/*public static function toLog( $_action = 'default' , $_duration = 0 ){	//default value for test
			self::ConnectDB();
			$_sql = "INSERT INTO `log`
					(_action, _duration)
					VALUES
					( '$_action' , '$_duration' )";
			$_result = mysql_query($_sql) or die('MySQL query error');
			echo "<br>log record completed !! \n";
			return 'toLog';
		}*/


        /*
		*saving action log to db
		*/
        public static function toLog( $_action = 'default' , $_duration = 0 ){	//default value for test
            $mysqli = self::getMysqli();
            $_sql = "INSERT INTO `log`
					(_action, _duration)
					VALUES
					( ? , ? )";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('ss', $_action, $_duration);

            $_result = $stmt->execute() or die('MySQL query error');
            echo "<br>log record completed !! \n";
            return 'toLog';
        }
		

  }//end class LocalAction




  require 'fbSDK4.4/autoload.php';
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookRedirectLoginHelper;
  class FbAction {
  		/* 
	  	private static $instance; //for singleton

	  	private __construct() { 
	  		self::$instance = $this;
	  	}

	  	// getInstance method
		public static function getInstance(){ 
			return (!self::$instance) ? new self() : self::$instance;
		}
		*/

		public static function getPic(){
			// 載入facebook
	        $_appID = '714394328634688';
	        $_appSecret = 'f63833463be0bf1734b633af5c607e23';
	        $_myUrl = 'http://192.168.201.12/Aris/GearmanStressTest/public/';

	        // 啟用session
	        //session_start();

	        // 設定預設App資訊
	        FacebookSession::setDefaultApplication($_appID, $_appSecret);

	        // 取得權限
	        // 返回的網址要在App Settings (Website -> Site URL) 那邊設定相同
	        // 如果沒有預設的APP_ID和APP_Secret的話可以在後面帶入
	           $helper = new FacebookRedirectLoginHelper($_myUrl, $_appID, $_appSecret);
	           //$helper = new FacebookRedirectLoginHelper('');
	           //print '-----getHelper-----';
	           $session = 0;
	        // 判斷是否已經返回而且取得session
	        try {
	            // 判斷session是否取得成功
	            $session = $helper->getSessionFromRedirect();
	            //$session = new FacebookSession($_token);
	            //$helper = new FacebookRedirectLoginHelper($_myUrl);
	            //print 'getHelperSession';
	        } catch (FacebookRequestException $ex) {
	            // 取得錯誤資訊
	            //var_dump($ex);
	        } catch (Exception $ex) {
	            // 取得其他錯誤資訊
	            //var_dump($ex);
	        }

            return self::getAlbumsPicUrl($session);

		}//end function getPic


        private static function getAlbumsPicUrl($session){
            $_defaultImgUrl = 'http://s2.gigacircle.com/media/s2_53f2e7917dad8.jpg';//set default to prevent error
            $_imgUrlArray = [];
            if ($session) {//already logged in
                    //$params = array('type'=>'page', 'q'=>'food');
                    //$params = array('type'=>'albums');
                    $request = new FacebookRequest($session, 'GET', '/me/photos/uploaded');//, $params );
                    $response = $request->execute();
                    $graphObject = $response->getGraphObject()->asArray();// GraphUser, GraphLocation or GraphSessionInfo

                    $_imgObjectArray = $graphObject['data'];
                    foreach( $_imgObjectArray as $_index => $_imgObject ){
                        array_push( $_imgUrlArray , $_imgObject->source );
                    }

                    shuffle($_imgUrlArray);//
            } else {    //ask to login again
                //$loginUrl = $helper->getLoginUrl();
                //header('Location: ' . $loginUrl);
                //exit;
            }
            //print($_imgUrlArray[0]);
            return is_null($_imgUrlArray[0]) ? $_defaultImgUrl : $_imgUrlArray[0];

            //print '<pre>';
            //var_dump($graphObject);
            //print '</pre>';
        }
	}//end


