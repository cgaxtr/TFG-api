<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../model/Exception/InvalidTokenException.php';
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;


class JWTUtils
{

    public static function decode($token){

        $jwt = explode(" ", $token);

        if ($jwt[0] != "Bearer" || count($jwt) != 2){
            throw new InvalidTokenException("bad formed token ");
        }

        $payload = null;
        try{
            $payload = JWT::decode($jwt[1], KEY_TOKEN, array('HS256'));
        }catch (UnexpectedValueException | SignatureInvalidException | Exception $e){
            throw new InvalidTokenException("Invalid token value");
        }

        return $payload;
    }

    public static function encode($email){
        $payload = [
            "iss" => "TFG",
            "iat" => time(),
            "sub" => $email
            //"exp" => time() + 15
        ];

        return JWT::encode($payload, KEY_TOKEN);
    }
}