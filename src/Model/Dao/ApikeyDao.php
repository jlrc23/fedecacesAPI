<?php
/**
 * Created by PhpStorm.
 * User: enzacta
 * Date: 4/4/2017
 * Time: 7:02 AM
 */

namespace App\Model\Dao;


use App\Sys\DataBase;

class ApikeyDao extends AbstractDao
{
    private static $id =0;

    public static function get($user, $pwd){
        $result =  false;
        if(empty(self::$id)){
            $sql = "SELECT id FROM apikey WHERE user = :user and pwd = :pwd LIMIT 1";
            try{
                $stmt = self::getConnection()->prepare($sql);
                $stmt->bindValue("user", $user, \PDO::PARAM_STR);
                $stmt->bindValue("pwd", $pwd, \PDO::PARAM_STR);
                if($stmt->execute() && $stmt->rowCount()>0){
                    $res = $stmt->fetch(\PDO::FETCH_OBJ);
                    $result = self::$id = intval($res->id);
                }
            }catch (\Exception $e){
                $msg ='['.basename($e->getFile()).":{$e->getLine()}] Error {$e->getMessage()} in {$sql}";
                error_log($msg);
            }
        }else
            $result =self::$id;
        return $result;
    }

    public static function getBeanById($id){
        $sql = "SELECT * FROM apikey WHERE id = :id LIMIT 1";
        $result =  false;
        try{
            $stmt = self::getConnection()->prepare($sql);
            $stmt->bindValue("id", $id, \PDO::PARAM_INT);
            if($stmt->execute() && $stmt->rowCount()>0){
                $result = $stmt->fetch(\PDO::FETCH_CLASS,'\App\Model\Bean\UserBean');
            }
        }catch (\Exception $e){
            $msg ='['.basename($e->getFile()).":{$e->getLine()}] Error {$e->getMessage()} in {$sql}";
            error_log($msg);
        }
        return $result;
    }
}