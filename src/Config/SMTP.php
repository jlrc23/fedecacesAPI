<?php


namespace App\Config;

use App\Sys\DataBase;

class SMTP
{
    const HOST = "mail.aprendizajefedecaces.com.mx";
    const USR = "noresponder@aprendizajefedecaces.com.mx";
    const SMTPSecure = '';//tls
    const PORT = "25"; // 465
    const NAME = "Aprendizaje FEDECACES";
    const isHTML = true;
}