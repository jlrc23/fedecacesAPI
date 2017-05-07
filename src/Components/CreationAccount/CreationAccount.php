<?php
namespace App\Components\CreationAccount;

use App\Config\APP;
use App\Model\Bean\UserBean;
use App\Model\Dao\UserDao;
use App\Sys\Entity\ResponseBasic;
use App\Sys\Entity\ResponseError;
use App\Sys\Entity\ResponseSuccess;
use App\Sys\SendEmail;
use App\Sys\SysErrors;

class CreationAccount{
    private static $_errors = array();

    private static function SendEmail(UserBean $usr){
        $smarty = new \Smarty();
        $smarty->assign("name", $usr->getName() );
        $smarty->assign("password", $usr->getPassword() );
        $smarty->assign("username", $usr->getEmail() );
        $msg = $smarty->fetch( ROOT_APP.APP::TEMPLATE_EMAIL."Account/Create.tpl");
        SendEmail::email($msg, $usr->getEmail(),"Creación de cuenta");
    }

    private static function SendEmailRecuperar(UserBean $usr){
        $smarty = new \Smarty();
        $smarty->assign("name", $usr->getName() );
        $smarty->assign("password", $usr->getPassword() );
        $smarty->assign("username", $usr->getEmail() );
        $msg = $smarty->fetch( ROOT_APP . APP::TEMPLATE_EMAIL. "Account/Recuperar.tpl");
        SendEmail::email($msg, $usr->getEmail(),"Recuperacion de correo");
    }

    public static function save(array $data, &$error = null){
        $result = false;
        try{
            $user = new UserBean();
            if(isset($data["email"]))
                $user->setEmail($data["email"]);
            else
                self::addError("missing", "email");
            if(isset($data["name"]))
                $user->setName($data["name"]);
            else
                self::addError("missing", "name");

            if(isset($data["password"]))
                $user->setPassword($data["password"]);
            else
                self::addError("missing", "password");

            if(!self::hasError()){
                $userDao =  new UserDao();
                $res =  $userDao->save($user, self::$_errors);
                if($res){
                    $result = new ResponseSuccess("Cuenta creada con exito");
                    self::SendEmail($user);
                }

            }
        }catch (\Exception $e){
            error_log($e);
        }
        if(self::hasError()){
            $result = new ResponseError(self::getErrors(),SysErrors::MISSING_FIELDS_CODE);

        }
        $error = self::getErrors();
        return $result;
    }
    private static function addError($type, $msg){
        if(!isset(self::$_errors[$type])){
            self::$_errors[$type] = array();
        }
        array_push(self::$_errors[$type], $msg);


    }
    private static function hasError(){
        if(sizeof(self::$_errors)>0)
            return true;
        return false;
    }
    public static function getErrors(){
        return self::$_errors;
    }

    public static function recovery($email){
        $result = null;
        if(empty($email)){
            self::addError("missing", "email");
            $result= new  ResponseError(self::getErrors(),SysErrors::MISSING_FIELDS_CODE);
        }else{
            $userDao =  new UserDao();
            if($userDao->exists($email)){
                $user = $userDao->get($email);
                self::SendEmailRecuperar($user);
                $result = new ResponseBasic("Se le ha enviado un email con sus datos de acceso a {$email}");
            }
        }

        return $result;
    }

    /**
     * @param $email
     * @param $password
     * @return ResponseError|null
     */
    public static function login($email, $password)
    {
        $result = null;
        if(empty($email))
            self::addError("missing", "email");
        if(empty($password))
            self::addError("missing", "password");

        if(self::hasError())
            $result= new  ResponseError(self::getErrors(),SysErrors::MISSING_FIELDS_CODE);
        else{
            error_log(basename(__FILE__).':'.__LINE__."] Into here login function");
            $userDao =  new UserDao();
            if($userDao->exists($email)){
                $user = $userDao->get($email);
                if($password == $user->getPassword()){
                    error_log(basename(__FILE__).':'.__LINE__."] The password is right");
                    $result = new ResponseBasic($user);
                    error_log(basename(__FILE__).':'.__LINE__."] The password is right". print_r($user, true));
                }
                else{
                    error_log(basename(__FILE__).':'.__LINE__."] The password is wrong");
                    $result= new  ResponseError(self::getErrors(),SysErrors::PASSWORD_WRONG);
                }
            }else{
                $result= new  ResponseError(SysErrors::ACCOUNT_NOT_EXIST,305);
            }
        }
        error_log(basename(__FILE__).':'.__LINE__."] Result of login". print_r($result, true));
        return $result;
    }

    public static  function update_status($module, $topic, $question){


    }

}