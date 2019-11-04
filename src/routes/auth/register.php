<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once __DIR__ . '/../../model/User.php';

$app->post('/register',function(Request $request, Response $response){

    $json = json_decode($request->getBody());
    $user = new UserDTO(null, $json->{'role'}, $json->{'name'}, $json->{'surname'}, $json->{'email'}, $json->{'birthdate'}, $json->{'pass'});

    $json = null;
    $code = 200;

    $id = User::register($user);
    if($id != 0){
        $user->setId($id);
        $json = array(
            'user' => $user,
            'token' => JWTUtils::encode($user->getEmail())
        );
    }else{
        $json = array(
            'error' => 'The user alredy exists'
        );
        $code = 409;
    }

    return $response->withJson($json, $code);
});