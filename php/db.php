<?php
try {

    $host = "aws-1-eu-west-1.pooler.supabase.com";
    $dbname = "postgres";
    $username = "postgres.pvrqdmjbezsbjvkxluie";
    $password = "YOUR_PASSWORD";
    $port = "5432";

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
