<?php class TableComment extends MysqlConnection {
	var $name='Comments';
	var $hasOne=array('User');

	function __construct(){
		
    }
}