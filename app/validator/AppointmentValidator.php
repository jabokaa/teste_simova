<?php

namespace app\validator;

use app\models\Appointment;
use Slim\Http\Request;

class AppointmentValidator { 

    static function create(Request $request) {
        $data = $request->getParsedBody();
        if (!isset($data["start_date"]) || empty($data["start_date"])) {
            $error[] = "Data de início não informada";
        }
        if (!isset($data["id_employee"]) || !is_numeric($data["id_employee"])) {
            $error[] = "Funcionário não informado";
        }
        if (isset($data["id_employee"]) && $data["end_date"] && !self::validateEndDate($data)) {
            $error[] = "Data de fim deve ser a maior data do dia";
        }
        if(self::apontamentExists($data)) {
            $error[] = "Já existe um apontamento para este funcionário nesta data";
        }
        if($data["end_date"] && strtotime($data["end_date"]) < strtotime($data["start_date"])) {
            $error[] = "Data de fim deve ser maior que a data de início";
        }
        if($data["end_date"] && !self::datesAreTheSameDay($data)) {
            $error[] = "Data de fim deve ser do mesmo dia da data de início";
        }
        if (isset($error)) {
            throw new \Exception(implode(";", $error));
        }
    }

    static function validateEndDate($data) {
        $appointment = new Appointment();
        $appointmentAfter = $appointment->findAfterApontament($data['id_employee'], $data['end_date']);
        return count($appointmentAfter) == 0;
    }

    static function apontamentExists($data) {
        $appointment = new Appointment();
        $appointment = $appointment->where(
            [
                'id_employee' => $data['id_employee'],
                'start_date' => $data['start_date'],
            ]
        );
        return count($appointment) > 0;
    }

    static function datesAreTheSameDay($data) {
        return date("d/m/Y", strtotime($data["end_date"])) == date("d/m/Y", strtotime($data["start_date"]));
    }

}