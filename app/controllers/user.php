<?php
class User extends App {
  	var $name ='User';
    var $html;
    function __construct() {
       parent::__construct();

   	}
    function register(){
    	if ($this->data){
        //echo 'data posted';
        //var_dump($this->data);
      }
      $this->html->title='Welcome to CreamPHP';
    	$this->assign(compact("html"));
    }
    function login(){
      if ($this->data){
        //echo 'data posted';
        //var_dump($this->data);
      }
      $this->html->title='Welcome to CreamPHP';
      $this->assign(compact("html"));
    }
    function forgotten_password(){
      if ($this->data){
        //echo 'data posted';
        //var_dump($this->data);
      }
      $this->html->title='Welcome to CreamPHP';
      $this->assign(compact("html"));
    }
    function change_password(){

    }
    function edit(){
      
    }
}