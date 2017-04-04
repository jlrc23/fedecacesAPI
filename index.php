<?php
require_once 'vendor/autoload.php';
require_once ("config.php");
$app = new \Slim\Slim($CONFIG);
$app->add(new \App\Middleware\APIKEYMiddleware());
include("route.php");
$app->run();