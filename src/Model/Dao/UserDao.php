<?php

namespace App\Model\Dao;


use App\Libs\Sys\SysErrors;
use App\Model\Bean\UserBean;

class UserDao
{
    /**
     * @var \PDO
     */
    private static $_pdo = null;

    private static $fields      = array('email'=>"`email`", 'password'=>"`password`",'name'=>"`name`", 'created'=>"`created`");
    private static $fieldsParam = array('email'=>":email",  'password'=>":password", 'name'=>":name",  'created'=>":created");

    /**
     * UserDao constructor.
     * @param \PDO|null $pdo
     */
    public function __construct(\PDO $pdo = null)
    {
        self::$_pdo = $pdo;
    }
    public function save(UserBean $newUser)
    {
        if ($this->exists($newUser->getEmail()) )
            throw new \Exception(SysErrors::ERROR_305);
        else
            return $this->insert($newUser);
    }

    public function exists($email )
    {
        if (empty($email)) {
            throw new \Exception("There are wont email of user");
        }
        $sql = "SELECT count(*) as total FROM users WHERE username = :username";
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
            $message =  sprintf('['.basename(__FILE__).':'.__LINE__."] #%d. %s in query: $sql in %s:%d", $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine())
            error_log($message);
        }
        return false;
    }


}