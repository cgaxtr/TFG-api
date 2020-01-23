<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../../../model/DTO/MeasurementDTO.php';
require_once __DIR__ . '/../../../model/Measurement.php';

$app->group('/measurement', function ($app) {

    $app->get('/heartrate/{id:[0-9]+}', function (Request $request, Response $response, array $args) {

        $user = $args['id'];

        $heartRateMeasures = Measurement::getMeasure($user, "heartrate");

        $json = [
          'measurements' => $heartRateMeasures
        ];
        return $response->withJson($json);
    });

    $app->get('/steps/{id:[0-9]+}', function (Request $request, Response $response, array $args) {

        $user = $args['id'];

        $stepsRateMeasures = Measurement::getMeasure($user, "steps");

        $json = [
            'measurements' => $stepsRateMeasures
        ];
        return $response->withJson($json);
    });

    $app->post('/heartrate', function (Request $request, Response $response, array $args) {

        $json = json_decode($request->getBody());

        $measure = new MeasurementDTO($json->{'idUser'}, "HEARTRATE", $json->{'value'}, $json->{'timestamp'});

        if(Measurement::uploadMeasure($measure)){
            $json = [
                'message' => "Data stored correctly"
            ];
            return $response->withJson($json);
        }else{
            $json = [
                'error' => "Error saving heart rate data"
            ];
            return $response->withJson($json);
        }
    });

    $app->post('/steps', function (Request $request, Response $response) {

        $json = json_decode($request->getBody());

        $measure = new MeasurementDTO($json->{'idUser'}, "STEPS", $json->{'value'}, $json->{'timestamp'});

        if(Measurement::uploadMeasure($measure)){
            $json = [
                'message' => "Data stored correctly"
            ];
            return $response->withJson($json);
        }else{
            $json = [
                'error' => "Error saving heart rate data"
            ];
            return $response->withJson($json);
        }
    });
});
