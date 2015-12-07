<?php 
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
$time_start = microtime_float();
include_once("../index.php");
$time_end = microtime_float();
$time = $time_end - $time_start;
echo "Did it in  $time seconds\n";