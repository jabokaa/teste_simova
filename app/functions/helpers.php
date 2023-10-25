<?php

/**
 * Função de debug, dump and die
 * @param mixed $var
 * @return void
 * 
 */
 function dd($var) {
     echo "<pre>";
     var_dump($var);
     echo "</pre>";
     die();
 }

 /**
  * Função para retornar o caminho do arquivo
  * @param string $path
  * @return string
  */
 function path() {
    $vendorDir = dirname(dirname(__FILE__));
    return dirname($vendorDir);
 }

  /**
  * Função para comverter date time para formato BR
  * @param string $data
  * @return string
  */
    function dateTimeBR($data) {
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
    function dateBR($data) {
        if(!$data) {
            return 'Não informado';
        }
        return date('d/m/Y', strtotime($data));
    }

    /**
     * Função para converter segundos em h:m:s
     */
    function timeBR(int $time) {
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
    function diffDate(string $dataStart, string $dataEnd) {
        $dataStart = strtotime($dataStart);
        $dataEnd = strtotime($dataEnd);
        return $dataEnd - $dataStart;
    }