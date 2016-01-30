<?php class Page extends MysqlConnection {
	var $name='page';
	var $mysqli;
	function __construct($connection){
		$this->mysqli=$connection;
    }
}