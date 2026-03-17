<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../db.php'; //referencing the db.php file one level above the current folder

// Start session to get user ID
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

// Function to sanitize output
function sanitizeOutput($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

try {
    // Prepare and execute query with improved error handling
    // Only fetch files belonging to the current user
    $query = "SELECT id, filename, content, folder_id, created_at 
              FROM files 
              WHERE user_id = :user_id
              ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([':user_id' => $userId]);
    
    $files = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Sanitize each field before adding to results
        $files[] = [
            'id' => (int)$row['id'],
            'filename' => sanitizeOutput($row['filename']),
            'content' => sanitizeOutput($row['content']),
            'folder_id' => $row['folder_id'] ? (int)$row['folder_id'] : null,
            'created_at' => $row['created_at']
        ];
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'files' => $files
    ]);
} catch (PDOException $e) {
    // Log error and return error response
    error_log("Fetch Files Error: " . $e->getMessage());
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal server error',
        'error' => $e->getMessage()
    ]);
}
?>