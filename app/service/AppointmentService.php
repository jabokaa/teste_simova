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
            $appointment['start_date_format'] = dateTimeBR($appointment['start_date']);
            $appointment['end_date'] = dateTimeBR($appointment['end_date']);
            $appointment['total_time'] = timeBR($appointment['total_time']);
            
        }
        return $appointments;
    }

    public function createApontament($requestData) {
        $beforApontament = $this->findBeforApontament($requestData);
        if($beforApontament) {
            $beforApontament['end_date'] = $requestData['start_date'];
            $beforApontament = $this->recalculateTotalTime($beforApontament);
            $this->appointment->update($beforApontament);
        }
        
        $afterApontament = $this->findAfterApontament($requestData);
        if($afterApontament) {
            $requestData['end_date'] = $afterApontament['start_date'];
        }
        $requestData = $this->recalculateTotalTime($requestData);
        $requestData['seq'] = $this->appointment->findSeq();
        $this->appointment->create($requestData);
    }

    public function findBeforApontament(array $requestData) {
        $startDate = $requestData['start_date'];
        $idEmployee = $requestData['id_employee'];
        return $this->appointment->findBeforApontament($idEmployee, $startDate);
    }

    public function findAfterApontament(array $data) {
        $startDate = $data['start_date'];
        $idEmployee = $data['id_employee'];
        return $this->appointment->findAfterApontament($idEmployee, $startDate);
    }

    public function updateApontament(Request $request, $idAppointment) {
        $requestData = $request->getParsedBody();
        $enabled = $requestData['enabled'];
        $startDate = $requestData['start_date'];
        if($enabled == 0) {
            $this->disable($idAppointment);
        }
        else {
            $this->updateStartDate($idAppointment, $startDate);
        }
    }

    private function updateStartDate($idAppointment, $startDate) {
        $appointment = $this->appointment->find($idAppointment);
        $afterApontament = $this->findAfterApontament($appointment);
        $beforApontament = $this->findBeforApontament($appointment);
        if($beforApontament) {
            $beforApontament['end_date'] = null;
            if($afterApontament) {
                $beforApontament['end_date'] = $afterApontament['start_date'];
            }
            $beforApontament = $this->recalculateTotalTime($beforApontament);
            $this->appointment->update($beforApontament);
        }


        $beforApontament = $this->findBeforApontament([
            'id_employee' => $appointment['id_employee'],
            'start_date' => $startDate
        ]);

        
        if($beforApontament) {
            $beforApontament['end_date'] = $startDate;
            $beforApontament = $this->recalculateTotalTime($beforApontament);
            $this->appointment->update($beforApontament);
        }
        
        $afterApontament = $this->findAfterApontament([
            'id_employee' => $appointment['id_employee'],
            'start_date' => $startDate
        ]);
        $appointment['end_date'] = null;
        if($afterApontament) {
            $appointment['end_date'] = $afterApontament['start_date'];
        }
        $appointment['start_date'] = $startDate;
        $appointment = $this->recalculateTotalTime($appointment);
        $this->appointment->update($appointment);
    }
    private function disable($idAppointment) {
        $appointment = $this->appointment->find($idAppointment);
        $afterApontament = $this->findAfterApontament($appointment);
        $beforApontament = $this->findBeforApontament($appointment);
        if($beforApontament) {
            $beforApontament['end_date'] = null;
            if($afterApontament) {
                $beforApontament['end_date'] = $afterApontament['start_date'];
            }
            $beforApontament = $this->recalculateTotalTime($beforApontament);
            $this->appointment->update($beforApontament);
        }
            $appointment['enabled'] = 0;
            $this->appointment->update($appointment);
    }

    private function recalculateTotalTime($apontament) {
        $apontament['total_time'] = 0;
        if($apontament['end_date']) {
            $apontament['total_time'] = diffDate($apontament['start_date'], $apontament['end_date']);
        }
        return $apontament;
    }
}