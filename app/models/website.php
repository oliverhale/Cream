<?php class Website extends MysqlConnection {
	var $name='website';
	function __construct($connection){ 
    	$this->mysqli=$connection;
    }
}