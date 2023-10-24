<?php

namespace app\src;

class Load{

    /**
     * Load a file
     * @param string $file
     * @return array
     */
    public static function file(string $file) : array {
       $file = path().$file;

       if(!file_exists($file)){
            throw new \Exception("This file does not exist: {$file}");
       }
       
       return require $file;
    }
}