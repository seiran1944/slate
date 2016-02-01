<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 10/8/14
 * Time: 5:13 PM
 */

class BankAccount {
    private $balance = 0;
    private $lowerBounds = 0;

    public function __construct(){

    }

    public function inquery(){
        return $this->balance;
    }

    public function setBalance($dollars){
        $this->balance = $this->checkLowerBound($dollars);
        return $this->balance;
    }

    public function deposit($dollars){
        $this->balance += $this->checkLowerBound($dollars);
        return $this->balance;
    }

    public function withdraw($dollars){
        $this->balance -= $this->checkLowerBound($dollars);
        $this->balance = $this->checkLowerBound($this->balance);
        return $this->balance;
    }

    private function checkLowerBound($dollars){
        return ( $dollars <= $this->lowerBounds) ? 0 : $dollars;
    }
} 