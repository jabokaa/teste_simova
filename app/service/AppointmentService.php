<?php

namespace app\service;

use app\models\Appointment;
use app\models\Employee;

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
        $appointments = $this->appointment->where($filter, $page);
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
}