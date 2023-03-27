<?php
class Jwt{
    private $secret = null;
    private $issuer = null;
    private $audience = null;
    private $defaultPayload = null;
    private $header = null;
    private $payload = null;
    function __construct($secret,$issuer,$audience){
        $this->secret = $secret;
        $this->issuer = $issuer;
        $this->audience = $audience;
        $this->defaultPayload = [
            'iss'=>$issuer,
            'aud'=>$audience,
            'iat'=>time()
        ];
    }
    private function generatePayload($subject,$expiration,$notBefore=null,$jwtId=null,$additional){
        $this->header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];
        $sub = $subject;
        $exp = $expiration;
        $nbf = ($notBefore == null)? time() : $notBefore;
        $jti = ($jwtId == null)? uniqid() : $jwtId;
        $this->payload = [
            ...$this->defaultPayload,
            'sub' => $sub,
            'exp' => $exp,
            'nbf' => $nbf,
            'jti' => $jti,
            ...$additional
        ];
    }
    private function base64urlEncode($data){
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
    public function signHmac($subject,$expiration,$notBefore=null,$jwtId=null,$additional){
        $this->generatePayload($subject,$expiration,$notBefore,$jwtId,$additional);
        $header = $this->base64urlEncode(json_encode($this->header));
        $payload = $this->base64urlEncode(json_encode($this->payload));
        $jwt = $header.'.'.$payload;
        $signature = $this->base64urlEncode(hash_hmac('sha512', $jwt, $this->secret, true));
        return $jwt.'.'.$signature;
    }
    // public function verify($token){
    //     switch ($favcolor) {
    //         case "red":
    //             echo "Your favorite color is red!";
    //             break;
    //         case "blue":
    //             echo "Your favorite color is blue!";
    //             break;
    //         case "green":
    //             echo "Your favorite color is green!";
    //             break;
    //         default:
    //             echo "Your favorite color is neither red, blue, nor green!";
    //     }
    // }
    private function verifyHmac(){

    }
}
?>