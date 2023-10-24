<?php

require "../bootstrap.php";

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();