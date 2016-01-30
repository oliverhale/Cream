<?php
if (DEBUG){
	$total_time = $time_end - $time_start;
	echo "Did it in  ".$total_time." seconds\n";
	echo '<ul>';
	if(isset($GLOBALS['debug']['timer']['start'])){
		foreach($GLOBALS['debug']['timer']['start'] as  $event_name=>$val){
			$taken=$GLOBALS['debug']['timer']['end'][$event_name]-$GLOBALS['debug']['timer']['start'][$event_name];
			echo '<li>'.$event_name.' took '.$taken.' seconds, '.get_percentage($total_time, $taken).'% of overall time. </li>'; 
		}
	}
	echo '</ul>';
}