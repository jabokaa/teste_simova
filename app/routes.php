<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;


return function (App $app) {
    
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/apontamentos/{idEmployee}', 'app\controllers\AppointmentController:index');
    $app->post('/apontamentos', 'app\controllers\AppointmentController:create');
    $app->put('/apontamentos/{id}', 'app\controllers\AppointmentController:update');
};
