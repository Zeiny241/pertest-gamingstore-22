<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $platform = $_POST['platform'];
    $image = $_POST['image'];

    if(!empty($name) && !empty($price)) {
        $user_id = $_SESSION['user_id'];
        $description = $_POST['description'] ?? '';
        $stock = $_POST['stock'] ?? 10;
        
        $stmt = $pdo->prepare("INSERT INTO products (name, price, platform, image, user_id, description, stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if($stmt->execute([$name, $price, $platform, $image, $user_id, $description, $stock])) {
            header("Location: index.php");
            exit;
        } else {
            $message = "Error adding product.";
        }
    } else {
        $message = "Please fill in all required fields.";
    }
}

include 'includes/header.php';
?>

<div class="form-container">
    <h2 class="text-center mb-4" style="color: white;">Add New Gear</h2>
    
    <?php if($message): ?>
        <p style="color: #ff4757; text-align: center; margin-bottom: 20px;"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Razer DeathAdder V3">
        </div>

        <div class="form-group">
            <label>Price ($) *</label>
            <input type="number" step="0.01" name="price" class="form-control" required placeholder="149.99">
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="platform" class="form-control" style="background: rgba(0,0,0,0.2); color:white; border: 1px solid rgba(255,255,255,0.1);">
                <option value="Mouse">Gaming Mouse</option>
                <option value="Keyboard">Mechanical Keyboard</option>
                <option value="Headset">Headset</option>
                <option value="Monitor">Gaming Monitor</option>
                <option value="Chair">Gaming Chair</option>
                <option value="Controller">Controller</option>
                <option value="Accessories">Accessories</option>
            </select>
        </div>

        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" value="10" min="0" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Product details..."></textarea>
        </div>

        <div class="form-group">
            <label>Image URL</label>
            <input type="text" name="image" class="form-control" placeholder="https://example.com/image.jpg">
        </div>

        <div class="text-center">
            <button type="submit" class="btn">Add Gear</button>
            <a href="index.php" style="margin-left: 20px; color: var(--text-muted);">Cancel</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
