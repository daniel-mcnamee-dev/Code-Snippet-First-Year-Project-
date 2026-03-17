<?php
// Turn off error display for production
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Start session FIRST
session_start();

require_once __DIR__ . '/../db.php'; //referencing the db.php file one level above the current folder

// Set headers
header("Access-Control-Allow-Origin: " . (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*'));
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        // Prepare statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['logged_in'] = true;
            
            // Log the successful login and session data
            error_log("Session ID: " . session_id());
            error_log("User logged in successfully. User ID: " . $user['id'] . ", Name: " . $user['name']);
            error_log("Session data after login: " . print_r($_SESSION, true));
            
            // Return success for AJAX
            echo json_encode([
                'success' => true, 
                'message' => 'Login successful!',
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name']
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect email or password!']);
        }
    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred during login.']);
    }
} else {
    // Handle non-POST requests
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
exit;
?>