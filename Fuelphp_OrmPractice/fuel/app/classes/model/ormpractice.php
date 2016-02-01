<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 9/19/14
 * Time: 11:19 AM
 */
    namespace DbModel;

    use Fuel\Core\Model_Crud;
    use Fuel\Core\Package;
    use Orm\Model;
    use Fuel\Core\DB;

    Package::load('orm');

    class Model_DataTrain extends \Model {
        private static $_db = null;

        public static function Orm_GetAllGuest(){//全部房客列表
            //Package::load('orm');
            $_ormGuest = Orm_Guest::forge();
            $_ormObjectArray = $_ormGuest->find('all');//Note :it returns an Array with 'Orm_Guest' inside , there's $_data : Array in there.

            $_guestArray = array();
            foreach( $_ormObjectArray as $_index=>$_value ){
                array_push( $_guestArray , $_value->GetData() );//can not use $_value->_data , I don't know why. so I get the data by definding a method.
            }

            /*
            echo '<pre>';
            var_dump($_guestArray);
            echo '</pre>';
            */

            return $_guestArray;

        }

        public static function Orm_FindGuest($_name){//單一客戶
            $_ormGuest = Orm_Guest::forge();
            $_sqlCondition = array( 'where' => array( array('_name' , $_name ) ) );
            $_ormObjectArray = $_ormGuest::find( 'all' , $_sqlCondition );

            $_guestArray = array();
            foreach( $_ormObjectArray as $_index=>$_value ){
                array_push( $_guestArray , $_value->GetData() );//can not use $_value->_data , I don't know why. so I get the data by defining a method.
            }

            /*
            echo '<pre>';
            var_dump($_guestArray);
            echo '</pre>';
            */

            return $_guestArray;

        }

        public static function Crud_GetAllGoods(){
            //get Guest datas
            $_crudGoods = Crud_Goods::forge();
            $_crudObjectArray = $_crudGoods::find_all();

            $_goodsArray = array();
            foreach( $_crudObjectArray as $_index=>$_value ){
                array_push( $_goodsArray , $_value->GetData() );//can not use $_value->_data , I don't know why. so I get the data by definding a method.
            }

            /*
            echo '<pre>';
            var_dump($_goodsArray);
            echo '</pre>';
            */

            return $_goodsArray;
        }

        public static function Crud_FindGoods( $_name ){
            //get Guest datass
            $_crudGoods = Crud_Goods::forge();
            $_crudObject = $_crudGoods::find_one_by( '_name' , $_name );//return as a Crud_Goods object with array wrapping

            $_goodsArray = array( $_crudObject->GetData() );

            /*
            echo '<pre>';
            var_dump($_goodsArray);
            echo '</pre>';
            */

            return $_goodsArray;
        }

        private static function DB_Query(){//for test , to make sure that my DB is connected
            $_sql = 'SELECT * FROM Guest';
            $_query = DB::query($_sql);
            $_guestArray = $_query->execute()->as_array();
            //var_dump($_guestArray);
            return $_guestArray;
        }

    }


    class Orm_Guest extends \Orm\Model{
        //private static $_instance = null;//for singleton

        protected static $_table_name = 'Guest';
        protected static $_primary_key = array('_ID');
        protected static $_properties = array('_ID', '_name', '_phone', '_address');

        /*
        public static function GetInstance(){
            is_null(self::_instance) ? new self() : $this;
            return self::$_instance;
        }

        public function __construct(){
            self::$_instance = $this;
        }
        */

        public function GetData(){
            return $this->_data;
        }
    }


    class Crud_Goods extends \Model_Crud{
        private static $_instance = null;//for singleton

        protected static $_table_name = 'Goods';
        protected static $_primary_key = array('_ID');
        protected static $_properties = array('_ID', '_name', '_price', '_importDate' , '_importorID' );


        public static function GetInstance(){
            is_null(self::_instance) ? new self() : $this;
            return self::$_instance;
        }

        public function __construct(){//there's some problem with original constructor // unknown problem   //overwrite to avoid that
            self::$_instance = $this;
        }


        public function GetData(){
            return $this->_data;
        }

    }

