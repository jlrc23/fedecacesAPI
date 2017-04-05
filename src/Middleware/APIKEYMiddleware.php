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
        $req = $app->request;
        $msg ="";
        error_log(basename(__FILE__)." getRootUri: {$req->getRootUri()}  getResourceUri:{$req->getResourceUri()}");
        if(strpos( $req->getResourceUri(), 'api') !== false){
            if(Security::validHeader($msg)){
                $this->next->call();
            }else{
                $app->redirect('/400', 400);
            }
        }else{
            $this->next->call();
        }

    }
}