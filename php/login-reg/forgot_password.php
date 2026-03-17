<?php
// Turn off error display for production
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Start session
session_start();

require_once __DIR__ . '/../db.php'; //referencing the db.php file one level above the current folder

// Set headers
header("Access-Control-Allow-Origin: " . (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*'));
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    
    switch ($action) {
        case 'verifyEmail':
            try {
                // Check if email exists and get security question
                $stmt = $pdo->prepare("SELECT id, security_question FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                if ($user) {
                    // Return the security question
                    $questionText = '';
                    switch ($user['security_question']) {
                        case 'pet':
                            $questionText = 'What was your first pet\'s name?';
                            break;
                        case 'school':
                            $questionText = 'What was the name of your first school?';
                            break;
                        case 'city':
                            $questionText = 'What city were you born in?';
                            break;
                        case 'maiden':
                            $questionText = 'What was your mother\'s maiden name?';
                            break;
                        default:
                            $questionText = 'What was your mother\'s maiden name?';
                    }
                    
                    echo json_encode([
                        'success' => true,
                        'security_question' => $questionText
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Email not found.'
                    ]);
                }
            } catch (PDOException $e) {
                error_log("Forgot Password Error: " . $e->getMessage());
                echo json_encode([
                    'success' => false,
                    'message' => 'An error occurred while verifying your email.'
                ]);
            }
            break;
            
        case 'verifyAnswer':
            $securityAnswer = isset($_POST['security_answer']) ? $_POST['security_answer'] : '';
            
            try {
                // Get the stored security answer
                $stmt = $pdo->prepare("SELECT id, security_answer FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($securityAnswer, $user['security_answer'])) {
                    // Answer is correct
                    echo json_encode([
                        'success' => true,
                        'message' => 'Security answer verified.'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Incorrect security answer.'
                    ]);
                }
            } catch (PDOException $e) {
                error_log("Forgot Password Error: " . $e->getMessage());
                echo json_encode([
                    'success' => false,
                    'message' => 'An error occurred while verifying your answer.'
                ]);
            }
            break;
            
        case 'resetPassword':
            $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            
            try {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                
                // Update the password in the database
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
                $result = $stmt->execute([$hashedPassword, $email]);
                
                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Password has been reset successfully.'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to reset password.'
                    ]);
                }
            } catch (PDOException $e) {
                error_log("Forgot Password Error: " . $e->getMessage());
                echo json_encode([
                    'success' => false,
                    'message' => 'An error occurred while resetting your password.'
                ]);
            }
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action.'
            ]);
    }
} else {
    // Invalid request method
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}