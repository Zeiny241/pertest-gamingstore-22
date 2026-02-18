<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: index.php");
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $platform = $_POST['platform'];
    $image = $_POST['image'];

    if(!empty($name) && !empty($price)) {
        $description = $_POST['description'] ?? '';
        $stock = $_POST['stock'] ?? 10;
        
        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, platform = ?, image = ?, description = ?, stock = ? WHERE id = ?");
        if($stmt->execute([$name, $price, $platform, $image, $description, $stock, $id])) {
            header("Location: index.php");
            exit;
        } else {
            $message = "Error updating product.";
        }
    } else {
        $message = "Please fill in all required fields.";
    }
}

include 'includes/header.php';
?>

<div class="form-container">
    <h2 class="text-center mb-4" style="color: white;">Edit Gear</h2>
    
    <?php if($message): ?>
        <p style="color: #ff4757; text-align: center; margin-bottom: 20px;"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <div class="form-group">
            <label>Price ($) *</label>
            <input type="number" step="0.01" name="price" class="form-control" required value="<?= htmlspecialchars($product['price']) ?>">
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="platform" class="form-control" style="background: rgba(0,0,0,0.2); color:white; border: 1px solid rgba(255,255,255,0.1);">
                <option value="Mouse" <?= $product['platform'] == 'Mouse' ? 'selected' : '' ?>>Gaming Mouse</option>
                <option value="Keyboard" <?= $product['platform'] == 'Keyboard' ? 'selected' : '' ?>>Mechanical Keyboard</option>
                <option value="Headset" <?= $product['platform'] == 'Headset' ? 'selected' : '' ?>>Headset</option>
                <option value="Monitor" <?= $product['platform'] == 'Monitor' ? 'selected' : '' ?>>Gaming Monitor</option>
                <option value="Chair" <?= $product['platform'] == 'Chair' ? 'selected' : '' ?>>Gaming Chair</option>
                <option value="Controller" <?= $product['platform'] == 'Controller' ? 'selected' : '' ?>>Controller</option>
                <option value="Accessories" <?= $product['platform'] == 'Accessories' ? 'selected' : '' ?>>Accessories</option>
            </select>
        </div>

        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" min="0" required value="<?= htmlspecialchars($product['stock'] ?? 10) ?>">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label>Image URL</label>
            <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($product['image']) ?>">
        </div>

        <div class="text-center">
            <button type="submit" class="btn">Update Gear</button>
            <a href="index.php" style="margin-left: 20px; color: var(--text-muted);">Cancel</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
