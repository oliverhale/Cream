<?php 
class MysqlConnection  {
	
	var $mysqli;
    var $contain;
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
        $currentModel=get_class($this);
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
        $sql.=' FROM '.$this->name.' AS '.$currentModel; 
        if (count($this->contain)>0){
            foreach($this->contain  as $foreignModel){
                if (in_array($foreignModel , $this->hasOne)){
                    $this->$foreignModel= new $foreignModel($this->mysqli);
                    $sql.=' LEFT JOIN '.$this->$foreignModel->name.' AS '.$foreignModel.' ON ('.$currentModel.'.id='.$foreignModel.'.'.$this->$foreignModel->foreignKeyName.')'; 
                }
            }
        }
        $sql.=' WHERE ';
        if (isset($settings['conditions'])){
            foreach($settings['conditions'] as $key=>$val){
                if($key!='OR'){
                    if(substr_count($key,'.')<1){ $key=$currentModel.'.'.$key; }
                    $conditions[]=$key."='".$val."'";
                }
            }
            $sql.=" ".implode(' AND ',$conditions)." ";
            if(isset($settings['conditions']['OR'])) {
                foreach($settings['conditions']['OR'] as $key=>$val){
                    if(substr_count($key,'.')<1){ $key=$currentModel.'.'.$key; }
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
        $initial_data=$this->Query($sql);
        if (count($this->contain)>0 && count($initial_data)>0){
            foreach($initial_data as $row){
                $primaryKeyIds[]=$initial_data[$currentModel]['id'];
            }
            foreach($this->contain  as $foreignModel){
                if (in_array($foreignModel , $this->hasOne)){
                    $this->$foreignModel= new $foreignModel($this->mysqli);
                    $foreign_data=$this->$foreignModel->Find('',array('conditions'=>array($foreignModel.'.'.$this->foreignKeyName =>$primaryKeyIds)));
                }
            }    
        }
    }
    public function contain($contain){
        if(is_string($contain)){
            $this->contain=array($contain);
        }else{
            $this->contain=$contain;
        }
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
