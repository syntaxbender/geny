<?php
class Route{
    private $instances = [];
    private function validateMethod($type){
        return $_SERVER["REQUEST_METHOD"] === $type; 
    }
	private function pathResolve(){
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
        $requestUri = $this->pathResolve();
        $condition = preg_match('#^'.$path.'$#', $requestUri, $parameters);
		unset($parameters[0]);
        return ($condition)? $parameters : false;
    }
    private function bindParams($parameters, $paramKeys){
        if(count($parameters) != count($paramKeys)) throw new Error("PARAM_MISMATCH");
        $parameters = array_combine($paramKeys,$parameters);
        return $parameters;
    }
    private function callRouter($routerMethod,$params){ // like singleton pattern
        $router = explode('@',$routerMethod);
        $routerFile = ROUTES_DIR.'/'.strtolower($router[0]).'.php';
        if(!file_exists($routerFile)) throw new Error("ROUTER_MISSING");
        require_once $routerFile;
        if(!in_array($router[0],$this->instances)){
            $class  = new ReflectionClass($router[0]);
            $instance = $class->newInstanceArgs();
            $this->instances[$router[0]] = $instance;
        }else{
            $this->instances[$router[0]]->{$router[1]}($params);
        }
        exit();
    }
    public function get($path, $routerMethod, $paramKeys = []){
        if($this->validateMethod("GET")){ //method validation
            $validation = $this->validatePathReturnParams($path); //path validation
            if($validation){ 
                if(count($paramKeys)>0)
                    $params = $this->bindParams($validation,$paramKeys); // param(count) validation
                $this->callRouter($routerMethod,$params);         
            }
        }
    }
    public function post(){
        return $this;
    }
}
?>