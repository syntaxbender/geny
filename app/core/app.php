<?php
class App{
    public $instances = [];
    //public $baseRoute = null;
    // function __construct(&$route){
    //     $this->route = $route;
    // }
    function registerRoute($className){
        require_once(ROUTES_DIR."/".mb_strtolower($className).".php");
        $className = $className."Route";
		$class = new ReflectionClass($className);
		$this->instances[$className] = $class->newInstance();
    }
    function getInstance($className){
        return $this->instances[$className];
    }
}
?>