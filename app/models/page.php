<?php class TablePage extends MysqlConnection {
	var $name='pages';
	var $hasOne=array('Website');
	var $hasMany=array('Comment');
	var $foreignKeyName='page_id';
	function __construct(){
		
    }
}