<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

// Sanitization and validation function
function sanitizeInput($input) {
    $input = trim($input);
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

function validateFileName($filename) {
    // Allow alphanumeric characters, spaces, hyphens, underscores, and periods
    return preg_match('/^[a-zA-Z0-9 _\-\.]+$/', $filename);
}

// Get the JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

// Input validation
if (empty($data['filename']) || empty($data['content'])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Filename and content are required'
    ]);
    exit;
}

// Sanitize inputs
$filename = sanitizeInput($data['filename']);
$content = sanitizeInput($data['content']);
$folderId = !empty($data['folderId']) ? intval($data['folderId']) : null;

// Additional filename validation
if (!validateFileName($filename)) {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid filename format'
    ]);
    exit;
}

try {
    // Check if we're updating an existing file
    if (!empty($data['id'])) {
        $fileId = intval($data['id']);
        
        // Verify file belongs to current user
        $checkQuery = "SELECT id FROM files WHERE id = ? AND user_id = ?";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([$fileId, $userId]);
        
        if ($checkStmt->rowCount() === 0) {
            echo json_encode([
                'success' => false, 
                'message' => 'You do not have permission to modify this file'
            ]);
            exit;
        }
        
        $query = "UPDATE files SET filename = ?, content = ?, folder_id = ? WHERE id = ? AND user_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$filename, $content, $folderId, $fileId, $userId]);
    } else {
        // Insert new file
        $query = "INSERT INTO files (filename, content, folder_id, user_id, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$filename, $content, $folderId, $userId]);
    }

    // Check if the operation was successful
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'No changes made or record not found'
        ]);
    }
} catch (PDOException $e) {
    // Output error message if the query fails
    echo json_encode([
        'success' => false, 
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>