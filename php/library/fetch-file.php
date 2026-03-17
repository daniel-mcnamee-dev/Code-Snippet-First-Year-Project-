<?php
require_once __DIR__ . '/../db.php'; //referencing the db.php file one level above the current folder

// Start session to get user ID
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $fileId = $_GET['id'];
    
    // Only allow the user to fetch their own files
    $stmt = $pdo->prepare("SELECT id, filename, content, folder_id FROM files WHERE id = ? AND user_id = ?");
    $stmt->execute([$fileId, $userId]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($file) {
        echo json_encode($file);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'File not found or you do not have permission to access it'
        ]);
    }
}
?>