<?php
require_once __DIR__ . '/../db.php'; //referencing the db.php file one level above the current folder
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $security_question = $_POST['security_question'];
    $security_answer = password_hash($_POST['security_answer'], PASSWORD_BCRYPT);

    try {
        // Check if email already exists
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $checkStmt->execute([$email]);
        $emailExists = $checkStmt->fetchColumn();
        
        if ($emailExists) {
            echo json_encode(['success' => false, 'message' => 'Email already registered!']);
            exit;
        }
        
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, security_question, security_answer) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$name, $email, $password, $security_question, $security_answer]);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Registration successful!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed.']);
        }
    } catch (PDOException $e) {
        error_log("Registration Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred during registration.']);
    }
}
?>