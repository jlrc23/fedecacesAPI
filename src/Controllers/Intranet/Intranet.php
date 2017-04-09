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
//        $app->response->setBody("    <form method=\"post\">
//        <label>encriptar:</label><input name=\"strToEncriptar\"> ". Security::encrypt($msgToEncrypt). "
//         <br>
//        <label>Desencriptar:</label><input name=\"strToDesencrypt\">".Security::desencrypt($msgToDesencrypt)."<br>
//        <input type=\"submit\">
//    </form>");
       $app->render('/Intranet/index.php',array('msgToEncrypt'=>$msgToEncrypt, "msgToDesencrypt"=>$msgToDesencrypt) );
    }
}