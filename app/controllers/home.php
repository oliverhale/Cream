<?php
class Home extends App {
  	var $name ='Home';
    function __construct() {
       parent::__construct();
   	}
    function test($pageNum,$limit) {
        //echo 'welcome home pagenum='.$pageNum.' limit='.$limit;

    }
    function homepage(){
    		echo 'hi';
    		$t='mr T';
    		$testVar='Another';
    	$this->assign(compact("t", "testVar"));
    	//$this->loadmodule();
    }
}