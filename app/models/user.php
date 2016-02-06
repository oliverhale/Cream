<?php class TableUser extends MysqlConnection {
	var $name='users';
	var $hasOne=array('User');
	var $saveReformating=array(
								'password'=>'get_password_hash',
								'first_name'=>'format_name',
								'middle_name'=>'format_name',
								'last_name'=>'format_name'
								);
	function __construct(){
		
    }
}