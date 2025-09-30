<?php
if (!class_exists('Redis')) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Redis extension not installed.']);
    exit;
}
$redis = new Redis();
try {
$redis->connect('guvi-redis', 6379); // 'redis' is the service name in docker-compose.yml
    // If you set a Redis password, add: $redis->auth('yourpassword');
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Redis connection failed.']);
    exit;
}
?>