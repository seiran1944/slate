<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 9/19/14
 * Time: 11:13 AM
 */
use DbModel\Model_DataTrain;

class Controller_ormpractice extends Controller {
    public function action_orm()
    {
        $_valueObject = array(
                            '_ormGetAllGuest' => Model_DataTrain::Orm_GetAllGuest(),
                            '_ormFindGuest' => Model_DataTrain::Orm_FindGuest('Sunny'),
                            '_crudGetAllGoods' => Model_DataTrain::Crud_GetAllGoods(),
                            '_crudFindGoods' => Model_DataTrain::Crud_FindGoods('Toilet')
                        );

        return Response::forge( View::forge('ormpractice' , $_valueObject ) ) ;
    }
}