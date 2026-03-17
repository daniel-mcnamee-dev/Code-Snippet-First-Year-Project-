<?php
// Enable detailed error reporting for debugging
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

// Improved error handling
try {
    // Prepare and execute query with improved error handling
    // Only fetch folders belonging to the current user
    $query = "SELECT id, foldername, created_at 
              FROM folders 
              WHERE user_id = :user_id
              ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([':user_id' => $userId]);
    
    $folders = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Sanitize each field before adding to results
        $folders[] = [
            'id' => (int)$row['id'],
            'foldername' => sanitizeOutput($row['foldername']),
            'created_at' => $row['created_at']
        ];
    }
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'folders' => $folders,
        'debug_info' => [
            'query' => $query,
            'folder_count' => count($folders)
        ]
    ]);
} catch (PDOException $e) {
    // Log error and return detailed error response
    error_log("Fetch Folders Error: " . $e->getMessage());
    
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal server error',
        'error' => $e->getMessage(),
        'error_code' => $e->getCode(),
        'error_trace' => $e->getTraceAsString()
    ]);
} catch (Exception $e) {
    // Catch any other unexpected errors
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unexpected error occurred',
        'error' => $e->getMessage(),
        'error_trace' => $e->getTraceAsString()
    ]);
}
?>