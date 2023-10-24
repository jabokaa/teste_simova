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
    function dateTimeBR(string $data) {
        return date('d/m/Y H:i:s', strtotime($data));
    }

  /**
  * Função para comverter date time para formato BR
  * @param string $data
  * @return string
  */
    function dateBR($data) {
        return date('d/m/Y', strtotime($data));
    }

    /**
     * Função para converter segundos em h:m:s
     */
    function timeBR(string $data) {
        return gmdate("H:i:s", $data);
    }
