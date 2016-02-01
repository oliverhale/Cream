<?php
class MemcacheConnection  {
	var $mem;
    function __construct(){
  	    // return $this->Connection();
    }
    public function Connection(){ 
    	$this->mem = new Memcache;
		$this->mem->connect(MEMCACHE_HOST, MEMCACHE_PORT);
    }
}