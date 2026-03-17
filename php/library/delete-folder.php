<?php
require_once __DIR__ . '/../db.php'; //referencing the db.php file one level above the current folder

// Set content type header for JSON response
header('Content-Type: application/json');

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

// Response array
$response = [
    'success' => false,
    'message' => ''
];

// Get input data - check for both POST parameters and JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
$folderId = isset($_POST['id']) ? intval($_POST['id']) : (isset($input['id']) ? intval($input['id']) : null);

if (!$folderId) {
    $response['message'] = 'Invalid folder ID';
    echo json_encode($response);
    exit;
}

// Verify folder belongs to current user
$verifyStmt = $pdo->prepare("SELECT id FROM folders WHERE id = ? AND user_id = ?");
$verifyStmt->execute([$folderId, $userId]);

if ($verifyStmt->rowCount() === 0) {
    $response['message'] = 'You do not have permission to delete this folder';
    echo json_encode($response);
    exit;
}

try {
    // Start a transaction
    $pdo->beginTransaction();

    // First, delete all files in the folder that belong to this user
    $deleteFilesQuery = "DELETE FROM files WHERE folder_id = :folder_id AND user_id = :user_id";
    $deleteFilesStmt = $pdo->prepare($deleteFilesQuery);
    $deleteFilesStmt->execute([
        ':folder_id' => $folderId,
        ':user_id' => $userId
    ]);

    // Then, delete the folder itself
    $deleteFolderQuery = "DELETE FROM folders WHERE id = :folder_id AND user_id = :user_id";
    $deleteFolderStmt = $pdo->prepare($deleteFolderQuery);
    $deleteFolderStmt->execute([
        ':folder_id' => $folderId,
        ':user_id' => $userId
    ]);

    // Commit the transaction
    $pdo->commit();

    // Prepare success response
    $response['success'] = true;
    $response['message'] = 'Folder and its contents deleted successfully';
} catch (PDOException $e) {
    // Rollback the transaction
    $pdo->rollBack();

    // Log the error
    error_log("Folder Deletion Error: " . $e->getMessage());

    // Prepare error response
    $response['message'] = 'Failed to delete folder';
}

// Send JSON response
echo json_encode($response);
?>