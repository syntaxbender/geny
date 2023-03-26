<?php
require_once('./envexception.php');
class Environment{
    protected $parsedEnv = null;
    protected $rawFile = null;
    function __construct($filePath){
        $rawFile = $this->setFile($filePath);
        $this->parse();
    }
    private function setFile($filePath){
        $envFile = fopen($filePath, "r") or throw new EnvException('ENV_FILE_MISSING');
        $rawFile = fread($envFile,filesize($filePath));
        fclose($envFile);
        $this->rawFile = $rawFile;
    }
    private function parse(){
        try{
            $this->parsedEnv = json_decode($this->rawFile,false,JSON_THROW_ON_ERROR);
        }catch(JsonException $e){
            throw new EnvException('ENV_FILE_MISCONFIGURED');
        }
    } 
    public function getVal($val,$throwable=false){
        if(array_key_exists($val,$this->parsedEnv)){
            return $this->parsedEnv[$val];
        }else{
            return ($throwable)? new EnvException('VALUE_MISSING') : false;
        }
    }
}