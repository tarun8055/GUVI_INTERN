<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require 'db.php';
require 'redis_helper.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['email'], $data['password'])) {
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit;
}

$email = trim($data['email']);
$password = $data['password'];

$stmt = $pdo->prepare('SELECT id, name, email, password, age, dob, contact FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
    exit;
}

// Generate a secure random token
$token = bin2hex(random_bytes(32));
// Store session in Redis (key: token, value: user info except password)
$sessionData = [
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'age' => $user['age'],
    'dob' => $user['dob'],
    'contact' => $user['contact']
];
$redis->setex('session:' . $token, 3600, json_encode($sessionData)); // 1 hour expiry

echo json_encode(['success' => true, 'token' => $token]);
?>