<?php
namespace Server\Auth;

session_start();

class Auth
{
    private static $logged = false;

    public static function login($id)
    {
        $_SESSION['id'] = $id;
        self::$logged = true;
    }

    public static function isLogged()
    {
        return self::$logged || isset($_SESSION['id']);
    }
}