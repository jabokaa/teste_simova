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