<?php

$host = getenv("DB_HOST");
$dbname = getenv("DB_NAME");
$user = getenv("DB_USER");
$password = getenv("DB_PASS");
$port = getenv("DB_PORT");

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    header('Content-Type: application/json');
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}
