<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
    $user_id = $_SESSION['user_id'];
    
    // Insert order
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, product_id, status) VALUES (?, ?, 'completed')");
    
    if($stmt->execute([$user_id, $id])) {
        // Redirect to profile or show success page
        header("Location: index.php?order_success=1");
        exit();
    } else {
        echo "Error placing order.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
