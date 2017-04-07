<?php
/**
 * Created by PhpStorm.
 * User: enzacta
 * Date: 4/4/2017
 * Time: 7:04 AM
 */

namespace App\Model\Dao;


use App\Sys\DataBase;

abstract class AbstractDao
{
    /**
     * @var \PDO
     */
    protected static $_pdo = null;

    protected $fields      = array();
    protected $fieldsParam = array();


    public function __construct()
    {
        self::$_pdo = DataBase::connect();
    }

    /**
     * @return null|\PDO
     */
    public static function getConnection(){
        if(empty(self::$_pdo))
            self::$_pdo =  DataBase::connect();
        return self::$_pdo;
    }



}