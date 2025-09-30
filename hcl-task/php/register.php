<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['name'], $data['email'], $data['password'], $data['age'], $data['dob'], $data['contact'])) {
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit;
}

$name = trim($data['name']);
$email = trim($data['email']);
$password = $data['password'];
$age = intval($data['age']);
$dob = trim($data['dob']);
$contact = trim($data['contact']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid email']);
    exit;
}
if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'error' => 'Password must be at least 6 characters']);
    exit;
}
if ($age < 1) {
    echo json_encode(['success' => false, 'error' => 'Invalid age']);
    exit;
}
if (strlen($contact) < 10) {
    echo json_encode(['success' => false, 'error' => 'Invalid contact']);
    exit;
}

// Check if email already exists
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'error' => 'Email already exists']);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (name, email, password, age, dob, contact) VALUES (?, ?, ?, ?, ?, ?)');
if ($stmt->execute([$name, $email, $hash, $age, $dob, $contact])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Registration failed']);
}
?>
