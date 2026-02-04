<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    include 'includes/header.php';
    echo '<div class="container text-center" style="margin-top: 5rem;">
            <h1>ตะกร้าสินค้าว่างเปล่า</h1>
            <a href="index.php" class="btn mt-4">เลือกซื้อสินค้า</a>
          </div>';
    include 'includes/footer.php';
    exit;
}

$cart_items = $_SESSION['cart'];
$ids = implode(',', array_keys($cart_items));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
$products = $stmt->fetchAll();

$total_price = 0;

include 'includes/header.php';
?>

<div class="container" style="margin-top: 2rem;">
    <h1 class="page-title">ตะกร้าสินค้า</h1>

    <div class="card" style="padding: 0;">
        <table style="width: 100%; border-collapse: collapse; color: white;">
            <thead>
                <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                    <th style="padding: 15px;">สินค้า</th>
                    <th style="padding: 15px;">ราคา</th>
                    <th style="padding: 15px;">จำนวน</th>
                    <th style="padding: 15px;">รวม</th>
                    <th style="padding: 15px;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): 
                    $qty = $cart_items[$product['id']];
                    $subtotal = $product['price'] * $qty;
                    $total_price += $subtotal;
                ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <?php if ($product['image']): ?>
                                    <img src="<?= htmlspecialchars($product['image']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                <?php endif; ?>
                                <div>
                                    <div style="font-weight: bold;"><?= htmlspecialchars($product['name']) ?></div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);"><?= htmlspecialchars($product['platform']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px;">$<?= number_format($product['price'], 2) ?></td>
                        <td style="padding: 15px;">
                            <form action="cart_action.php" method="POST" style="display: flex; gap: 5px;">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="number" name="quantity" value="<?= $qty ?>" min="1" style="width: 60px; padding: 5px; border-radius: 5px; border: none;">
                                <button type="submit" class="btn" style="padding: 5px 10px; font-size: 0.8rem;">อัปเดต</button>
                            </form>
                        </td>
                        <td style="padding: 15px; color: #2ecc71;">$<?= number_format($subtotal, 2) ?></td>
                        <td style="padding: 15px;">
                            <a href="cart_action.php?action=remove&id=<?= $product['id'] ?>" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;">ลบ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
        <div class="card" style="width: 300px; padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 1.2rem; font-weight: bold;">
                <span>ยอดรวมทั้งหมด:</span>
                <span style="color: var(--primary);">$<?= number_format($total_price, 2) ?></span>
            </div>
            <a href="checkout.php" class="btn" style="width: 100%; text-align: center;">ดำเนินการชำระเงิน</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
