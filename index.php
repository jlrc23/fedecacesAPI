<?php
require_once 'vendor/autoload.php';
require_once ("config.php");
global $CONFIG;
$app = new \Slim\Slim($CONFIG);
\App\Sys\I18N::prepare();
$app->add(new \App\Middleware\APIKEYMiddleware());
$app->get('/400','\App\Controllers\Errors\Error402Controller:index' );
$app->get('/api/v1/account/new', '\App\Controllers\CreateAccountController:index');
$app->post('/api/v1/account/new', '\App\Controllers\CreateAccountController:index');

$app->map('/intranet/index','\App\Controllers\Intranet\Intranet:index' )->via('GET', 'POST');
$app->map('/intranet','\App\Controllers\Intranet\Intranet:index' )->via('GET', 'POST');
$app->run();