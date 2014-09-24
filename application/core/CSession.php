<?php

class CSession extends CCApplication
{

    static protected $_session_prefix_key = 'TUlDUk9IUjIwMTQ=';

    static public function set($key, $data)
    {
        $key = self::$_session_prefix_key . $key;
        $_SESSION[$key] = $data;
    }

    static public function get($key = null)
    {
        $key = self::$_session_prefix_key . $key;
        return isset($_SESSION[$key]) ? ($session = &$_SESSION[$key]) : null;
    }

    static public function drop($key = null)
    {
        $key = self::$_session_prefix_key . $key;
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}