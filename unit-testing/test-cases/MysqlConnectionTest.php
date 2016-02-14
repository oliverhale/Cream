<?php

require_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.'UnitTestUtility.php');
class MysqlConnectionTest extends UnitTestUtility {
	var $name='Mysql Connection Test';
	function __construct(){
		parent::__construct();
		require_once(dirname(dirname(dirname(__FILE__))) . DS.'lib'.DS.'models'.DS.'mysql.php');
		$this->test();
	}
	function test(){
		$te=$undeclarded;	
 		$connection =  new MysqlConnection( MYSQL_HOST,MYSQL_USER,MYSQL_PASSWORD, MYSQL_DB_UNIT_TESTING);
 		if ($connection){
			$GLOBALS['debug']['result']=true;
 		}else{
 			$GLOBALS['debug']['result']=false;
 		}
	}
	function __destruct(){
		parent::__destruct();
	}
}
$test = new MysqlConnectionTest();