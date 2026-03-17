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

// Get the input data - check for both POST parameters and JSON input
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get ID from either POST or JSON input
    $id = isset($_POST['id']) ? $_POST['id'] : (isset($input['id']) ? $input['id'] : null);

    if (!empty($id)) {
        // Verify file belongs to current user before deleting
        $verifyStmt = $pdo->prepare("SELECT id FROM files WHERE id = ? AND user_id = ?");
        $verifyStmt->execute([$id, $userId]);
        
        if ($verifyStmt->rowCount() === 0) {
            echo json_encode([
                'success' => false, 
                'message' => 'You do not have permission to delete this file'
            ]);
            exit;
        }
        
        $stmt = $pdo->prepare("DELETE FROM files WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "ID is required"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>