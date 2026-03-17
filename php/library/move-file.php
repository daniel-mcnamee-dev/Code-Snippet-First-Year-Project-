<?php
// Add proper content type header to ensure browser treats response as JSON
header('Content-Type: application/json');

// Disable error displaying to avoid HTML in the JSON response
ini_set('display_errors', 0);
error_reporting(0);

try {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if user is logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        throw new Exception('You must be logged in to perform this action.');
    }

    // Get the raw input data
    $inputData = file_get_contents('php://input');
    $data = json_decode($inputData, true);

    error_log("Raw input: " . $inputData);
    error_log("Decoded data: " . print_r($data, true));

    // Validate the data
    if (!isset($data['fileId']) || !isset($data['userId'])) {
        throw new Exception('Missing required parameters.');
    }

    // Verify that the user matches the session
    if ((int)$data['userId'] !== (int)$_SESSION['user_id']) {
        throw new Exception('Unauthorized action.');
    }
    
    // Connect to the database with the correct path
    require_once $_SERVER['DOCUMENT_ROOT'] . '/WebDevProject_WIP/php/db.php';

    // Begin transaction to ensure data integrity
    $pdo->beginTransaction();
    
    // First check if the file exists and belongs to the user
    $stmt = $pdo->prepare("SELECT id FROM files WHERE id = ? AND user_id = ?");
    $stmt->execute([$data['fileId'], $data['userId']]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$file) {
        throw new Exception('File not found or you do not have permission to move it.');
    }
    
    // If folderId is not null, check if the folder exists and belongs to the user
    if ($data['folderId'] !== null) {
        $stmt = $pdo->prepare("SELECT id FROM folders WHERE id = ? AND user_id = ?");
        $stmt->execute([$data['folderId'], $data['userId']]);
        $folder = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$folder) {
            throw new Exception('Destination folder not found or you do not have permission to use it.');
        }
    }
    
    // Update the file's folder_id
    $stmt = $pdo->prepare("UPDATE files SET folder_id = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$data['folderId'], $data['fileId'], $data['userId']]);
    
    // Commit the transaction
    $pdo->commit();
    
    // Return success response
    echo json_encode(['success' => true, 'message' => 'File moved successfully.']);
    
} catch (Exception $e) {
    // Roll back the transaction if it was started
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    // Return error as JSON
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}
?>