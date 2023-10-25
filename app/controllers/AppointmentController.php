<?php
namespace app\controllers;

use app\service\AppointmentService;
use Slim\Http\Request;
use Slim\Http\Response;

class AppointmentController extends Controller{

    /**
     * lista os apontamentos de um funcionario
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * 
     */
    public function index(Request $request, Response $response, array $args = []): Response {
        $page = $request->getQueryParam("page");
        $page = $page ? $page : 0;
        $idEmployee = $args['idEmployee'];

        $appointmentService = new AppointmentService();
        $appointments = $appointmentService->listAppointments($idEmployee, $page);
        $this->view('appointment.index', $appointments);
        return $response;
    }

    /**
     * Cria um novo apontamento
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * 
     */
    public function create(Request $request, Response $response, array $args = []): Response {
        $appointmentService = new AppointmentService();
        $data = $request->getParsedBody();
        $appointmentService->createApontament($data);
        return $response->withRedirect('/apontamentos/'.$data['id_employee']);
    }

    /**
     * Atualiza um apontamento
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * 
     */
    public function update(Request $request, Response $response, array $args = []): Response {
        $requestData = $request->getParsedBody();
        $appointmentService = new AppointmentService();
        $idAppointment = $args['id'];
        $appointmentService->updateApontament($requestData, $idAppointment);
        return $response;
    }
}
?>