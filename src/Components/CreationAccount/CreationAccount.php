<?php
namespace App\Components\CreationAccount;

use App\Model\Bean\UserBean;
use App\Model\Dao\UserDao;
use App\Sys\Entity\ResponseError;
use App\Sys\Entity\ResponseSuccess;
use App\Sys\SysErrors;

class CreationAccount{
    private static $_errors = array();


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

    /**
     *             new ResponseBasic("Guardado exitoso")
    new ResponseError($errors);

     */
}