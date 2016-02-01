<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 2014/10/31
 * Time: 下午 2:28
 */
    header("Content-Type:text/html; charset=utf-8");

    require_once('include_dao.php');
    require_once('MyStudentDAO.php');
    require_once('MyStudentDTO.php');

    $studentDao = new MyStudentDAO();
    var_dump( $studentDao->getStudentClassScore() );//an array