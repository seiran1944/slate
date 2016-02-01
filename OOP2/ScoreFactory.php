<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 2014/11/6
 * Time: 下午 3:02
 */

final class ScoreFactory{//this is a factory dispatch hub
    private static $factoryTypePrefixs = [
        'Weight' => 'Weight_',
        'StudentScore' => 'StudentScore',
    ];
    private static $factoryInstances = [];

    public static function printInstancesDetail(){
        var_dump( static::$factoryInstances );
    }

    /**
     * @param String $cno   : class no.
     * @return WeightFactory
     */
    public static function getWeightFactory(&$cno){
        $instanceName = (string) static::$factoryTypePrefixs['Weight'] . $cno;
        $instance = &static::$factoryInstances[$instanceName];
        $instance = isset( $instance ) ? $instance : new WeightFactory($cno);
        return $instance;
    }

    /**
     * @return StudentScoreFactory
     */
    public static function getStudentScoreFactory(){
        $instanceName = (string) static::$factoryTypePrefixs['StudentScore'];
        $instance = &static::$factoryInstances[$instanceName];
        $instance = isset( $instance ) ? $instance : new StudentScoreFactory();
        return $instance;
    }

}

//==============================================================
abstract class AbstractScoreWeightFactory{
    protected $weight = 1;//default
    protected $cycle = 5;

    /**
     * weight measuring method
     * override this method to config weight measuring of your own
     * @param String $cno   : class no.
     */
    protected function weightMeasure(&$cno){
        //weight measuring method
        $weight = ( (int)substr($cno, 1, 2 ) )%$this->cycle;
        $weight = (int)( ( $weight == 0 ) ? $this->cycle : $weight );
        $this->weight = $weight;
    }

    /**
     * @param Int $grade   : grade
     */
    public function countWeightedScore( $grade ){
        return $grade*$this->weight;
    }

    public function getWeight(){
        return $this->weight;
    }
}//end class AbstractScoreWeightFactory


final class WeightFactory extends AbstractScoreWeightFactory{
    /**
     * @param String $cno   : class no.
     */
    public function __construct( &$cno ){
        $this->weightMeasure($cno);
    }
}//end class WeightFactory


//====================================================
final class StudentScoreFactory{//no abstract
    //protected $students;

    /**
     * @param Array $studentScoreList   : class no.
     * @return Array
     */
    public function countIndividualWeightedScore(&$studentScoreList){
        $currentWeightFactory = null;
        foreach( $studentScoreList as $index=>&$row){
            $currentWeightFactory = ScoreFactory::getWeightFactory($row['cno']);
            $row['weightedGrade'] = $currentWeightFactory->countWeightedScore( (int) $row['grade'] );
        }
        return $studentScoreList;
    }

    public function countIndividualWeightedSum(&$studentScoreList){

        $studentScoreList = $this->countIndividualWeightedScore($studentScoreList);//whole info
        //var_dump($studentScoreList);
        $studentList = [];//only student info and sum
        $currentStudent = null;
        $currentSum = 0;
        foreach( $studentScoreList as $index=>&$student ){
            $currentStudent = &$studentList[ (string) $student['sno'] ];
            $currentStudent = isset($currentStudent) ? $currentStudent : $this->newStudentSumVO( $student );

            $currentSum = &$currentStudent['sum'];
            $currentSum += $student['weightedGrade'];

            //echo $student['sname'] . ' : ' . $student['grade'];
            //echo ( $currentStudent['sname'] . ' : ' . $currentStudent['sum'] . "\n");

        }

        return $studentList;
    }

    protected function newStudentSumVO( &$student ){
        $studentInfo = [];
        $studentInfo['sno'] = $student['sno'];
        $studentInfo['sname'] = $student['sname'];
        $studentInfo['ssex'] = $student['ssex'];
        $studentInfo['sum'] = 0;

        return $studentInfo;
    }

}//end class StudentScoreFactory