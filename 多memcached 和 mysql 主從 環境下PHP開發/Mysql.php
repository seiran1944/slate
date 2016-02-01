<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 2014/11/14
 * Time: 下午 2:03
 */
class Mysql
{
    private   $mysqlmaster;
    private   $myssqlslave;
    private static $auid=0;
    public function __construct(){
        require 'config.php';
        $msg = $mysql;

        $this->mysqlmaster = new mysqli($msg['master'][0],$msg['master'][1],$msg['master'][2],$msg['master'][3]); //master mysql
        $this->mysqlslave  = $this->autotranscat($msg); // slave mysql

        if(mysqli_connect_errno()){
            printf("Connect failed: %s\n",mysqli_connect_error());
            exit();
        }
        if(!$this->mysqlmaster->set_charset("latin1") && !$this->mysqlslave->set_charset("latin1")){
            exit("set charset error");
        }
    }

    private function autotranscat($mysql){
        session_start();
        $_SESSION['SID']!=0 || $_SESSION['SID']=0;
        if($_SESSION['SID'] >=count($mysql)-1) $_SESSION['SID'] = 1;
        else $_SESSION['SID']++;
        $key = 'slave_'.$_SESSION['SID'];
        echo($_SESSION['SID']);
        return new mysqli($mysql[$key][0],$mysql[$key][1],$mysql[$key][2],$mysql[$key][3]);
    }

    public function mquery($sql){ //insert  update
        if(!$this->mysqlmaster->query($sql)){
            return false;
        }
    }

    public function squery($sql){
        if($result=$this->mysqlslave->query($sql)){
            return $result;
        }else{
            return false;
        };
    }
    public function fetArray($sql){
        if($result=$this->squery($sql)){
            while($row=$result->fetch_array(MYSQLI_ASSOC)){
                $resultraa[] = $row;
            };
            return $resultraa;
        }
    }
}
