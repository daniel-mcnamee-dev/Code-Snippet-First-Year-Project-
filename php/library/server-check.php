<?php
// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Detailed database connection debugging
$host = 'localhost';
$dbname = 'webdevproj';
$username = 'root';
$password = '';

echo "Attempting to connect with:<br>";
echo "Host: $host<br>";
echo "Database: $dbname<br>";
echo "Username: $username<br>";
echo "Password: [hidden]<br><br>";

try {
    // Try PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "PDO Connection: Successful<br>";
    
    // Try mysqli connection as alternative
    $mysqli = new mysqli($host, $username, $password, $dbname);
    
    if ($mysqli->connect_errno) {
        echo "MySQLi Connection Failed: " . $mysqli->connect_error . "<br>";
    } else {
        echo "MySQLi Connection: Successful<br>";
    }
    
    // List databases
    $stmt = $pdo->query("SHOW DATABASES");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<br>Available Databases:<br>";
    foreach ($databases as $db) {
        echo "- $db<br>";
    }

} catch (PDOException $e) {
    echo "PDO Connection Error: [" . $e->getCode() . "] " . $e->getMessage() . "<br>";
    
    // Additional debugging for connection issues
    try {
        // Try connecting without specifying database
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "<br>Base Connection Successful. Database Selection Failed.<br>";
        
        // List available databases
        $stmt = $pdo->query("SHOW DATABASES");
        $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "Available Databases:<br>";
        foreach ($databases as $db) {
            echo "- $db<br>";
        }
        
    } catch (PDOException $baseConnectError) {
        echo "Base Connection Failed: " . $baseConnectError->getMessage() . "<br>";
    }
}
?>