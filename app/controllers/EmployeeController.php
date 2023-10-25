<?php
namespace app\controllers;

use app\functions\Flash;
use app\service\AppointmentService;
use app\service\EmployeeService;
use app\validator\AppointmentValidator;
use Slim\Http\Request;
use Slim\Http\Response;

class EmployeeController extends Controller{

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
        
        $employeeService = new EmployeeService();
        $employees = $employeeService->listEmployee($page);
        $this->view('employee.index', $employees);
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
            $employeeService = new EmployeeService();
            $employeeService->create($data);
            Flash::addMenssagem('Funcionario criado com sucesso!');
            return $response->withRedirect('/');
        } catch (\Exception $e) {
            Flash::addMenssagem($e->getMessage() , 'danger', $e->getCode());
            return $response->withRedirect('/');
        }
    }
}
?>