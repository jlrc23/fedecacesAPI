<?php
/**
 * Created by PhpStorm.
 * User: enzacta
 * Date: 4/9/2017
 * Time: 9:25 AM
 */

namespace App\Sys;


use App\Config\SMTP;

class SendEmail
{
    /**
     * @var Options|null
     */
    private static  $_options = null;

    /**
     * @var null|\PHPMailer
     */
    private static  $_mailer = null;


    private static function prepare(){
        if(empty(self::$_options  )){
            self::$_options  = new Options();
        }
        if(empty(self::$_mailer)){
           self::$_mailer = new \PHPMailer();
           self::prepareMailer();
        }
    }

    private static function prepareMailer(){
        self::$_mailer->isSMTP();
        self::$_mailer->Host = SMTP::HOST;
        self::$_mailer->CharSet="UTF-8";
        self::$_mailer->SMTPAuth = true;
        self::$_mailer->Username = self::$_options->readOption("SMTP_USER");
        self::$_mailer->Password = self::$_options->readOption("SMTP_PASSWORD");
        self::$_mailer->SMTPSecure = SMTP::SMTPSecure;
//        self::$_mailer->setFrom(SMTP::USR, SMTP::NAME);
        self::$_mailer->From = SMTP::USR;
        self::$_mailer->FromName = SMTP::NAME;
        self::$_mailer->Port = SMTP::PORT;
        self::$_mailer->isHTML(SMTP::isHTML);
        self::$_mailer->setLanguage("es");
    }


    public static function email($message, $to, $subject){
        try{
            self::prepare();
            self::$_mailer->Subject = $subject;
            self::$_mailer->addAddress($to);
            self::$_mailer->Body    = $message;
            self::$_mailer->AltBody = strip_tags($message);
            if(self::$_mailer->send()) {
                $msg ='['.basename(__FILE__).':'.__LINE__." ] Error ". self::$_mailer->ErrorInfo;
                error_log($msg);
                throw new \Exception('Message could not be sent.');
            }
        }catch (\Exception $e){
            $msg = '['. dirname(__FILE__).':'.__LINE__."] Ocurred error {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}";
            error_log($msg);
//            throw $e;
        }
        return true;
    }
}