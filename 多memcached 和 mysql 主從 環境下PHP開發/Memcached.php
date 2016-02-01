<?php
/**
 * Created by PhpStorm.
 * User: aris
 * Date: 2014/11/14
 * Time: 下午 1:45
 */

class Memcached
{
    private $mem;
    public $pflag=''; // memcached pconnect tag
    private function memConnect($serkey){
        require 'config.php';
        $server = $memcached;
        $this->mem = new Memcache;
        $link = !$this->pflag ? 'connect' : 'pconnect' ;
        $this->mem->$link($server[$serkey][0],$server[$serkey][1]) or $this->errordie('memcached connect error');

    }

    //$mem->set('en_'.$arr);
    public function set($ser_key,$values,$flag='',$expire=''){
        $this->memConnect($this->tag($ser_key));
        //if($this->mem->set($ser_key,$values,$flag,$expire)) return true;
        if($this->mem->set($ser_key,$values)) return true;
        else return false;
    }

    public function get($ser_key){
        $this->memConnect($this->tag($ser_key));
        if($var=$this->mem->get($ser_key)) return $var;
        else return false;
    }
    private function tag($ser_key){
        $tag=explode('_',$ser_key);
        return $tag[0];
    }
    private function errordie($errmsg){
        die($errmsg);
    }
}
