<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 9/22/14
 * Time: 12:13 PM
 */
    header("Content-Type:text/html; charset=utf-8");
    echo Casset::js('jquery.min.js');
    //echo Casset::render_js();


    print '----View : ormpractice----<br>print out data only with var_dump : <br><br><br>';

    echo '<pre>';
        /*structure of value object from controller
            '_ormGetAllGuest' = Model_DataTrain::Orm_GetAllGuest(),
            '_ormFindGuest' = Model_DataTrain::Orm_FindGuest('Sunny'),
            '_crudGetAllGoods' = Model_DataTrain::Crud_GetAllGoods(),
            '_crudFindGoods' = Model_DataTrain::Crud_FindGoods( 'Toilet' ),
         */
        print '---使用 ORM 存取客戶基本資料 : 全部房客列表<br>';
        var_dump($_ormGetAllGuest);

        print '<br>';

        print '---使用 ORM 存取客戶基本資料 : 查找單一客戶Sunny<br>';
        var_dump($_ormFindGuest);

        print '<br>';

        print '---使用 model_crud 存取商品基本資料 : 全部商品列表<br>';
        var_dump($_crudGetAllGoods);

        print '<br>';

        print '---使用 model_crud 存取商品基本資料 : 查找單一商品Toilet<br>';
        var_dump($_crudFindGoods);


    echo '</pre>';