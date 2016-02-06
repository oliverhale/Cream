<?php class Comment extends MysqlConnection {
	var $name='Comments';
	var $hasOne=array('User');

	function __construct(){
		
    }
}