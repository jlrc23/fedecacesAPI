<?php
namespace App\Controllers\CreateAccount;

use App\Model\Bean\UserBean;
use App\Model\Dao\UserDao;
use Slim\Slim;

class CreateAccountController
{
    public function index(){
        $app = Slim::getInstance();
        $app->response()->setBody("Registro exitoso");
    }

    public function create(){
        $app = Slim::getInstance();
        $user = new UserBean();
        $user->setEmail($app->request()->post("email"));
        $user->setNombre($app->request()->post("nombre"));
        $user->setPassword($app->request()->post("password"));
        UserDao::save($user);
    }
}