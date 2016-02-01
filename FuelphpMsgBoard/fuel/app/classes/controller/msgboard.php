<?php
/**
 * The msgboard Controller.
 * @package  app
 * @extends  Controller
 */
//include('../model/msgboardDB.php');
use \DbModel\DataTrain as DataTrain;
//use \Symfony\Component\Console\Input;

class Controller_Msgboard extends Controller
{
    public function action_index()
    {
        echo "Controller_Msgboard";

        $data = array(
                    'name' => 'QQQQ',
                );

        return View::forge('msgboard', $data );
    }

    /** to method.
     * @param  $name
     */
    public function action_to($name = 'guest')
    {
        return View::forge('msgboard', array(
            'name' => $name
        ));
    }

    public function action_getarticles(){
        $_articles = DataTrain::GetArticles();

        /*
          //for test
        $_articles = array( array( 'index' => '0' , '_author' => 'Aris' , '_date' => 'today' , '_content' => 'QQQQQ' ) ,
                            array( 'index' => '1' , '_author' => 'Sunny' , '_date' => 'yesterday' , '_content' => 'GGGGG' )
                           );
        */

        return View::forge('msgboard', array( '_articles' => $_articles ) );
    }

    public function action_newmsg(){
        //return View::forge('hello', array( 'name'=>'default' ) );
        $_author = Input::post( '_author' , 'phpDefault' );
        $_content = Input::post( '_content' , 'noContent' );

        $_result = DataTrain::NewArticle( $_author , $_content );

        return 'Db message !! : ';//.$_result.' : '.$_author.' : '.$_content;
    }
}
/* end of /fuel/app/classes/controller/hello.php */