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
    	if ($this->data){
        //echo 'data posted';
        //var_dump($this->data);
      }
      $t='mr T';
    	$testVar='Another';
      //$this->db->Query("SELECT * FROM `page` ");
      $this->loadModel('page');
      $this->loadModel('website');
      //$this->page->Save();
      $this->page->FindById(1);
      $this->page->FindById(2);
      $this->website->FindById(2);
      $this->html->title='Welcome to CreamPHP';
    	$this->assign(compact("t", "testVar","html"));
    }
}