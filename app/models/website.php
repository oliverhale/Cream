<?php class Website extends MysqlConnection {
	var $name='websites';
	var $hasMany=array('Page');
	var $foreignKeyName='website_id';
	function __construct(){ 
    }
}