<?php
try {

    $host = getenv("DB_HOST");
    $dbname = getenv("DB_NAME");
    $username = getenv("DB_USER");
    $password = getenv("DB_PASS");
    $port = getenv("DB_PORT");

    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    error_log("Database Connection Error: " . $e->getMessage());
    die("Database connection failed.");

}
?>
