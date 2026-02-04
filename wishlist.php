<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT p.*, w.id as wishlist_id 
    FROM wishlist w 
    JOIN products p ON w.product_id = p.id 
    WHERE w.user_id = ? 
    ORDER BY w.created_at DESC
");
$stmt->execute([$user_id]);
$products = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="container" style="margin-top: 2rem;">
    <h1 class="page-title">รายการสิ่งที่อยากได้ (Wishlist)</h1>

    <?php if (empty($products)): ?>
        <p class="text-center" style="color: var(--text-muted);">คุณยังไม่มีสินค้าในรายการสิ่งที่อยากได้</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <?php if ($product['image']): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="card-img">
                    <?php else: ?>
                        <div class="card-img" style="background: #333; display: flex; align-items: center; justify-content: center;">No Image</div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <span class="card-platform"><?= htmlspecialchars($product['platform']) ?></span>
                        <h3 class="card-title"><?= htmlspecialchars($product['name']) ?></h3>
                        
                        <div class="card-actions">
                            <div class="card-price">$<?= number_format($product['price'], 2) ?></div>
                            <div style="display: flex; gap: 5px;">
                                <a href="product_details.php?id=<?= $product['id'] ?>" class="btn" style="padding: 5px 10px; font-size: 0.8rem;">ดูสินค้า</a>
                                <a href="wishlist_action.php?action=remove&id=<?= $product['wishlist_id'] ?>" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;">ลบ</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
