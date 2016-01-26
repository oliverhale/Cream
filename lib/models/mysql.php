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
    public function Save($data=null){
        if (!$data){
            return false;
        }
        $sql="REPLACE INTO ".$this->name." SET ";
        foreach($data AS $key=>$value){
            $sql.="`".$key."`='".$value."',";
        }
        $sql=substr($sql, 0,strlen($sql)-1);
        $this->Query($sql);
    }
    
} 
