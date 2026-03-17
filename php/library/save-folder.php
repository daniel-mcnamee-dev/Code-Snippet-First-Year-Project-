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

// Sanitization function
function sanitizeInput($input) {
    $input = trim($input);
    $input = strip_tags($input);
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Validation function
function validateFolderName($foldername) {
    // Allow alphanumeric, spaces, hyphens, and underscores
    return preg_match('/^[a-zA-Z0-9 \-_]{1,50}$/', $foldername);
}

// Check if folder name is provided
$foldername = isset($_POST['foldername']) ? $_POST['foldername'] : null;

// Response array
$response = [
    'success' => false,
    'message' => ''
];

// Validate input
if (empty($foldername)) {
    $response['message'] = 'Folder name is required';
    echo json_encode($response);
    exit;
}

// Sanitize input
$sanitizedFolderName = sanitizeInput($foldername);

// Additional validation
if (!validateFolderName($sanitizedFolderName)) {
    $response['message'] = 'Invalid folder name. Use alphanumeric characters, spaces, hyphens, and underscores.';
    echo json_encode($response);
    exit;
}

try {
    // Check if we're updating an existing folder
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $folderId = intval($_POST['id']);
        
        // Verify folder belongs to current user
        $checkQuery = "SELECT id FROM folders WHERE id = ? AND user_id = ?";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([$folderId, $userId]);
        
        if ($checkStmt->rowCount() === 0) {
            $response['message'] = 'You do not have permission to modify this folder';
            echo json_encode($response);
            exit;
        }
        
        $query = "UPDATE folders SET foldername = :foldername WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':foldername' => $sanitizedFolderName,
            ':id' => $folderId,
            ':user_id' => $userId
        ]);
    } else {
        // Insert new folder with user id
        $query = "INSERT INTO folders (foldername, user_id, created_at) VALUES (:foldername, :user_id, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':foldername' => $sanitizedFolderName, 
            ':user_id' => $userId
        ]);
    }

    // Check if the operation was successful
    if ($stmt->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = isset($_POST['id']) ? 'Folder updated successfully' : 'Folder created successfully';
        if (!isset($_POST['id'])) {
            $response['folder_id'] = $pdo->lastInsertId();
        }
    } else {
        $response['message'] = 'No changes made or record not found';
    }
} catch (PDOException $e) {
    // Log the error
    error_log("Folder Operation Error: " . $e->getMessage());
    
    $response['message'] = 'Database error occurred';
    
    // Check for duplicate entry
    if ($e->getCode() == '23000') {
        $response['message'] = 'A folder with this name already exists for your account';
    }
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>