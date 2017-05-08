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
        $json = json_decode(file_get_contents('php://input'), true);
        $data = $this->_app->request()->post();
        if(empty($data))
            $data = $json;
        $this->response->setBody( CreationAccount::save($data));
        $this->_app->response =  $this->response;
    }

    public function recovery(){
        $json = json_decode(file_get_contents('php://input'), true);
        $email = $this->_app->request()->post("email");
        if(empty($email))
            $email = $json->email;
        $this->response->setBody( CreationAccount::recovery($email));
        $this->_app->response =  $this->response;
    }

    public function login(){
        try{
            error_log(basename(__FILE__).':'.__LINE__."] Into to login");
            $email = $this->_app->request()->post("email");
            $password = $this->_app->request()->post("password");

            $json = json_decode(file_get_contents('php://input'), true);
            error_log(basename(__FILE__).':'.__LINE__."] Info login:". print_r($json, true));
            if(empty($email))
                $email = $json->email;
            if(empty($password))
                $password = $json->email;
            error_log(basename(__FILE__).':'.__LINE__."] Info login: (email:{$email}), (password:{$password})");
            $this->response->setBody( CreationAccount::login($email,$password));
            error_log(basename(__FILE__).':'.__LINE__."] Response login:". print_r($this->response, true));
            $this->_app->response =  $this->response;
        }catch(\Exception $e){
            error_log(basename(__FILE__).':'.__LINE__."] Error {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}");
        }

    }

}