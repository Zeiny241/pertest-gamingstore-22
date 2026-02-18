<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;
$status = $_GET['status'] ?? null;

if ($id && $status) {
    if (in_array($status, ['paid', 'cancelled'])) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
}

header("Location: admin_orders.php");
exit();
?>
