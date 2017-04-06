<?php
$_ENV['SLIM_MODE'] = 'development'; //'production';
$CONFIG =  array(
    'debug'=> true,
    'mode' => 'development',
    'log.level' => \Slim\Log::DEBUG,
    'log.enabled' => true,
    'templates.path' => './src/Views'
);

