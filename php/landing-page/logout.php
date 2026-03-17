<?php
session_start();

// Log the logout attempt
error_log('Logout.php called. User being logged out.');

// Clear session data
$_SESSION = array();

// Destroys the session cookies as well
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Outputs script to clear localStorage before redirecting
echo "<script>
    localStorage.removeItem('userLoggedIn');
    localStorage.removeItem('userName');
    window.location.href = 'http://localhost/WebDevProject_WIP/index.php';
</script>";
exit;
?>