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
        $stmt = $pdo->prepare("INSERT INTO products (name, price, platform, image) VALUES (?, ?, ?, ?)");
        if($stmt->execute([$name, $price, $platform, $image])) {
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
    <h2 class="text-center mb-4" style="color: white;">Add New Game</h2>
    
    <?php if($message): ?>
        <p style="color: #ff4757; text-align: center; margin-bottom: 20px;"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Game Title *</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Elden Ring">
        </div>

        <div class="form-group">
            <label>Price ($) *</label>
            <input type="number" step="0.01" name="price" class="form-control" required placeholder="59.99">
        </div>

        <div class="form-group">
            <label>Platform</label>
            <select name="platform" class="form-control" style="background: rgba(0,0,0,0.2); color:white; border: 1px solid rgba(255,255,255,0.1);">
                <option value="PC">PC</option>
                <option value="PlayStation 5">PlayStation 5</option>
                <option value="Xbox Series X">Xbox Series X</option>
                <option value="Switch">Nintendo Switch</option>
            </select>
        </div>

        <div class="form-group">
            <label>Image URL</label>
            <input type="text" name="image" class="form-control" placeholder="https://example.com/image.jpg">
        </div>

        <div class="text-center">
            <button type="submit" class="btn">Add Game</button>
            <a href="index.php" style="margin-left: 20px; color: var(--text-muted);">Cancel</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
