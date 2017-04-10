<?php
namespace App\Controllers;

use App\Components\CreationAccount\CreationAccount;
use App\Sys\Entity\ResponseBasic;
use App\Sys\Entity\ResponseError;
use Slim\Http\Response;
use Slim\Slim;

class AccountController
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

    public function create(){
        $data = $this->_app->request()->post();
        $this->response->setBody( CreationAccount::save($data));
        $this->_app->response =  $this->response;
    }

    public function recovery(){
        $email = $this->_app->request()->post("email");
        $this->response->setBody( CreationAccount::recovery($email));
        $this->_app->response =  $this->response;
    }

    public function login(){
        $email = $this->_app->request()->post("email");
        $password = $this->_app->request()->post("password");
        $this->response->setBody( CreationAccount::login($email,$password));
        $this->_app->response =  $this->response;
    }

}