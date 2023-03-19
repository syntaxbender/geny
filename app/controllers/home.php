<?php
class HomeController extends Controller{
    public function index(){
        echo "ok";
        $end_time = microtime(true);
  
        // Calculate script execution time
        $execution_time = ($end_time - START_TIME);
          
        echo " Execution time of script = ".$execution_time." sec";
	    //view::jsonRender(["ok"],200);
    }
}