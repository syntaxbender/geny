<?php
class HomeRouter extends Router{
    function __construct(){
        $this->get('/home','index');
    }
    public function index(){
        $this->callController("home","index");
    }
}
?>