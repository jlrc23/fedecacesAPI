<?php
/**
 * var \Slim\Slim
 */
global $app;
if($app instanceof \Slim\Slim){
    $app->post('/', function (){
    });
    $app->get('/', function () {
        echo "FEDECACES-API";
    }
    );
}
