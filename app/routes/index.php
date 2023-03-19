<?php
require_once CORE_DIR."/app.php";
class IndexRoute extends Route{
    function __construct(){
        $this->route->get('/','index@test');
    }
    public function test(){
        echo "ok";
    }
    public function test2(){
        $asd = "test";
        $asd = ;
    }
}
?>