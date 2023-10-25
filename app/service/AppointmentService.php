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

    /**
     * lista os apontamentos de um funcionario
     * @param int $idEmplado
     * @param int $page pagina atual do paginador
     * @return array
     */
    public function listAppointments(int $idEmplado, int $page): array {
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

    /**
     * formata os dados para exibição
     * @param array $appointments
     * @return array
     */
    private function dataFromater(array $appointments): array
    {
        foreach ($appointments as &$appointment) {
            $appointment['create_date'] = dateTimeBR($appointment['create_date']);
            $appointment['update_date'] = dateTimeBR($appointment['update_date']);
            $appointment['start_date_format'] = dateTimeBR($appointment['start_date']);
            $appointment['end_date'] = dateTimeBR($appointment['end_date']);
            $appointment['total_time'] = timeBR($appointment['total_time']);
            
        }
        return $appointments;
    }

    /**
     * cria um apontamento
     * @param array $requestData
     */
    public function createApontament(array $requestData): void {
        $this->updateBeforApontamentWithNewApontament($requestData);
        $afterApontament = $this->findAfterApontament($requestData);
        if($afterApontament) {
            $requestData['end_date'] = $afterApontament['start_date'];
        }
        $requestData = $this->recalculateTotalTime($requestData);
        $requestData['seq'] = $this->appointment->findSeq();
        $this->appointment->create($requestData);
    }

    /**
     * atualiza a data final do apontamento anterior com a data inicial do apontamento atual
     * @param array $apontament
     */
    public function updateBeforApontamentWithNewApontament(array $apontament): void {
        $beforApontament = $this->findBeforApontament($apontament);
        if($beforApontament) {
            $beforApontament['end_date'] = $apontament['start_date'];
            $beforApontament = $this->recalculateTotalTime($beforApontament);
            $this->appointment->update($beforApontament);
        }
    }

    /**
     * busca o apontamento anterior que tenha a data mais proxima da data inicial do apontamento atual
     * @param array $requestData
     * @return array
     */
    public function findBeforApontament(array $apontament): array {
        $startDate = $apontament['start_date'];
        $idEmployee = $apontament['id_employee'];
        return $this->appointment->findBeforApontament($idEmployee, $startDate);
    }

    /**
     * busca o apontamento posterior que tenha a data mais proxima da data inicial do apontamento atual
     * @param array $apontament
     * @return array
     */
    public function findAfterApontament(array $apontament): array {
        $startDate = $apontament['start_date'];
        $idEmployee = $apontament['id_employee'];
        return $this->appointment->findAfterApontament($idEmployee, $startDate);
    }

    /**
     * atualiza um apontamento
     * @param array $requestData
     * @param int $idAppointment
     */
    public function updateApontament(array $requestData, int $idAppointment): void {
        $enabled = $requestData['enabled'];
        $startDate = $requestData['start_date'];
        if($enabled == 0) {
            $this->disable($idAppointment);
        }
        else {
            $this->updateStartDate($idAppointment, $startDate);
        }
    }

    /**
     * atualiza a data inicial de um apontamento
     * @param int $idAppointment
     * @param string $startDate
     * @return void
     */
    private function updateStartDate($idAppointment, $startDate): void {
        $appointment = $this->appointment->find($idAppointment);
        $this->updateBeforApontamentWhitAfterApontament($appointment);

        $newApontament = [
            'id_employee' => $appointment['id_employee'],
            'start_date' => $startDate
        ];
        $this->updateBeforApontamentWithNewApontament($newApontament);

        $afterApontament = $this->findAfterApontament($newApontament);
        $appointment['end_date'] = null;
        if($afterApontament) {
            $appointment['end_date'] = $afterApontament['start_date'];
        }
        $appointment['start_date'] = $startDate;
        $appointment = $this->recalculateTotalTime($appointment);
        $this->appointment->update($appointment);
    }

    /**
     * desabilita um apontamento
     * @param int $idAppointment
     * @return void
     */
    private function disable($idAppointment): void {
        $appointment = $this->appointment->find($idAppointment);
        $this->updateBeforApontamentWhitAfterApontament($appointment);
        $appointment['enabled'] = 0;
        $this->appointment->update($appointment);
    }

    /**
     * atualiza o apontamento anterior com a data final do apontamento posterior
     * @param array $appointment
     * @return void
     */
    private function updateBeforApontamentWhitAfterApontament(array $appointment): void {
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
    }

    /**
     * recalcula o tempo total de um apontamento
     * @param array $apontament
     * @return array
     */
    private function recalculateTotalTime(array $apontament): array {
        $apontament['total_time'] = 0;
        if($apontament['end_date']) {
            $apontament['total_time'] = diffDate($apontament['start_date'], $apontament['end_date']);
        }
        return $apontament;
    }
}