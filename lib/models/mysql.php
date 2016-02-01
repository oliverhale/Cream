<?php 
class MysqlConnection  {
	
	var $mysqli;

    function __construct(){
        return $this->Connection();
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
        if(is_object($res)){
            return  $res->fetch_assoc();
        }
        return null;
    }
    public function Save($data=null){
        if (!$data){
            return false;
        }
        $sql="REPLACE INTO ".$this->name." SET ";
        $set_sql=array();
        foreach($data AS $key=>$value){
            $set_sql[]="`".$key."`='".$value."'";
        }
        if(!isset($data['id'])){
           $set_sql[]="`id`='".createGUID()."'";
        }
        $sql.=implode(",",$set_sql);
        $this->Query($sql);
    }
    public function Find($returnType=null,$settings=null){
        $sql='SELECT ';
        $fields=array();
        if(isset($settings['fields'])){
            foreach($settings['fields'] as $key=>$val){
                if (is_int($key)) { $fields[]=$val.','; }else{ $fields[]=$val.'AS '.$val; }
            }
            $sql.=implode(', ',$fields);
        }else{
            $sql.=' * ';
        }
        $sql.=' FROM '.$this->name.' WHERE ';
        if (isset($settings['conditions'])){
            foreach($settings['conditions'] as $key=>$val){
                if($key!='OR'){
                    $conditions[]=$key."='".$val."'";
                }
            }
            $sql.=" ".implode(' AND ',$conditions)." ";
            if(isset($settings['conditions']['OR'])) {
                foreach($settings['conditions']['OR'] as $key=>$val){
                $or_conditions[]=$key."='".$val."'";
                }
            $sql.=" (".implode(' OR ',$or_conditions).") ";
            }
        }else{
            $sql.='1';
        }
        if(isset($settings['group'])){
            $sql.=' GROUP BY '.implode(',',$settings['group']);
        }
        if(isset($settings['limit'])){
            $sql.=' LIMIT ';   
            foreach($settings['limit'] as $key=>$val){
                $sql.=$key.",".$val;
            }
        }
        if(isset($settings['order'])){
            $sql.=' ORDER BY ';
            foreach($settings['order'] as $key=>$val){
                $group[]=$key.' '.$val;
            }
            $sql.=implode(',',$group);
        }
        echo '['.$sql.']';
        return $this->Query($sql);
    }
    public function __call($name,$arguements)
    {
       if(substr_count($name, 'FindBy')<1){
         return false;
       }
       $column=str_replace('FindBy', '', $name);
       $this->Find('list',array('conditions'=>array(strtolower($column)=>column_string_convert($arguements[0]))));
    }
} 
