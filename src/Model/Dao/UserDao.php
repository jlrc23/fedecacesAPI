<?php

namespace App\Model\Dao;


use App\Sys\DataBase;
use App\Sys\SysErrors;
use App\Model\Bean\UserBean;

class UserDao extends AbstractDao
{

    public function save(UserBean $newUser, &$error=null)
    {
        if ($this->exists($newUser->getEmail()) ){
            $error = SysErrors::ERROR_306;
            return false;
        }
        else
            return $this->insert($newUser);
    }

    public function exists($email )
    {
        if (empty($email))
            throw new \Exception("There are wont email of user");
        $sql = "SELECT count(*) as total FROM users WHERE email = :email";
        try {
            $stmt = self::$_pdo->prepare($sql);
            $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            if (isset($result[0]["total"]) && intval($result[0]["total"]) > 0)
                return true;
        } catch (\PDOException $e) {
            $message =  sprintf('['.basename(__FILE__).':'.__LINE__."] #%d. %s in query: $sql in %s:%d", $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            error_log($message);
        } catch (\Exception $e) {
            $message =  sprintf('['.basename(__FILE__).':'.__LINE__."] #%d. %s in query: $sql in %s:%d", $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            error_log($message);
        }
        return false;
    }

    public function insert(Userbean $newuser){
        $result = false;
        $sql = "INSERT INTO users(email,password,name,created) VALUES(:email,:password,:name,:created)";
        try{
            $stmt = self::$_pdo->prepare($sql);
            $stmt->bindValue("email",$newuser->getEmail(), \PDO::PARAM_STR);
            $stmt->bindValue("password", $newuser->getPassword(), \PDO::PARAM_STR);
            $stmt->bindValue("name", $newuser->getName(), \PDO::PARAM_STR);
            $stmt->bindValue("created", date("Y-m-d H:i:s"));
            if($stmt->execute())
                $result =  true;
        }catch (\Exception $e){
            $message =  sprintf('['.basename(__FILE__).':'.__LINE__."] #%d. %s in query: $sql in %s:%d", $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            error_log($message);
        }
        return $result;
    }

    public function get($email )
    {
        $result = null;
        if (empty($email))
            throw new \Exception("There are wont email of user");
        $sql = "SELECT password, name, email as total FROM users WHERE email = :email LIMIT 1";
        try {
            $stmt = self::$_pdo->prepare($sql);
            $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount()>0){
                $res = $stmt->fetch(\PDO::FETCH_OBJ);//'\App\Model\Bean\UserBean'
                $result = new UserBean($res);
            }
        } catch (\PDOException $e) {
            $message =  sprintf('['.basename(__FILE__).':'.__LINE__."] #%d. %s in query: $sql in %s:%d", $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            error_log($message);
        } catch (\Exception $e) {
            $message =  sprintf('['.basename(__FILE__).':'.__LINE__."] #%d. %s in query: $sql in %s:%d", $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            error_log($message);
        }
        return $result;
    }


}