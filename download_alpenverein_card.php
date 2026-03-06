<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

if (empty($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

require_once __DIR__ . '/admin/db.php';

$userId = (int)$_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT card FROM `user` WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

$card = (string)($row['card'] ?? '');
if ($card === '') {
  http_response_code(404);
  header('Content-Type: text/plain; charset=UTF-8');
  echo "No card uploaded for this user.";
  exit;
}

// Expected stored value: uploads/cards/xxxx.pdf (saved from admin)
$card = ltrim($card, '/');

// Resolve physical file path (because uploads folder is inside /admin)
$baseDir = realpath(__DIR__ . '/admin/uploads/cards');
$filePath = realpath(__DIR__ . '/admin/' . $card);

if (!$baseDir || !$filePath || strpos($filePath, $baseDir) !== 0 || !is_file($filePath)) {
  http_response_code(404);
  header('Content-Type: text/plain; charset=UTF-8');
  echo "Card file not found.";
  exit;
}

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Alpenverein-Card-' . $userId . '.pdf"');
header('Content-Length: ' . filesize($filePath));

readfile($filePath);
exit;
