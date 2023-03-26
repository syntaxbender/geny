<?php
require_once(THROWABLES_DIR.'/router.php');
class Router{
    private function validateMethod($type){
        return $_SERVER["REQUEST_METHOD"] === $type; 
    }
    /*
    iyileştirsek iyi olabilir gibi
    */
	private function pathResolver(){
		$scriptname = $_SERVER['SCRIPT_NAME'];
		$dirname = dirname($scriptname);
		$request_uri = parse_url($_SERVER['REQUEST_URI']);
		$request_uri = preg_replace('/^('.preg_quote($scriptname,'/').')|^('.preg_quote($dirname."/",'/').')/', '/', preg_replace('/\/+/','/',$request_uri['path']));
		return $request_uri;
	}
    /*
    Tehlikeli görünüyor fakat $path kısmını kod içerisinde hardcoded olarak veriyoruz. $requestUri ise normal düz regex kontrolüne tabii tutuluyor. Bir şekilde regex pattern'i manipüle edilse bile ancak ve ancak gidilebilecek nokta routing içerisinde tanımlı başka bir controller'a erişmek olur. 
    */
    private function validatePathReturnParams($path){
        $requestUri = $this->pathResolver();
        $condition = preg_match('#^'.$path.'$#', $requestUri, $parameters);
		unset($parameters[0]);
        return ($condition)? $parameters : false;
    }
    private function bindParams($parameters, $paramKeys){
        if(count($parameters) != count($paramKeys)) throw new RouterException("PARAM_MISMATCH");
        $parameters = array_combine($paramKeys,$parameters);
        return $parameters;
    }
    private function callRouter($routerMethod,$params){ 
        $this->{$routerMethod}(...$params);
    }
    public function callController($className,$method,$constuctorParams=[],$params=[]){ // like singleton pattern
        $routerFile = CONTROLLERS_DIR.'/'.strtolower($className).'.php';
        if(!file_exists($routerFile)) throw new RouterException("ROUTER_MISSING");
        require_once $routerFile;
        $className = $className."Controller";
        $class  = new ReflectionClass($className);
        $instance = $class->newInstanceArgs($constuctorParams);
		$instance->{$method}($params);
        exit();
    }
    private function methodResolver($method,$path,$routerMethod, $paramKeys){
        if($this->validateMethod($method)){ //method validation
            $validation = $this->validatePathReturnParams($path); //path validation
            if($validation !== false){ 
                $params = [];
                if(count($paramKeys)>0)
                    $params = $this->bindParams($validation,$paramKeys); // param(count) validation
                $this->callRouter($routerMethod,$params);         
            }
        }
    }
    public function get($path, $routerMethod, $paramKeys = []){
        $this->methodResolver("GET",$path, $routerMethod, $paramKeys);
    }
    public function post($path, $routerMethod, $paramKeys = []){
        $this->methodResolver("POST",$path, $routerMethod, $paramKeys);
    }
}
?>