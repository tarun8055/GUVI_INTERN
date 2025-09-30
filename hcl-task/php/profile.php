<?php
header('Content-Type: application/json');
require 'db.php';
require 'redis_helper.php';

$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    echo json_encode(['success' => false, 'error' => 'Authorization header missing']);
    exit;
}
if (!preg_match('/Bearer\s(\w+)/', $headers['Authorization'], $matches)) {
    echo json_encode(['success' => false, 'error' => 'Invalid token format']);
    exit;
}
$token = $matches[1];
$session = $redis->get('session:' . $token);
if (!$session) {
    echo json_encode(['success' => false, 'error' => 'Session expired or invalid']);
    exit;
}
$userData = json_decode($session, true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch profile
    $stmt = $pdo->prepare('SELECT name, email, age, dob, contact FROM users WHERE id = ?');
    $stmt->execute([$userData['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo json_encode(['success' => false, 'error' => 'User not found']);
        exit;
    }
    echo json_encode(['success' => true, 'user' => $user]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update profile (only name is editable in this example)
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['name'])) {
        echo json_encode(['success' => false, 'error' => 'Name is required']);
        exit;
    }
    $stmt = $pdo->prepare('UPDATE users SET name = ? WHERE id = ?');
    if ($stmt->execute([$data['name'], $userData['id']])) {
        // Optionally update Redis session data as well
        $userData['name'] = $data['name'];
        $redis->setex('session:' . $token, 3600, json_encode($userData));
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Update failed']);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid request method']);
exit;
?>
