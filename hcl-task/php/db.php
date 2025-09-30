<?php
$host = 'mysql'; // or 'mysql' if using Docker Compose
$db   = 'guvi';
$user = 'root';
$pass = 'rootpassword'; // set this to your MySQL root password
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit;
}
?>
