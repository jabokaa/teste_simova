<?php

namespace app\models;

class Appointment extends Model{

    protected $table = 'appointment';
    protected $range = 5;

    /**
     * Busca o ultimo apontamento antes do apontamento atual
     * @param int $idEmplado
     * @param string $startDate
     * @return array
     */
    public function findBeforApontament(int $idEmployee, string $startDate): array {
        $sql = "SELECT * FROM appointment 
            WHERE id_employee = {$idEmployee} AND start_date < '{$startDate}'
            AND enabled = 1 AND DATE(start_date) = DATE('{$startDate}')
            ORDER BY start_date DESC
            LIMIT 1";
        $beforApontament = $this->connect->query($sql);
        $beforApontament->execute();
        $result = $beforApontament->fetch();
        return $result  ? $result : [];
    }

    /**
     * Busca o proximo apontamento depois do apontamento atual
     * @param int $idEmplado
     * @param string $startDate
     * @return array
     */
    public function findAfterApontament(int $idEmployee, string $startDate) {
        $sql = "SELECT * FROM appointment 
            WHERE id_employee = {$idEmployee} AND start_date > '{$startDate}'
            AND enabled = 1 AND DATE(start_date) = DATE('{$startDate}')
            ORDER BY start_date ASC
            LIMIT 1";
        $afterApontament = $this->connect->query($sql);
        $afterApontament->execute();
        $result = $afterApontament->fetch();
        return $result  ? $result : [];
    }

    /**
     * Tras o proximo seq para o apontamento
     * @return int
     */
    public function findSeq() {
        $sql = "SELECT MAX(seq) FROM appointment";
        $seq = $this->connect->query($sql);
        $seq->execute();
        return $seq->fetchColumn() + 1;
    }
}