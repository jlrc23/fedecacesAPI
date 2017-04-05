<?php
/**
 * Created by PhpStorm.
 * User: enzacta
 * Date: 4/5/2017
 * Time: 6:39 AM
 */

namespace App\Controllers\Intranet;


use Slim\Slim;

class Intranet
{
    public function index(){
        $app = Slim::getInstance();
        $msgToEncrypt = $app->request()->post('strToEncriptar');
        $msgToDesencrypt = $app->request()->post('strToDesencrypt');
        $app->render('Intranet\index.php',array('msgToEncrypt'=>$msgToEncrypt, "msgToDesencrypt"=>$msgToDesencrypt) );
    }
}