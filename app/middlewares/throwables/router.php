<?php
require_once(I18N_DIR.'/throwables.php');

class RouterException extends LogicException {
    private $context = "ROUTER";
    private $types = [
        "ROUTER_UNKNOWN"=> 9000,
        "PARAM_MISMATCH"=> 9001,
        "ROUTER_MISSING"=> 9002
    ];
    function __construct($type, Throwable $previous = null) {
        if(array_key_exists($type,$this->types)){
            $message = i18nThrowables::ThrowableMessage($this->context, $type);;
            parent::__construct($message, $this->types[$type], $previous);
        }
        parent::__construct("ROUTER_UNKNOWN");
    }
 }
?>

