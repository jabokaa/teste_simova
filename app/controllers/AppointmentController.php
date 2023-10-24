<?php
namespace app\controllers;

use app\service\AppointmentService;
use Slim\Http\Request;
use Slim\Http\Response;

class AppointmentController extends Controller{

    public function index(Request $request, Response $response, array $args = []): Response {
        $page = $request->getQueryParam("page");
        $idEmployee = $args['idEmployee'];

        $appointmentService = new AppointmentService();
        $appointments = $appointmentService->listAppointments($idEmployee, $page);
        $this->view('appointment.index', $appointments);
        return $response;
    }

    public function create(Request $request, Response $response, array $args = []): Response {
        $appointmentService = new AppointmentService();
        $data = $request->getParsedBody();
        $appointmentService->createApontament($data);
        return $response->withRedirect('/apontamentos/'.$data['id_employee']);
    }

    public function update(Request $request, Response $response, array $args = []): Response {
        $appointmentService = new AppointmentService();
        $idAppointment = $args['id'];
        $appointments = $appointmentService->updateApontament($request, $idAppointment);
        return $response;
    }
}
?>