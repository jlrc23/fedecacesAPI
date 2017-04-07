<?php
namespace App\Sys;


use App\Config\DBAccess;
use Slim\Log;

class DataBase
{
    const DEFAULT_PORT = 3306;
    public static $objDB = null;
    private static $_host='';
    private static $_hostPort='3306';
    private static $_dataBaseUser='';
    private static $_dataBasePassowrd ='';
    private static $_dataBaseName='';

    public static function prepared()
    {
        self::$_host = DBAccess::host;
        self::$_hostPort = DBAccess::hostPort;
        self::$_dataBaseName = DBAccess::schema;
        self::$_dataBaseUser = DBAccess::usr;
        self::$_dataBasePassowrd = DBAccess::pwd;
    }

    /**
     *
     * @return null|\PDO
     */
    public static function connect()
    {
        if (empty(self::$objDB)) {
            try {
                self::prepared();
                self::$objDB = new \PDO(self::getDSN(), self::$_dataBaseUser, self::$_dataBasePassowrd);
                self::$objDB->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                self::$objDB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$objDB->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            }catch (\Exception $e) {
                $message = sprintf("#%d. %s when try connect, in %s:%d", $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
                error_log($message);
            }
        }
        return self::$objDB;
    }

    /**
     * @return string
     */
    public static function getDSN()
    {
        $result = sprintf("mysql:host=%s;port=%s;dbname=%s;charset=utf8", self::$_host,self::$_hostPort, self::$_dataBaseName);
        return $result;
    }
}