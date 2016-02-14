<?php 
class UnitTestingClient  {
	function __construct(){
       require_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."app".DIRECTORY_SEPARATOR."conf".DIRECTORY_SEPARATOR."conf.php");
	   require_once(dirname(dirname(dirname(__FILE__))).DS."lib".DS."controllers".DS."components".DS."mycurl.php");
	   require_once(dirname(dirname(dirname(__FILE__))).DS."lib".DS."helpers".DS."string.php");
       $this->processUnitTests();
    }
    function processUnitTests(){
    	$i=0;
    	$rows=array();
    	foreach($this->_getUnitTestList() as $file){
    		$result=json_decode($this->_runUnitTest($file));
    		$rows[$i]['num']=$i;
    		$rows[$i]['name']=$result->details->name;
    		$rows[$i]['category']=$result->details->category;
    		$rows[$i]['process_time']=$result->timer->end->UnitTest-$result->timer->start->UnitTest;
    		$rows[$i]['result']=$result->result;
    		$rows[$i]['error_count']=$this->_getErrorCount($result->errors);
    		$i++;	
    	}
    	require_once(dirname(dirname(__FILE__)).DS.'views'.DS.'resultTable.php');	
    }
    private function _getErrorCount($errors){
 		$total=0;
    	if(!empty($errors)){
	    	foreach ($errors as $type=>$val){
	    		foreach($errors->$type as $errorList){
	 				$total=$total+count($errorList);
	   			}
	   		}
	  		return $total;
  		}else{
  			return null;
  		} 	
    }
    private function _getUnitTestList(){
    	$dir=dirname(dirname(__FILE__)).DS."test-cases".DS;
		if (is_dir($dir)){
		  	$files=array();
		  	if ($dh = opendir($dir)){
		    	while (($file = readdir($dh)) !== false){
					if ($file!='..' && $file!='.'){
						$files[]=$file;			
		    		}
		    	}
		    	closedir($dh);
			}  
			return $files;
		}else{
			return null;
		}
    }
    private function _runUnitTest($file){
    	$url='http://'.$_SERVER['HTTP_HOST']."/test-cases/".$file;
		$mycurl = new mycurl($url);
		$mycurl->createCurl($url);
		return $mycurl->__toString();
    }
}