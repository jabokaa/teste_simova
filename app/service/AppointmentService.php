<?php

namespace app\service;

use app\models\Appointment;
use app\models\Employee;
use Slim\Http\Request;

class AppointmentService {

    private $appointment;
    private $employee;

    public function __construct() {
        $this->appointment = new Appointment();
        $this->employee = new Employee();
    }

    public function listAppointments($idEmplado, $page) {
        $page = $page ? $page : 0; 
        $employeeData = $this->employee->find($idEmplado);
        if(empty($employeeData)) {
            throw new \Exception('Employee not found');
        }

        $filter = [
            'id_employee' => $idEmplado,
            'enabled' => '1'
        ];
        $appointments = $this->appointment->where($filter, $page, 'start_date DESC');
        $appointments = $this->dataFromater($appointments);
        $totalAppointed = $this->appointment->count($filter);
        $data = [
            'employee' => $employeeData,
            'range' => $this->appointment->gerRange(),
            'total_appointments' => $totalAppointed,
            'appointments' => $appointments,
            'page' => $page,
        ];
        return $data;
    }

    private function dataFromater(array $appointments) {
        foreach ($appointments as &$appointment) {
            $appointment['create_date'] = dateTimeBR($appointment['create_date']);
            $appointment['update_date'] = dateTimeBR($appointment['update_date']);
            $appointment['start_date'] = dateTimeBR($appointment['start_date']);
            $appointment['end_date'] = dateTimeBR($appointment['end_date']);
            $appointment['total_time'] = timeBR($appointment['total_time']);
            
        }
        return $appointments;
    }

    public function createApontament(Request $request) {
        $requestData = $request->getParsedBody();
        $beforApontament = $this->findBeforApontament($requestData);
        if($beforApontament) {
            $beforApontament['end_date'] = $requestData['start_date'];
            $this->appointment->update($beforApontament);
        }
        
        $afterApontament = $this->findAfterApontament($requestData);
        if($afterApontament) {
            $requestData['end_date'] = $afterApontament['start_date'];
        }
        if($requestData['end_date']) {
            $requestData['total_time'] = diffDate($requestData['start_date'], $requestData['end_date']);
        }
        $requestData['seq'] = $this->appointment->findSeq();
        $this->appointment->create($requestData);
    }

    public function findBeforApontament(array $requestData) {
        $startDate = $requestData['start_date'];
        $idEmployee = $requestData['id_employee'];
        return $this->appointment->findBeforApontament($idEmployee, $startDate);
    }

    public function findAfterApontament(array $requestData) {
        $startDate = $requestData['start_date'];
        $idEmployee = $requestData['id_employee'];
        return $this->appointment->findAfterApontament($idEmployee, $startDate);
    }
}