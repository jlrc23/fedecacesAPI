<?php
namespace App\Controllers;

use App\Components\CreationAccount\CreationAccount;
use App\Sys\Entity\ResponseBasic;
use App\Sys\Entity\ResponseError;
use Slim\Http\Response;
use Slim\Slim;

class CreateAccountController
{
    /**
     * @var Slim
     */
    private $_app;

    /**
     * @var Response
     */
    public $response;
    /**
     * Resources constructor.
     */
    public function __construct(){
        $this->_app = Slim::getInstance();
        $this->response = new Response();
        $this->response->headers->set('Content-Type', 'application/json');
    }

    public function index(){
        $data = array(
            "email"=>$this->_app->request->get("email"),
            "name"=>$this->_app->request->get("name"),
            "password" =>$this->_app->request->get("password")
        );
        error_log($this->_app->request()->post());
        error_log($data);
        $this->response->setBody( CreationAccount::save(4data));
        $this->_app->response =  $this->response;
    }
}