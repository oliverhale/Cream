<?php 
class App extends Router {
	var $name ='App';
	var $varCount=0;
	var $varPool=array();
    function __construct(){ 
      echo 'running construct';
    }
    public function loadModule(){
    	echo 'yo yo yo';
    }
    public function loadView($controller,$method){
    	$this->_openFile( dirname(dirname(dirname(__FILE__))).'/app/views/'.strtolower($controller).'/'.$method .'.php');
    }
    public function loadElement($name){
    	$this->_openFile( dirname(dirname(dirname(__FILE__))).'/app/views/elements/'.$name.'.php');
    }
    public function loadLayout($name){
    	$this->_openFile(dirname(dirname(dirname(__FILE__))).'/app/views/layouts/'.$name.'.php');
    }
    private function _openFile($file){
    	foreach($this->varPool as $varSet){
    		foreach($varSet as $variableName=>$variableValue){
    			$$variableName=$variableValue;
    		}
    	}
    	require($file);
    }
    public function assign($arr){
    	$this->varPool[$this->varCount]=$arr;
    }
} 
