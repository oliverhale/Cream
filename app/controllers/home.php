<?php
class Home extends App {
  	var $name ='Home';
    var $html;
    function __construct() {
       parent::__construct();

   	}
    function test($pageNum,$limit) {
        //echo 'welcome home pagenum='.$pageNum.' limit='.$limit;

    }
    function homepage(){
    		$t='mr T';
    		$testVar='Another';

       $this->db->Query("SELECT * FROM `page` ");
       $this->loadModel('page');
       $this->page->Save();
       $this->html->title='Welcome to CreamPHP';
    	 $this->assign(compact("t", "testVar","html"));
    }
}