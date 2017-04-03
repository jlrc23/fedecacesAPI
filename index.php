<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim();
$app->post('/', function (){

});

$app->get('/', function () {
	echo "WEBSERVICES FECADES";
}
);

$app->run();