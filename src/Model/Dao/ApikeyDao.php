<?php
/**
 * Created by PhpStorm.
 * User: enzacta
 * Date: 4/4/2017
 * Time: 7:02 AM
 */

namespace App\Model\Dao;


use App\Libs\Sys\DataBase;

class ApikeyDao extends AbstractDao
{

    /**
     * ApikeyDao constructor.
     */
    public function __construct()
    {
        $this->_pdo = DataBase::connect();
    }

    public function get(){

    }
}