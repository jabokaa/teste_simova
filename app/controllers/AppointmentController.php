<?php
namespace app\controllers;

use app\functions\Flash;
use app\models\Appointment;
use app\models\Employee;
use app\service\AppointmentService;
use app\validator\AppointmentValidator;
use Slim\Http\Request;
use Slim\Http\Response;

class AppointmentController extends Controller{

    /**
     * @var AppointmentService
     */
    private $appointmentService;
    public function __construct() {
        $appointments = new Appointment();
        $employees = new Employee();
        $this->appointmentService = new AppointmentService($appointments, $employees);
    }
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
        $page = $page ? $page : 1;
        $idEmployee = $args['idEmployee'];
        
        $appointments = $this->appointmentService->listAppointments($idEmployee, $page);
        $error = $request->getQueryParam("error");
        if($error) {
            $appointments['error'] = $error;
        }
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
        try{
            $data = $request->getParsedBody();
            AppointmentValidator::create($request);
            $this->appointmentService->createApontament($data);
            Flash::addMenssagem('Apontamento criado com sucesso!');
            return $response->withRedirect('/apontamentos/'.$data['id_employee']);
        } catch (\Exception $e) {
            Flash::addMenssagem($e->getMessage() , 'danger', $e->getCode());
            return $response->withRedirect('/apontamentos/'.$data['id_employee']);
        }
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
        
        $idAppointment = $args['id'];
        $this->appointmentService->updateApontament($requestData, $idAppointment);
        Flash::addMenssagem('Apontamento atualizado com sucesso!');
        return $response;
    }
}
?>