<?php
require_once __DIR__ . '/../config.php';

function get_pdo_connection() {
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }
    
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
    }
}
?>




