<?php
// Allow CORS for your specific domain
header("Access-Control-Allow-Origin: " . (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*'));
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");

session_start();

// Enable error logging for debugging
error_log('Session check called. Session data: ' . print_r($_SESSION, true));

// Return JSON response with login status
if (!isset($_GET['action'])) {
    header('Content-Type: application/json');
    $response = [
        'logged_in' => isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true,
        'user_name' => $_SESSION['user_name'] ?? null,
        'user_id' => $_SESSION['user_id'] ?? null
    ];
    echo json_encode($response);
    exit;
}

// Handle logout action
if ($_GET['action'] === 'logout') {
    error_log('Logout action requested');
    
    // Clear session
    $_SESSION = [];
    
    // Delete session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    
    // Destroy session
    session_destroy();
    
    // Redirect back to home page
    header('Location: ../../index.php');
    exit;
}
?>