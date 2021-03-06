<?php 
class MysqlConnection  {
	//var $mysqli;
    var $contain;
    var $tableStructure;
    var $currentModel;
    var $Link;
    var $stat;
    var $modelCallBacks=array(
                            'beforeFind',
                            'AfterFind',
                            'beforeValidate',
                            'afterValidate',
                            'beforeSave',
                            'afterSave',
                            'beforeDelete',
                            'afterDelete',
                            );
    var $TablePrimaryKey;
    function __construct(){
       $this->Connection();
    }

    public function Connection($mysql_host=MYSQL_HOST,$mysql_user=MYSQL_USER,$mysql_password=MYSQL_PASSWORD, $mysql_db=MYSQL_DB, $mysql_port=MYSQL_PORT){
        if(!isset($GLOBALS['connection']) && empty($GLOBALS['connection'])){
            $GLOBALS['connection']=mysqli_connect($mysql_host, $mysql_user,$mysql_password, $mysql_db, $mysql_port);
    		if (!$GLOBALS['connection']) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                return false;
            }
            $this->ConnnectionStat();
            mysqli_set_charset( $GLOBALS['connection'],  MYSQL_CHAR_SET );
        }   
        return true;
    }
    public function ConnnectionStat(){
        $this->stat=mysqli_get_connection_stats($GLOBALS['connection']);
    }
    
    public function q($sql){
    	$res=mysqli_query($GLOBALS['connection'],$sql);
        if(is_object($res)){
            $data= $this->fetch($res);    
            mysqli_free_result($res);
        return $data;
        }    
    }
    public function fetch($res){
        $rows=array();
        while($data= mysqli_fetch_assoc($res)){
            $rows[]=$data;
        }
        return $rows;
    }
    public function Save($data=null){
        if (!$data){
            return false;
        }
        $sql="REPLACE INTO ".$this->name." SET ";
        $set_sql=array();
        $columns=$this->getTableStructure();
        foreach($columns as $column){
            $availableColumns[$column['Field']]=1;
            if($column['Key']=='PRI'){ $primaryKey=$column['Field']; }
        }
        foreach($data AS $key=>$value){
            if (isset($availableColumns[$key])){
                $set_sql[]="`".$key."`='".$this->SaveReformating($key,$value)."'";
            }
        }
        if(!isset($data[$primaryKey])){
           $set_sql[]="`".$primaryKey."`='".createGUID()."'";
        }
        $sql.=implode(",",$set_sql);
        echo $sql;
        $this->Query($sql);
    }
    public function Find($returnType=null,$settings=null){
        $this->currentModel=substr(get_class($this),strlen('Table'));
        if (empty($this->tableStructure)){
            $this->tableStructure=$this->getTableStructure(); 
        }
        foreach($this->tableStructure as $row){
            if ($row['key']){  $table_primary_key_column; }
        }
        $sql='SELECT ';
        $fields=array();
        if(isset($settings['fields'])){
            foreach($settings['fields'] as $key=>$val){
                if (is_int($key)) { $fields[]=$val.','; }else{ $fields[]=$val.' AS '.$val; }
            }
            $sql.=implode(', ',$fields);
        }else{
            if (is_array($this->tableStructure)){
                foreach($this->tableStructure as $column){
                    $columns[]=$this->currentModel.'.'.$column['Field'].' AS '.$this->currentModel.'_'.$column['Field'];
                }
            }
            if (count($this->contain)>0){
                foreach($this->contain  as $foreignModel){
                    if (in_array($foreignModel , $this->hasOne)){
                        require_once( dirname(dirname(dirname(__FILE__))).'/app/models/'.strtolower($foreignModel).'.php');
                        $className='Table'.$foreignModel;
                        $this->$foreignModel= new $className();
                        $allColumns=$this->getTableStructure($this->$foreignModel->name);
                        foreach($allColumns as $column){
                            $columns[]=$foreignModel.'.'.$column['Field'].' AS '.$foreignModel.'_'.$column['Field'];
                        }
                    }
                }
            }    
        }
        $sql.=implode(',',$columns);
        $sql.=' FROM '.$this->name.' AS '.$this->currentModel; 
        if (count($this->contain)>0){
            foreach($this->contain  as $foreignModel){
                if (in_array($foreignModel , $this->hasOne)){
                    require_once( dirname(dirname(dirname(__FILE__))).'/app/models/'.strtolower($foreignModel).'.php');
                    $className='Table'.$foreignModel;
                    $this->$foreignModel= new $className();
                    $sql.=' LEFT JOIN '.$this->$foreignModel->name.' AS '.$foreignModel.' ON ('.$this->currentModel.'.'.$this->$foreignModel->foreignKeyName.'='.$foreignModel.'.id)'; 
                }
            }
        }
        $sql.=' WHERE ';
        if (isset($settings['conditions'])){
            foreach($settings['conditions'] as $key=>$val){
                if($key!='OR'){
                    if(substr_count($key,'.')<1){ $key=$this->currentModel.'.'.$key; }
                    if (is_string($val)){
                        $conditions[]=$key."='".$val."'";
                    }else{
                        if (count($val)>1){
                            $conditions[]=$key." IN ('".implode("','",$val)."')";
                        }else{
                          $conditions[]=$key."='".$val[0]."'";  
                        }
                    }
                }
            }
            $sql.=" ".implode(' AND ',$conditions)." ";
            if(isset($settings['conditions']['OR'])) {
                foreach($settings['conditions']['OR'] as $key=>$val){
                    if(substr_count($key,'.')<1){ $key=$this->currentModel.'.'.$key; }
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
        if ($sql=$this->modelCallBack('beforeFind',$sql)){
            return $sql;
        }else{
            return false;
        }
        $initial_data=$this->q($sql);
        
        $initial_data=$this->convertColumns($initial_data);
        if (count($this->contain)>0 && !empty($initial_data) && property_exists(get_class($this),'hasMany')){
            $i=0;
            foreach($initial_data as $row){
                $primaryKeyIds[]=$row[$this->currentModel]['id'];
                $rowPos[$row[$this->currentModel]['id']]=$i;
                $i++;
            }
            foreach($this->contain  as $foreignModel){
                if (in_array($foreignModel , $this->hasMany)){
                    require_once( dirname(dirname(dirname(__FILE__))).'/app/models/'.strtolower($foreignModel).'.php');
                    $className='Table'.$foreignModel;
                    $this->$foreignModel= new $className();
                    $foreign_data=$this->$foreignModel->Find('',array('conditions'=>array($foreignModel.'.'.$this->foreignKeyName =>$primaryKeyIds)));
                    if($foreign_data){
                        foreach($foreign_data as $row){
                            $rowPosition=$rowPos[$row[$foreignModel][$this->foreignKeyName]];
                            if (!isset($initial_data[$rowPosition][$foreignModel])){
                                $total=0;
                            }else{ 
                                $total=count($initial_data[$rowPosition][$foreignModel]);
                            }
                            $initial_data[$rowPosition][$foreignModel][$total]=$row[$foreignModel];
                        }
                    }
                }
            }    
        }
        //afterFind(array $results, boolean $primary = false)
        if ($sql=$this->modelCallBack('afterFind',$initial_data,$primary_used)){
            
        }
        $data=$initial_data;
        return $data; 
    }
    public function convertColumns($convertColumns){
        if (empty($convertColumns)){ return null; }
        foreach($convertColumns as $rowNum=>$val){
            foreach($convertColumns[$rowNum]  as $column=>$value){
                $model=substr($column,0,strpos($column,"_"));
                $actualColumn=substr($column,strpos($column,"_")+1);
                $newArray[$rowNum][$model][$actualColumn]=$value;
                unset($convertColumns[$rowNum][$column]);
            }
        }
        return $newArray;
    }
    public function getTableStructure($table=null){
        if (is_null($table)){
         $table=$this->name;   
        }
        $sql='SHOW COLUMNS FROM '.$table;
        $this->tableStructure= $this->q($sql);
    }
    public function getTablePrimaryKey($table=null){
        if (empty($this->tableStructure)){
            $this->tableStructure=$this->getTableStructure($table);
        }
        foreach($columns as $column){
            $availableColumns[$column['Field']]=1;
            if($column['Key']=='PRI'){ $primaryKey=$column['Field']; }
        }
        
    }
    public function contain($contain){
        if(is_string($contain)){
            $this->contain=array($contain);
        }else{
            $this->contain=$contain;
        }
    }
    public function modelCallBack($methodName,$data_a){
        if(in_array($methodName, $this->modelCallBacks)){
           // modelCallBack('beforeFind'
            if (method_exists( get_class($this) , $methodName )){
                if($methodName=='beforeFind'){
                    $sql= $this->function($data_a);
                    return $value;
                }
            }else{
                if($methodName=='beforeFind'){
                    return $data_a;
                }
            }
        }else{
            echo 'Unknown Model '.$methodName.' Callback.';
            return $false;
        }
    }
    public function SaveReformating($column,$value){
        if (isset($this->saveReformating[$column])){
            $function=$this->saveReformating[$column];
            if (method_exists( get_class($this) , $function )){
                $value= $this->function($value);
            }else if(function_exists( $function )){
                $value=$function($value);
            }
        }
        return $value;
    }
    public function __call($name,$arguements)
    {
        if(substr_count($name, 'FindBy')>0){
            $column=str_replace('FindBy', '', $name);
            return $this->Find('list',array('conditions'=>array(strtolower($column)=>column_string_convert($arguements[0]))));
        }else if(substr_count($name, 'get')>0){
            return $this->Find('list',array('conditions'=>array(strtolower($column)=>column_string_convert($arguements[0]))));
        }
    }
} 
