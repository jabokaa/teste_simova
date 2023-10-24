<?php
namespace app\controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class AppointmentController extends Controller{

    public function index(Request $request, Response $response, array $args = []): Response {
        $appointments = [
            'pageTitle' => 'foooo',
            'total_appointments' => 3,
            'appointments' => [
                [
                    'id' => 1,
                    'seq'=> 1,
                    'create_date' => '2020-01-01 00:00:00',
                    'update_date' => '2020-01-01 00:00:00',
                    'start_date' => '2020-01-01 00:00:00',
                    'total_time' => '600',
                    'id_employe' => '1',
                    'enabled' => 1,
                    'description_work' => 'teste'

                ],
                [
                    'id'=> 2,
                    'seq'=> 2,
                    'create_date' => '2020-01-01 10:00:00',
                    'update_date' => '2020-01-01 10:00:00',
                    'start_date' => '2020-01-01 10:00:00',
                    'total_time' => '300',
                    'id_employe' => '1',
                    'enabled' => 1,
                    'description_work' => 'teste'
                ]
            ]
        ];
        return $this->view('appointment.index', $appointments);
    }

    public function create(Request $request, Response $response, array $args = []): Response {
        $response->getBody()->write('create');
        return $response;
    }

    public function update(Request $request, Response $response, array $args = []): Response {
        $response->getBody()->write('update');
        return $response;
    }
}
?>