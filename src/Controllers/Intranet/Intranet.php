<?php
namespace App\Controllers\Intranet;


use App\Sys\Security;
use Slim\Slim;

class Intranet
{
    public function index(){
        $app = Slim::getInstance();
        $msgToEncrypt = $app->request()->post('strToEncriptar');
        $msgToDesencrypt = $app->request()->post('strToDesencrypt');
        $app->render('/Intranet/index.php',array('msgToEncrypt'=>$msgToEncrypt, "msgToDesencrypt"=>$msgToDesencrypt) );
    }
}