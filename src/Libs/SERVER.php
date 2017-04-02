<?php


namespace App\Libs;


class SERVER
{
    /**
     * @var string
     */
    private static $_ipClient = '';

    /**
     * @var string
     */
    private static $_url = '';


    /**
     * Return the full Url requested
     * @return string
     */
    public static function getUrl()
    {
        if (empty(self::$_url)) {
            self::$_url = 'http' . ((isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS']) ? 's' : '');
            self::$_url .= '://' . $_SERVER["SERVER_NAME"];
            self::$_url .= $_SERVER['REQUEST_URI'];
        }
        return self::$_url;
    }

    /**
     * Return Ip of client that request
     * @return null|string
     */
    public static function getClientIP()
    {
        if (empty(self::$_ipClient)) {
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                self::$_ipClient = $_SERVER['HTTP_CLIENT_IP'];
            else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                self::$_ipClient = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_X_FORWARDED']))
                self::$_ipClient = $_SERVER['HTTP_X_FORWARDED'];
            else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
                self::$_ipClient = $_SERVER['HTTP_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_FORWARDED']))
                self::$_ipClient = $_SERVER['HTTP_FORWARDED'];
            else if (isset($_SERVER['REMOTE_ADDR']))
                self::$_ipClient = $_SERVER['REMOTE_ADDR'];
            else
                self::$_ipClient = 'UNKNOWN';
        }
        return self::$_ipClient;
    }
}