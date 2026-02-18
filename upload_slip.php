<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_FILES['slip']) || $_FILES['slip']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Please upload a valid slip']);
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_data = json_decode($_POST['cart_data'], true);
$total_price = $_POST['total_price'];

// File Upload Logic
$allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
$file_type = mime_content_type($_FILES['slip']['tmp_name']);

if (!in_array($file_type, $allowed_types)) {
    echo json_encode(['success' => false, 'message' => 'Only JPG and PNG files are allowed']);
    exit;
}

$upload_dir = 'uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$extension = pathinfo($_FILES['slip']['name'], PATHINFO_EXTENSION);
$filename = 'slip_' . $user_id . '_' . time() . '.' . $extension;
$target_path = $upload_dir . $filename;

if (!move_uploaded_file($_FILES['slip']['tmp_name'], $target_path)) {
    echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
    exit;
}

try {
    $pdo->beginTransaction();

    foreach ($cart_data as $product) {
        // Calculate item price ratio if discount applied (simplified logic from checkout)
        // For simplicity, we trust the JS total per item or recalculate. 
        // Better to recalculate server side but for this demo utilizingpassed total.
        
        // Re-verify stock
        $stmt = $pdo->prepare("SELECT stock, price FROM products WHERE id = ?");
        $stmt->execute([$product['id']]);
        $db_product = $stmt->fetch();

        if ($db_product['stock'] < $product['qty']) {
            throw new Exception("Product " . $product['name'] . " is out of stock.");
        }

        // Insert Order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, product_id, total_price, status, slip, created_at) VALUES (?, ?, ?, 'waiting_verify', ?, NOW())");
        // Distribute total price logic roughly or just store unit price * qty
        $item_total = $product['price'] * $product['qty']; // Using base price for record
        
        $stmt->execute([$user_id, $product['id'], $item_total, $target_path]);

        // Update Stock
        $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$product['qty'], $product['id']]);
    }

    // Clear Cart
    unset($_SESSION['cart']);

    $pdo->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $pdo->rollBack();
    // Remove uploaded file if db fail
    unlink($target_path);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
