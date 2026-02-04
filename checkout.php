<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch product
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: index.php");
    exit;
}

$price = $product['price'];
$discount = 0;
$final_price = $price;
$coupon_code = '';
$coupon_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['apply_coupon'])) {
        $coupon_code = $_POST['coupon_code'];
        if ($coupon_code === 'XD007') {
            $discount = $price * 0.20; // 20% discount
            $final_price = $price - $discount;
            $coupon_message = "Coupon applied! You saved $" . number_format($discount, 2);
        } else {
            $coupon_message = "Invalid coupon code.";
        }
    } elseif (isset($_POST['confirm_order'])) {
        $final_price = $_POST['final_price']; // In a real app, recalculate this backend-side!
        
        // Recalculate security check
        $coupon_submitted = $_POST['coupon_code_hidden'];
        if ($coupon_submitted === 'XD007') {
           $discount = $price * 0.20; 
           $final_price = $price - $discount;
        } else {
           $final_price = $price;
        }

        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, product_id, total_price, status) VALUES (?, ?, ?, 'completed')");
        if ($stmt->execute([$user_id, $id, $final_price])) {
            header("Location: index.php?order_success=1");
            exit;
        } else {
            $coupon_message = "Error placing order.";
        }
    }
}

include 'includes/header.php';
?>

<div class="form-container">
    <h2 class="text-center mb-4" style="color: white;">Checkout</h2>
    
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-body">
            <h3 class="card-title"><?= htmlspecialchars($product['name']) ?></h3>
            <p style="color: #ccc;"><?= htmlspecialchars($product['platform']) ?></p>
            <div class="card-price">$<?= number_format($product['price'], 2) ?></div>
        </div>
    </div>

    <?php if($coupon_message): ?>
        <p style="color: <?= strpos($coupon_message, 'applied') !== false ? '#2ecc71' : '#ff4757' ?>; text-align: center; margin-bottom: 20px;"><?= $coupon_message ?></p>
    <?php endif; ?>

    <form method="POST">
        <label style="color:white;">Coupon Code</label>
        <div style="display: flex; gap: 10px; margin-bottom: 20px;">
            <input type="text" name="coupon_code" class="form-control" value="<?= htmlspecialchars($coupon_code) ?>" placeholder="Enter code">
            <button type="submit" name="apply_coupon" class="btn" style="background: var(--secondary);">Apply</button>
        </div>
    </form>

    <div style="background: rgba(0,0,0,0.3); padding: 15px; border-radius: 10px; margin-bottom: 20px; color: white;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
            <span>Subtotal:</span>
            <span>$<?= number_format($price, 2) ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 5px; color: #2ecc71;">
            <span>Discount:</span>
            <span>-$<?= number_format($discount, 2) ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2rem; margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
            <span>Total:</span>
            <span>$<?= number_format($final_price, 2) ?></span>
        </div>
    </div>

    <form method="POST">
        <input type="hidden" name="final_price" value="<?= $final_price ?>">
        <input type="hidden" name="coupon_code_hidden" value="<?= htmlspecialchars($coupon_code) ?>">
        <div class="text-center">
            <button type="submit" name="confirm_order" class="btn" style="width: 100%; font-size: 1.2rem;">Confirm Purchase</button>
            <a href="index.php" style="display: block; margin-top: 15px; color: var(--text-muted);">Cancel</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
