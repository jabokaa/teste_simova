<?php

    require "vendor/autoload.php";
    require_once __DIR__.'/env.php';

    use Slim\App;

    $config['displayErrorDetails'] = true;
    $app = new App(['settings' => $config]);