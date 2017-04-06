<?php
namespace App\Libs\Sys;


use App\Model\Dao\ApikeyDao;

class Security
{
    private static $user ="";
    private static $pwd ="";

    const METHOD = 'AES-256-CBC';
    const SECRET_KEY = "jc8Y94&ek91q";
    const SECRET_DATABASE  = 'hyuTSucAC9PjurrDHB5ukF5P';

    /**
     * @var bool
     */
    private static $auth = false;
    /**
     * @param $msg
     * @return bool
     */
    public static function validHeader(&$msg)
    {
        $usr = "";
        $pwd = "";
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER["PHP_AUTH_PW"])) {
            $msg =SysErrors::ERROR_500;
            self::$auth = false;
        } else {
            $usr = self::desencrypt($_SERVER["PHP_AUTH_USER"]);
            $pwd = self::desencrypt($_SERVER["PHP_AUTH_PW"]);
        }
        if ( ApikeyDao::get($usr, $pwd) !== false)
            self::$auth = true;
        else {
            $msg = SysErrors::ERROR_403;
            self::$auth = false;
        }
        return self::$auth;
    }

    /**
     * @param $message
     * @return string
     */
    public static function encrypt($message)
    {
        $result ="";
        if ($message != "") {
            $key = hash('sha256', self::SECRET_KEY);
            $size      = 16;
            $iv        = random_bytes($size );
            $ivSha256  = substr(hash('sha256', $iv),0,16);
            $result    = $iv.openssl_encrypt($message, self::METHOD, $key, 0, $ivSha256);
        }
        return base64_encode($result);
    }

    /**
     * @param $message
     * @return string
     */
    public static function desencrypt($message)
    {
        $result="";
        if ($message != "") {
            $message = base64_decode($message);
            $key = hash('sha256', self::SECRET_KEY);
            $iv          = substr($message, 0, 16);
            $message     = substr($message, 16);
            $ivSha256    = substr(hash('sha256', $iv),0,16);
            $result      = openssl_decrypt($message, self::METHOD, $key, 0, $ivSha256);
        }
        return $result;
    }

}