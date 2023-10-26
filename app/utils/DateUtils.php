<?php

namespace app\utils;

use app\src\Load;

class DateUtils {

    /**
     * Função para comverter date time para formato BR
    * @param string $data
    * @return string
    */
    static function dateTimeBR($data) {
        if(!$data) {
            return 'Não informado';
        }
        return date('d/m/Y H:i:s', strtotime($data));
    }

    /**
    * Função para comverter date time para formato BR
    * @param string $data
    * @return string
    */
    static function dateBR($data) {
        if(!$data) {
            return 'Não informado';
        }
        return date('d/m/Y', strtotime($data));
    }

    /**
     * Função para converter segundos em h:m:s
     */
    static function time(int $time) {
        if($time < 0) {
            return "00:00:00";
        }
        return gmdate("H:i:s", $time);
    }

    /**
     * Função para calcular a diferença entre duas datas em segundos
     * @param string $dataStart
     * @param string $dataEnd
     */
    static function diffDate(string $dataStart, string $dataEnd) {
        $dataStart = strtotime($dataStart);
        $dataEnd = strtotime($dataEnd);
        return $dataEnd - $dataStart;
    }

}