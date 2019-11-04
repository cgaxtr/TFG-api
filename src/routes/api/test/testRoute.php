<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../../../model/Test.php';
require_once __DIR__ . '/../../../model/DTO/ResponseDTO.php';

$app->group('/test', function ($app) {

    $app->get('/{id:[0-9]+}', function (Request $request, Response $response, array $args) {

        $id = $args['id'];

        $test = Test::getTestById($id);

        if($test){
            return $response->withJson($test);
        }else{
            $json = array(
                'error' => 'Invalid id'
            );

            return $response->withJson($json, 404);
        }
    });

    $app->get('/{name}',function (Request $request, Response $response, array $args){

        $name = $args['name'];

        $test = Test::getTestByName($name);

        if($test){
            return $response->withJson($test);
        }else{
            $json = array(
                'error' => 'Invalid id'
            );

            return $response->withJson($json, 404);
        }
    });

    $app->put('', function (Request $request, Response $response){

        $json = json_decode($request->getBody());
        //print_r($json);

        $res = new \Response($json);

        if(Test::uploadResponseTest($res)){
            $json = array('message' => 'test');

           return $response->withJson($json,200);
        }

        $result = array('error' => 'Invalid json content');

        return $response->withJson($result, 400);
    });
});


