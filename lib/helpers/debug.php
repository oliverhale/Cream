<?php
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
function startEvent($event_name){
	if (!DEBUG){
		return false;
	}
	if (isset($GLOBALS['debug']['timer']['start'][$event_name])){
		$event_name=createNewEventName($event_name,$start);		
	}
	$GLOBALS['debug']['timer']['start'][$event_name]=microtime_float();
}
function endEvent($event_name){
	if (!DEBUG){
		return false;
	}
	if (isset($GLOBALS['debug']['timer']['end'][$event_name])){
		$event_name=createNewEventName($event_name,$start);		
	}
	$GLOBALS['debug']['timer']['end'][$event_name]=microtime_float();
}
function createNewEventName($event_name,$part){
	while(!$new_event_name){
		$try=$event_name." (".$i.')';
		if (!isset($GLOBALS['debug']['timer'][$part][$try])){
			return $try; 
		}
		$i++;
	}
}