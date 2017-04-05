<?php
require_once 'vendor/autoload.php';
require_once ("config.php");
global $CONFIG;
$app = new \Slim\Slim($CONFIG);
$app->add(new \App\Middleware\APIKEYMiddleware());
$app->post('/account/new', '\App\Controllers\CreateAccount\CreateAccountController:index');
$app->get('/','\App\Controllers\HomeController:index');
$app->run();