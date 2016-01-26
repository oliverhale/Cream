<?php 
class MysqlConnection  {
	
	var $mysqli;

    function __construct(){ 
      $this->Connection();
    }

    public function Connection(){    

        $this->mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB, MYSQL_PORT);
		if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
		}
        $this->mysqli->set_charset('utf8');
    }
    public function Query($sql){  	
    	$res = $this->mysqli->query($sql);
        $data = $res->fetch_assoc();
        return $data;
    }
    
} 
