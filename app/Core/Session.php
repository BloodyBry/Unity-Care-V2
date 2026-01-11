<?php
class Session {
    public static function start() {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        // Prevent browser from caching pages
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        return $_SESSION[$key] ?? null;
    }

    public static function isLoggedIn(){
        return isset($_SESSION['user_id']);
    }

    public static function destroy(){
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
