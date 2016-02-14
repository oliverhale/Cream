<?php
require_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."conf".DIRECTORY_SEPARATOR."conf.php");
require_once(dirname(dirname(dirname(__FILE__))).DS.'lib'.DS.'helpers'.DS.'debug.php'); 
Class UnitTestUtility {
		var $startTime=0;
	function __construct(){
		startEvent('UnitTest');
	}
	function __destruct(){
		$GLOBALS['debug']['details']['name']=$this->name;
		$GLOBALS['debug']['details']['category']=$this->category;
		endEvent('UnitTest');
		echo json_encode($GLOBALS['debug']);
	}
}
function handleError($errno, $errstr,$error_file,$error_line) {
      $GLOBALS['debug']['errors'][$errno][]=$errstr.' - '.$error_file.' line: '.$error_line;
      /*
      echo "<b>Error:</b> [$errno] $errstr - $error_file:$error_line";
      echo "<br />";
      echo "Terminating PHP Script";
      die();
      */
}
set_error_handler('handleError');