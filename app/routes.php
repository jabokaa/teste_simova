<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;


return function (App $app) {

    $app->get('/', 'app\controllers\EmployeeController:index');
    $app->get('/apontamentos/{idEmployee}', 'app\controllers\AppointmentController:index');
    $app->post('/employee', 'app\controllers\EmployeeController:create');
    $app->post('/apontamentos', 'app\controllers\AppointmentController:create');
    $app->put('/apontamentos/{id}', 'app\controllers\AppointmentController:update');
};
