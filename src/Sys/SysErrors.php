<?php
namespace App\Sys;


class SysErrors
{

    const MISSING_FIELDS_CODE = 550;
    const ERROR_520 = "520. Error inesperado";
    const ERROR_500 = "500. Ocurrio un error mientras se procesaba su petición";
    const ERROR_402 = "402. Invalido API_KEY";
    const ERROR_403 = "403. Credenciales invalidas";
    const ERROR_305 = "305. Correo electronico es invalido";
    const ERROR_306 = "306. El correo electronico ya existe";
    const FAUL_DATABASE = 'No se puede conectar a la base de datos';
    const ERROR_600 = "600. Acceso denegado ";
}