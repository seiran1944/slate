<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 2014/10/31
 * Time: 下午 2:56
 */
include('include_dao.php');

class MyStudentDAO extends StudentMySqlDAO{

    //new method for looking into cross-table data  in SQL
    public function getStudentClassScore(){
        //new sql line
        $sql = 'SELECT student.sno , student.sname , class.cname , score.score FROM student,score,class';
        $sqlQuery = new SqlQuery($sql);
        $scoreList = $this->getStudentClassScoreList($sqlQuery);

        return $scoreList;
    }

    //new method
    protected function readStudentClassScoreRow($row){
        $student = [];//new MyStudentDTO();//this DTO has no required
        $student->sno = $row['sno'];
        $student->sname = $row['sname'];
        $student->cname = $row['cname'];
        $student->score = $row['score'];

        return $student;
    }

    //new method
    protected function getStudentClassScoreList($sqlQuery){
        $tab = QueryExecutor::execute($sqlQuery);
        $ret = array();
        for($i=0; $i<count($tab); $i++){
            $ret[$i] = $this->readStudentClassScoreRow($tab[$i]);
        }
        return $ret;
    }
}
