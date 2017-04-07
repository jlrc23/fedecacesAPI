<?php
namespace App\Components\CreationAccount;

use App\Model\Bean\UserBean;
use App\Model\Dao\UserDao;

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
                $result =  $userDao->save($user, self::$_errors);
            }
        }catch (\Exception $e){
            error_log($e);
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
}