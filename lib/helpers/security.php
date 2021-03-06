<?php 
function get_password_hash_cost()
{
	$timeTarget = 0.05; // 50 milliseconds 
	$cost = 8;
	do {
    	$cost++;
    	$start = microtime(true);
    	password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    	$end = microtime(true);
	} while (($end - $start) < $timeTarget);
	return $cost;
}
function get_password_hash($password){
	$options = [
	    'cost' => get_password_hash_cost(),
	];
	return password_hash($password, PASSWORD_BCRYPT, $options)."\n";
}