<?php 
function get_percentage($total, $number)
{
  if ( $total > 0 ) {
   return round($number / ($total / 100),2);
  } else {
    return 0;
  }
}