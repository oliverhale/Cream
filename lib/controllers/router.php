<?php 
class Router { 
	var $name='Router';
	var $routes=array();
	var $routeCount=0;
	var $routeToController;
    function __construct(){ 
        
    }
	public function addRoute($path,$controller,$method){
		$numberOfVariables=substr_count($path, ':');
		$i=0;
		$start=0;
		$variables=array();
		while($i<$numberOfVariables){
			$start=strpos($path,':',$start);
			$end=strpos($path,'/',$start+1);
			if ($end===FALSE){
				$end=strlen($path);
				
				$slash='';
			}else{
				$slash='/';
			}
			$variableName=substr($path,$start,($end-$start));
			$start=$start+($end-$start);
			$variables[]=str_replace(':','',$variableName);
			$i++;
		}
		$this->routes[$this->routeCount]['path']=$this->_removeEndingSlash($path);
		$this->routes[$this->routeCount]['variables']=$variables;
		$this->routes[$this->routeCount]['controller']=$controller;
		$this->routes[$this->routeCount]['method']=$method;
		$this->routeCount++;
	}
	public function calculateRoute(){
		$url=$this->_removeEndingSlash($_SERVER['REQUEST_URI']);		
		//var_dump($this->routes);
		foreach($this->routes as $route){
			if ($route['path']==$this->_removeVariableValues($url,$route['path']) )  {
				require_once(dirname(dirname(dirname(__FILE__))).'/app/controllers/'.strtolower($route['controller']).'.php');
				$method=$route['method'];
				$controller=$route['controller'];
				$obj = new $controller();
				if (property_exists($controller, 'components')){
					foreach($obj->components as $component){
						$obj->loadComponent($component);
					} 
				}
				/*
				if (property_exists($controller, 'models')){
					foreach($obj->models as $model){
						$obj->loadModel($model);
					} 
				}
				*/
				$this->routeToController=$controller;
				call_user_func_array(array($obj, 'passRoutes'),array($this->routes));
				call_user_func_array(array($obj, $method),$this->_setVariableValues($url,$route));
				$viewFile=dirname(dirname(dirname(__FILE__))).'/app/views/'.strtolower($route['controller']).'/'.$route['method'].'.php';
				if (file_exists($viewFile)){
					// If no headers are sent, send default one
					if (!headers_sent()) {
						header('Content-type: text/html');
						header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
						header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
					}
					$obj->loadLayout('default_header');
					$obj->loadView($route['controller'],$route['method']);
					$obj->loadLayout('default_footer');
					return TRUE;
				}else{
					header("HTTP/1.0 404 Not Found");
					require_once(dirname(dirname(dirname(__FILE__))).'/lib/views/error_404.php');
				}
				break;
			}
		}
		header("HTTP/1.0 404 Not Found");
		require_once(dirname(dirname(dirname(__FILE__))).'/lib/views/error_404.php');
	}
	private function _removeVariableValues($url,$routePath){
		$routeFolders=explode('/',$routePath);
		$urlFolders=explode('/',$url);
		$folderNum=0;
		foreach($routeFolders as $folder){
			if (substr($routeFolders[$folderNum],0,1)==':'){
			$urlFolders[$folderNum]=$routeFolders[$folderNum];
			}
			$folderNum++;
		}
		return implode('/',$urlFolders);
	}
	private function _setVariableValues($url,$route){
		$routeFolders=explode('/',$route['path']);
		$urlFolders=explode('/',$url);
		$folderNum=0;
		$variableNum=0;
		$variables=array();
		foreach($routeFolders as $folder){
			if (substr($routeFolders[$folderNum],0,1)==':'){
				$variables[$route['variables'][$variableNum]]=$urlFolders[$folderNum];
				$variableNum++;
			}
			$folderNum++;
		}
		return $variables;
	}
	private function _removeEndingSlash($str){
		if (strrpos($str,'/')==strlen($str)-1){
			return substr($str,0,strlen($str)-1);
		}else{
			return $str;
		}
	}

	function __destruct() {
	/*
		if ($this->routeToController){
			echo 'here  '.$this->routeToController;
		}
      */ 
   }

} 

$Router = new Router();