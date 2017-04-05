<?php
/**
 * Created by PhpStorm.
 * User: enzacta
 * Date: 4/5/2017
 * Time: 6:09 AM
 */

namespace App\Controllers\Errors;


class Error402Controller
{
    public function index(){
        $app = \Slim\Slim::getInstance();
        $app->status(400);
        $app->render("Errors/402.html");
    }
}