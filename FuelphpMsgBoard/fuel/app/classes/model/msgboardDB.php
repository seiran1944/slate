<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 9/17/14
 * Time: 9:32 AM
 */
    namespace DbModel;

    use \DB;

    class DataTrain extends \Model {
        private static $_db = null;

        public static function GetArticles(){
            //get article datas


            $_sql = "SELECT * FROM article";
            $_result = DB::query( $_sql )->execute();
            $_result = $_result->as_array();

            return $_result;
        }

        public static function NewArticle( $_author , $_content ){
            if( is_null($_author) || is_null($_content) || $_author=='' || $_content=='' ){
                return 'invalid data';
            }
            $_sql = "INSERT INTO article
                        ( _author , _content )
                     VALUES
                        ( '$_author' , '$_content' )
                        ";
            $_result = DB::query( $_sql )->execute();

            return $_result;
        }
    }
