<?php
class User extends App {
  	var $name ='User';
    var $html;
    var $models=array('user');
    function __construct() {
       parent::__construct();

   	}
    function register(){
      $this->loadModel('user');
      if ($this->data){
        $cost=get_password_hash_cost();
        //echo 'data posted';
        //var_dump($this->data);
        
        //$data=$this->data->username;
        $this->user->save($this->data);
      }
      $this->html->title='Welcome to CreamPHP';
    	$this->assign(compact("html"));
    }
    function login(){
      if ($this->data){
        if (isset($this->data['email']) && isset($this->data['password'])){ 
          //echo 'data posted';
          if (substr_count($this->data['email'], "@")>1){
            $options['conditions']['email']=$this->data['email'];
          }else{
            $options['conditions']['username']=$this->data['email'];
          }
          $options['conditions']['active']=1;
          //$options['conditions']['paasword']=1;
          if ($user=$this->user->Find('First',$options)){
            
            echo 'credentials Found.';
            var_dump($user);
          }
        }
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