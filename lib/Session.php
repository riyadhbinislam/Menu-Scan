<?php
class Session
{
    public static function init(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
}

    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    public static function checkSession()
    {
        self::init();
        if (self::get("adminLogin") == false) {
            self::destroy();
            header('Location: index.php');
            exit;
        }
    }

    public static function checkLogin()
    {
        self::init();
        if (self::get("adminLogin") == true) {
            header('Location: admin.php');
            exit;
        }
    }

    public static function destroy()
    {
        session_destroy();
        header('Location: index.php');
        exit;
    }
    public static function userdestroy()
    {
        session_destroy();
        echo "<script>window.location ='home'</script>";
        exit;
    }
}