<?php
namespace App\Libs\Sys;


class Security
{
    private static $user ="f98899486719ab79ae9530bd3f776e0c"; //3F1EM69%0f3b
    private static $pwd ="e7d6d15a6f4c7b7fddd8196d872cb302"; // %f1H^o917%D5

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
        if ($usr == self::$user && $pwd == self::$pwd)
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
            $result = base64_encode(openssl_encrypt($message, self::METHOD, $key, 1 ));
        }
        return $result;
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
            $result = openssl_decrypt($message, self::METHOD, $key, 1);
        }
        return $result;
    }

}