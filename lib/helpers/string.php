<?php
function column_string_convert($string){
$words = preg_replace('/(?<!\ )[A-Z]/', ' $0', $string);
return str_replace(' ','_',trim($words));
}