<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$product_id = $_POST['product_id'] ?? $_GET['id'] ?? null;
$quantity = (int)($_POST['quantity'] ?? 1);

if ($action === 'add' && $product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    header("Location: cart.php");
    exit;
}

if ($action === 'remove' && $product_id) {
    unset($_SESSION['cart'][$product_id]);
    header("Location: cart.php");
    exit;
}

if ($action === 'update' && $product_id) {
    if ($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: cart.php");
    exit;
}

header("Location: index.php");
exit;
?>
