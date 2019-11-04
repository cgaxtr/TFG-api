<?php

use \Firebase\JWT\JWT;
require_once  __DIR__ . '/../model/Exception/InvalidTokenException.php';
require_once __DIR__ . '/../model/JWTUtils.php';

class JWTMiddleware
{

    public function __invoke($request, $response, $next)
    {
        $jwt = $request->getHeader("Authorization");

        try{
            $payload = JWTUtils::decode($jwt[0]);
        }catch (InvalidTokenException $e){

            $json = array(
                'error' => $e->getMessage()
            );

            return $response->withJson($json, 401);
        }

        if($payload){
            return $next($request, $response);
        }
    }
        /*
        $jwt = explode(" ", $jwt[0]);

        if ($jwt[0] != "Bearer" || count($jwt) != 2){
            $json = array(
                'error' => 'Invalid Header'
            );

            return $response->withJson($json, 401);
        }
        try{
            $result = JWT::decode($jwt[1], KEY_TOKEN, array('HS256'));
        }catch (UnexpectedValueException $e){
            $json = array(
                'error' => 'Invalid token'
            );

            return $response->withJson($json, 401);
        }


        //* @throws UnexpectedValueException     Provided JWT was invalid
        //* @throws SignatureInvalidException    Provided JWT was invalid because the signature verification failed
        //* @throws BeforeValidException         Provided JWT is trying to be used before it's eligible as defined by 'nbf'
        //* @throws BeforeValidException         Provided JWT is trying to be used before it's been created as defined by 'iat'
        //* @throws ExpiredException             Provided JWT has since expired, as defined by the 'exp' claim


        if ($result){
            return $next($request, $response);
        }else{
            $json = array(
                'error' => 'Invalid token'
            );
            return $response->withJson($json, 401);
        }
    }
        */
}