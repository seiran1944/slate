<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 10/13/14
 * Time: 1:39 PM
 */
require_once(__DIR__ . '/../BankAccount.php');

class BankAccountTest extends PHPUnit_Framework_TestCase {
    public $account;

    protected function setUp(){
        $this->account = new BankAccount();
    }

    public function testInquery(){
        $this->assertEquals( 0 , $this->account->inquery() );
    }

    public function testSetBalance(){
        $simDollors = 100;
        $this->assertEquals( $simDollors , $this->account->setBalance($simDollors) );
    }

    public function testDeposit(){
        $deposit = 10;
        $newBalance = $this->account->inquery() + $deposit;
        $this->assertEquals( $newBalance , $this->account->deposit($deposit) );
    }

    public function testWithdraw(){
        $withdraw = 5;
        $oriValue = $this->account->inquery() - $withdraw;
        $newBalance = $oriValue > 0 ? $oriValue : 0;
        $this->assertEquals( $newBalance , $this->account->withdraw($withdraw) );
    }


}
 