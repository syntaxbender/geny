<?php
class EnvException extends LogicException {
    private $types = [
        "ENV_UNKNOWN"=> 8000,
        "ENV_FILE_MISSING"=> 8001,
        "ENV_FILE_MISCONFIGURED"=> 8002,
        "VALUE_MISSING"=> 8003,
    ];
    function __construct($type, Throwable $previous = null) {
        if(array_key_exists($type,$this->types)){
            parent::__construct($type, $this->types[$type], $previous);
        }
        parent::__construct("ENV_UNKNOWN");
    }
}
?>