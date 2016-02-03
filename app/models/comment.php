<?php class Comment extends MysqlConnection {
	var $name='Comments';
	var $mysqli;
	var $hasOne=array('User');

	function __construct($connection){
		$this->mysqli=$connection;
    }
}