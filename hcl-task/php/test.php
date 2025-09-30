<?php
try {
  $pdo = new PDO('mysql:host=mysql;dbname=guvi', 'root', 'rootpassword');
  echo json_encode(["success" => true]);
} catch (Exception $e) {
  echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
