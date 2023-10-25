<?php

namespace app\service;

use app\models\Appointment;
use app\models\Employee;
use Slim\Http\Request;

class EmployeeService {

    private $employee;

    public function __construct() {
        $this->employee = new Employee();
    }

    /**
     * lista os funcionarios
     * @param int $page pagina atual do paginador
     * @return array
     */
    public function listEmployee(int $page): array {
        $employee = $this->employee->all($page);
        $totalEmployee = $this->employee->count();
        $data = [
            'range' => $this->employee->getRange(),
            'total_employee' => $totalEmployee,
            'employees' => $employee,
            'page' => $page,
        ];
        return $data;
    }

    /**
     * cria um funcionarios
     * @param array $requestData
     */
    public function create(array $requestData): void {
        $this->employee->create($requestData);
    }
}