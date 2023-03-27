<?php
class JwtException extends LogicException {
    private $types = [
        "JWT_UNKNOWN"=> 7000,
        "JWT_EXPIRED"=> 7001,
        "JWT_DROP"=> 7002,
        "JWT_AUDIENCE_MISMATCH"=> 7003,
        "JWT_ISSUER_MISMATCH"=> 7004,
    ];
    function __construct($type, Throwable $previous = null) {
        if(array_key_exists($type,$this->types)){
            parent::__construct($type, $this->types[$type], $previous);
        }
        parent::__construct("JWT_UNKNOWN");
    }
}
?>