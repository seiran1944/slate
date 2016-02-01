<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 2014/11/6
 * Time: 下午 3:01
 */
header("Content-Type:text/html; charset=utf-8");
//include('include_dao.php');
include('StudentScoreDAO.php');
include('ScoreFactory.php');

main::exec();

class main{
    public static function exec(){

        //get score data from db
        $scDAO = new StudentScoreDAO();
        $studentScoreList = $scDAO->getStudentScoreAll();

        //var_dump($studentScoreList);

        //count weighted grade
        $scoreFactory = ScoreFactory::getStudentScoreFactory();
        $result = $scoreFactory->countIndividualWeightedSum($studentScoreList);


        //count individual sum

        var_dump( $result );
    }
}













