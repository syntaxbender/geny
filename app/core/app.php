<?php
class App{
    public $instances = [];

    public function registerRoute($className,$constructorParams = []){
        require_once(ROUTES_DIR."/".mb_strtolower($className).".php");
        $className = $className."Router";
		$class = new ReflectionClass($className);
		$this->instances[$className] = $class->newInstance(...$constructorParams);
    }
    public function getInstance($className){
        return $this->instances[$className];
    }
}
?>