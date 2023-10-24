<?php

namespace app\models;

class Appointment extends Model{

    protected $table = 'appointment';
    protected $range = 5;

    public function findBeforApontament($idEmployee, $startDate) {
        $sql = "SELECT * FROM appointment 
            WHERE id_employee = {$idEmployee} AND start_date < '{$startDate}'
            AND enabled = 1 AND DATE(start_date) = DATE('{$startDate}')
            ORDER BY start_date DESC
            LIMIT 1";
        $beforApontament = $this->connect->query($sql);
        $beforApontament->execute();
        return $beforApontament->fetch();
    }

    public function findAfterApontament($idEmployee, $startDate) {
        $sql = "SELECT * FROM appointment 
            WHERE id_employee = {$idEmployee} AND start_date > '{$startDate}'
            AND enabled = 1 AND DATE(start_date) = DATE('{$startDate}')
            ORDER BY start_date ASC
            LIMIT 1";
        $afterApontament = $this->connect->query($sql);
        $afterApontament->execute();
        return $afterApontament->fetch();
    }

    public function findSeq() {
        $sql = "SELECT MAX(seq) FROM appointment";
        $seq = $this->connect->query($sql);
        $seq->execute();
        return $seq->fetchColumn() + 1;
    }
}