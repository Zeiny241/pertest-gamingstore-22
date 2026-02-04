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
        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, platform = ?, image = ? WHERE id = ?");
        if($stmt->execute([$name, $price, $platform, $image, $id])) {
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
    <h2 class="text-center mb-4" style="color: white;">Edit Hardware</h2>
    
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
                <option value="GPU" <?= $product['platform'] == 'GPU' ? 'selected' : '' ?>>Graphics Card (GPU)</option>
                <option value="CPU" <?= $product['platform'] == 'CPU' ? 'selected' : '' ?>>Processor (CPU)</option>
                <option value="Mainboard" <?= $product['platform'] == 'Mainboard' ? 'selected' : '' ?>>Motherboard</option>
                <option value="RAM" <?= $product['platform'] == 'RAM' ? 'selected' : '' ?>>RAM</option>
                <option value="Storage" <?= $product['platform'] == 'Storage' ? 'selected' : '' ?>>SSD / HDD</option>
                <option value="PowerSupply" <?= $product['platform'] == 'PowerSupply' ? 'selected' : '' ?>>Power Supply</option>
                <option value="Case" <?= $product['platform'] == 'Case' ? 'selected' : '' ?>>Case</option>
                <option value="Monitor" <?= $product['platform'] == 'Monitor' ? 'selected' : '' ?>>Monitor</option>
                <option value="Peripheral" <?= $product['platform'] == 'Peripheral' ? 'selected' : '' ?>>Keyboard/Mouse</option>
            </select>
        </div>

        <div class="form-group">
            <label>Image URL</label>
            <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($product['image']) ?>">
        </div>

        <div class="text-center">
            <button type="submit" class="btn">Update Game</button>
            <a href="index.php" style="margin-left: 20px; color: var(--text-muted);">Cancel</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
