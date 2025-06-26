<?php
session_start(); // Always start the session before accessing it

// Unset all of the session variables
$_SESSION = array();

// Destroy the session cookie (if using cookies for session management)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// Set a logout message
$_SESSION['alert_type'] = 'info';
$_SESSION['alert_message'] = "You have been logged out.";

// Redirect to the login page
header("Location: login.php");
exit();
?>