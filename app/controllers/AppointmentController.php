<?php
namespace app\controllers;

use app\service\AppointmentService;
use Slim\Http\Request;
use Slim\Http\Response;

class AppointmentController extends Controller{

    public function index(Request $request, Response $response, array $args = []): Response {
        $page = $request->getQueryParam("page");
        $appointmentService = new AppointmentService();
        
        $idEmployee = $args['idEmployee'];
        $appointments = $appointmentService->listAppointments($idEmployee, $page);
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