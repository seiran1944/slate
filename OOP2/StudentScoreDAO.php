<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 2014/11/6
 * Time: 上午 11:30
 */
include('include_dao.php');

class StudentScoreDAO {

    public function getStudentScoreAll(){
        //new sql line
        $sql = 'SELECT sc.sno , student.sname , student.ssex , sc.cno , sc.grade FROM sc INNER JOIN student ON sc.sno=student.sno';
        $sqlQuery = new SqlQuery($sql);
        return $$this->getStudentScoreList($sqlQuery);

    }

    //new method
    protected function getStudentScoreList($sqlQuery){
        $tab = QueryExecutor::execute($sqlQuery);
        return $tab;
    }

}