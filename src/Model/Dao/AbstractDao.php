<?php
/**
 * Created by PhpStorm.
 * User: enzacta
 * Date: 4/4/2017
 * Time: 7:04 AM
 */

namespace App\Model\Dao;


use App\Libs\Sys\DataBase;

class AbstractDao
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


}