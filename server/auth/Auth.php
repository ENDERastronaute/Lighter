<?php
namespace Server\Auth;

session_start();

/**
 * Authentification helper class
 */
class Auth
{
    private static $logged = false;

    /**
     * Create a new session.
     * 
     * @param mixed $id anything that will serve as an identifier.
     */
    public static function login(mixed $id)
    {
        $_SESSION['id'] = $id;
        self::$logged = true;
    }

    /**
     * Check if user is logged in.
     */
    public static function isLogged()
    {
        return self::$logged || isset($_SESSION['id']);
    }
}