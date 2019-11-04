<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once __DIR__ . '/../../../model/User.php';

$app->group('/user', function ($app) {

    $app->get('/{id:[0-9]+}', function (Request $request, Response $response, array $args) {

        $usu = User::getUserById($args['id']);

        if($usu){
            return $response->withJson($usu);
        }else{
            $json = array(
                'error' => 'There is no user with this ID.'
            );
            return $response->withJson($json);
        }
    });

    $app->get('/{email}', function (Request $request, Response $response, array $args) {

        $email = $args['email'];

        $usu = User::getUserByEmail($email);

        if($usu){
            return $response->withJson($usu);
        }else{
            $json = array(
                'error' => 'There is no user with this email.'
            );
            return $response->withJson($json);
        }
    });

    $app->get('', function (Request $request, Response $response, array $args) {

        $users = User::getAllUsers();
        return $response->withJson($users);
    });


    $app->get('/{id:[0-9]+}/availabletests', function (Request $request, Response $response, array $args){

        $id = $args['id'];
        $json = array('availableTests'  => Test::getAvailableTestsForUser($id));
        return $response->withJson($json);

    });
});