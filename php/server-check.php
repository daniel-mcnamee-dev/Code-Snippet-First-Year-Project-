<?php
// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check PHP version
echo "PHP Version: " . phpversion() . "<br>";

// Check database connection
try {
    $host = 'localhost';
    $dbname = 'webdevproject';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database Connection: Successful<br>";
    
    // Quick database check
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Database Tables:<br>";
    print_r($tables);
} catch (PDOException $e) {
    echo "Database Connection Failed: " . $e->getMessage() . "<br>";
}
?>