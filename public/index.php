<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/middleware/JWTMiddleware.php';

$app = new \Slim\App;


$app->get('/test', function (Request $request, Response $response, array $args) {
    $json = array(
        'test' => 'prueba'
    );

    return $response->withJson($json);
})->add(new JWTMiddleware());


$app->group('/api', function () use ($app) {

    // Ruta para gestionar usuarios
    require __DIR__ . '/../src/routes/api/user/userRoute.php';

    //Ruta para gestionar test
    require __DIR__ . '/../src/routes/api/test/testRoute.php';

    //Ruta para manejar las mediciones
    require __DIR__ . '/../src/routes/api/measurements/measurements.php';

});

$app->group('/auth', function () use ($app) {

    // Ruta para hacer login
    require __DIR__ . '/../src/routes/auth/login.php';

    //Ruta para registro
    require  __DIR__ . '/../src/routes/auth/register.php';

});

$app->run();