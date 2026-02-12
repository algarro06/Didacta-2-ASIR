<?php
session_start();

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', time() - 3600, "/");
    if (isset($params)) {
        setcookie($key, '', time() - 3600, $params["path"], $params["domain"]);
    }
}

header("Location: login.php");
exit();
?>