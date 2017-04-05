<?php
namespace App\Middleware;
use App\Libs\Sys\Security;

class APIKEYMiddleware extends  \Slim\Middleware
{


    /**
     * Call
     *
     * Perform actions specific to this middleware and optionally
     * call the next downstream middleware.
     */
    public function call()
    {
        //The Slim application
        $app = $this->app;
        $msg ="";
        if(Security::validHeader($msg)){
            $this->next->call();
        }else{
            return false;
        }

    }
}