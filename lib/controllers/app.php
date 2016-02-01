<?php 
class App extends Router {
	var $name ='App';
	var $varCount=0;
	var $varPool=array();
    var $db;
    var $mem;
    var $data;
    var $html;
    var $routes;
    function __construct(){ 
        require_once( dirname(dirname(dirname(__FILE__))).'/lib/helpers/translation.php');
        require_once( dirname(dirname(dirname(__FILE__))).'/lib/helpers/string.php');
        require_once( dirname(dirname(dirname(__FILE__))).'/lib/helpers/math.php');
        require(dirname(dirname(dirname(__FILE__))).'/lib/models/mysql.php');
        require(dirname(dirname(dirname(__FILE__))).'/lib/models/memcache.php');
        startEvent('Create Mysql Connection');
        $this->db = new MysqlConnection();
        endEvent('Create Mysql Connection');
        $this->mem = new MemcacheConnection();
        
        $this->html = new stdClass();
        if (isset($_POST)){
            $this->data= new stdClass();
            foreach($_POST as $key=>$val){
                if (!empty($key) && !empty($val)){ $this->data->$key=$val; }
            }
        }
    }
    public function loadModel($model){  	
    	require_once( dirname(dirname(dirname(__FILE__))).'/app/models/'.strtolower($model).'.php');
        $this->$model= new $model($this->db);
    }
    public function loadComponent($component){      
        require_once( dirname(dirname(dirname(__FILE__))).'/app/controllers/components/'.strtolower($component).'.php');
        $this->$component= new $component();
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
    public function passRoutes($routes){
        $this->routes=$routes;
    }

    public function link($label,$settings,$attributes=null){
        $controller=$settings['controller'];
        $method=$settings['action'];
        if (isset($settings['parameters'])){ $parameters=$settings['parameters']; }else{  $parameters=array(); }
        foreach($this->routes AS $route){
        //    echo '['.$route['controller'].'=='.$controller.' && '.$route['method'].'=='.$method.' && '.count($route['variables']).'=='.count($parameters).']';
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
            $html='<a href="'.$path.'"';
            if (is_array($attributes)){
                foreach($attributes as $key=>$val){
                    $html.=' '.$key.'="'.$val.'"';
                }
            }
            $html.='>'.$label.'</a>';
            return $html;
        }
    }
} 
