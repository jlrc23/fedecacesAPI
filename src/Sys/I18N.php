<?php
namespace App\Sys;


class I18N
{
    private static $_lc_all = null;
    private static $_name_zone;
    public static function setLocal($lc_all='es_MX')
    {
        self::$_lc_all = $lc_all;
        putenv("LC_ALL=" . self::$_lc_all);
        setlocale(LC_ALL, self::$_lc_all);
    }

    public static function setTimeZone($timezone='America/Mexico_City')
    {
        self::$_name_zone = $timezone;
        date_default_timezone_set(self::$_name_zone);
    }

    public static function getZone()
    {
        return self::$_name_zone;
    }
    public static function prepare(){
        self::setLocal();
        self::setTimeZone();
    }
}