<?php 
class App extends Router {
	var $name ='App';
	var $varCount=0;
	var $varPool=array();
    var $db;
    var $data;
    var $html;
    function __construct(){ 
      require(dirname(dirname(dirname(__FILE__))).'/lib/models/mysql.php');
      $this->db = new MysqlConnection();
      $this->html = new stdClass();
      if (isset($_POST)){
        $this->data= new stdClass();
        foreach($_POST as $key=>$val){
           if (!empty($key) && !empty($val)){ $this->data->$key=$val; }
        }
      }
      require_once( dirname(dirname(dirname(__FILE__))).'/lib/helpers/string.php');
    }
    public function loadModel($model){  	
    	require( dirname(dirname(dirname(__FILE__))).'/app/models/'.strtolower($model).'.php');
        $this->$model= new $model($this->db);
    }
    public function loadView($controller,$method){
    	$this->_openFile( dirname(dirname(dirname(__FILE__))).'/app/views/'.strtolower($controller).'/'.$method .'.php');
    }
    public function loadElement($name){
    	$this->_openFile( dirname(dirname(dirname(__FILE__))).'/app/views/elements/'.$name.'.php');
    }
    public function loadLayout($name){
    	$this->_openFile(dirname(dirname(dirname(__FILE__))).'/app/views/layouts/'.$name.'.php');
    }
    private function _openFile($file){
    	foreach($this->varPool as $varSet){
    		foreach($varSet as $variableName=>$variableValue){
    			$$variableName=$variableValue;
    		}
    	}
    	require($file);
    }
    public function assign($arr){
    	$this->varPool[$this->varCount]=$arr;
    }
     public function link($controller,$method,$parameters=null){
        //var_dump($this->routes);
        foreach($this->routes AS $route){
            echo '['.$route['controller'].'=='.$controller.' && '.$route['method'].'=='.$method.' && '.count($route['variables']).'=='.count($parameters).']';
            if($route['controller']==$controller && $route['method']==$method && count($route['variables'])==count($parameters) ){
                $routeFound=$route;
                break;
            }
        }
        if(!isset($routeFound)){
            return null;
        }else{
            $i=0; $x=0;
            $folders=explode('/',$routeFound['path']);
            foreach($folders as $folder){
                if (substr_count($folder, ':')>1){
                    $folders[$i]=$routeFound['variables'][$x];
                    $x++;
                }
                $i++;
            }
            $path=implode('/',$folders);
            return $path;
        }
    }
} 
