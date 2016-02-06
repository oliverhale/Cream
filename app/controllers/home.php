<?php
class Home extends App {
  	var $name ='Home';
    var $html;
    var $components=array('email');
    var $models=array('website','page');
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
      //__('test');
      //$this->db->Query("SELECT * FROM `page` ");
      $this->loadModel('page');
      //$this->loadModel('website');
      $data['path']='/test/';
      $data['browser_title']='/test/';
      $data['meta_description']='/test/';
      $data['meta_keywords']='/test/';
      $data['content']='/test/';
      $data['website_id']='/test/';

     // $this->page->Save($data);
      $this->page->contain(array('Website','Comment'));
     var_dump( $this->page->FindById(2));
      $this->html->title='Welcome to CreamPHP';
    	$this->assign(compact("t", "testVar","html"));
    }
}