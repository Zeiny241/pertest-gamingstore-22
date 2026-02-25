<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null; // Product ID for add, Wishlist ID for remove? Or just Product ID?
// Let's use simplified: remove by ID (wishlist_id) or add by Product ID.

if ($action === 'add' && $id) {
    // Check if already exists
    $stmt = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$_SESSION['user_id'], $id]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $id]);
    }
    header("Location: wishlist.php");
    exit;
}

if ($action === 'remove' && $id) {
    // ID here is wishlist.id
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    header("Location: wishlist.php");
    exit;
}

header("Location: index.php");
exit;
?>
