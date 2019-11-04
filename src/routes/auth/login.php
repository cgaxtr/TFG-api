<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../../model/User.php';
require_once __DIR__ . '/../../model/JWTUtils.php';

$app->post('/login',function(Request $request, Response $response){
    $data = json_decode($request->getBody());

    $user = User::login($data->{'email'}, $data->{'pass'});

    if($user){
        $json = array(
            'user' => $user,
            'token' => JWTUtils::encode($user->getEmail())
        );

        return $response->withJson($json);
    }else{
        $json = array(
            'error' => 'Invalid username or password.'
        );

        return $response->withJson($json,401);
    }
});
