<?php class Page extends MysqlConnection {
	var $name='pages';
	var $mysqli;
	var $hasOne=array('Website');

	function __construct($connection){
		$this->mysqli=$connection;
    }
}