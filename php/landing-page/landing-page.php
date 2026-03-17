<?php
require_once __DIR__ . '/../db.php'; //referencing the db.php file one level above the current folder
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
</head>
<body>
    <!-- Check if the user is logged in -->
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
        
        <p>Welcome, <?php echo $_SESSION['user_name']; ?>! You are logged in.</p>
        <a href="logout.php">Logout</a> <!-- Logout link -->

    <?php else: ?>

        <a href="login.php">Login</a>
        
    <?php endif; ?>
</body>
</html>