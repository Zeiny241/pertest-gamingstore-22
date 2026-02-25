<?php
session_start();
require 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found.";
    exit;
}

include 'includes/header.php';
?>

<div class="container" style="margin-top: 4rem; margin-bottom: 4rem;">
    <div style="display: flex; flex-wrap: wrap; gap: 4rem; justify-content: center;">
        
        <!-- Product Image -->
        <div style="flex: 1; min-width: 300px; max-width: 500px;">
            <div class="card" style="padding: 1rem; border-radius: 20px;">
                <?php if ($product['image']): ?>
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: auto; border-radius: 15px; object-fit: cover;">
                <?php else: ?>
                    <div style="width: 100%; height: 400px; background: #333; display: flex; align-items: center; justify-content: center; border-radius: 15px;">No Image</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Info -->
        <div style="flex: 1; min-width: 300px;">
            <span class="card-platform" style="font-size: 1rem; margin-bottom: 1rem; display: inline-block;"><?= htmlspecialchars($product['platform']) ?></span>
            <h1 style="font-size: 3rem; font-weight: 800; line-height: 1.2; margin-bottom: 1rem;"><?= htmlspecialchars($product['name']) ?></h1>
            <p style="font-size: 2.5rem; color: var(--primary); font-weight: 700; margin-bottom: 2rem;">$<?= number_format($product['price'], 2) ?></p>

            <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 15px; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 10px; color: var(--text-color);">Product Details</h3>
                <p style="color: var(--text-muted); line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($product['description'] ?? 'No description available.')) ?>
                </p>
            </div>

            <form action="cart_action.php" method="POST" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="action" value="add">
                
                <div style="display: flex; align-items: center; background: rgba(255,255,255,0.1); border-radius: 50px; padding: 5px 15px;">
                    <span style="margin-right: 10px; color: var(--text-muted);">Quantity:</span>
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" style="width: 60px; background: transparent; border: none; color: white; font-size: 1.2rem; font-weight: bold; text-align: center;">
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn" style="padding: 12px 30px; font-size: 1.1rem;">Add to Cart</button>
                    <a href="wishlist_action.php?action=add&id=<?= $product['id'] ?>" class="btn" style="padding: 12px 20px; font-size: 1.1rem; background: #e91e63;">❤ Wishlist</a>
                </div>
            </form>
            
            <div style="margin-top: 2rem;">
                <?php if ($product['stock'] > 0): ?>
                    <h4 style="color: var(--text-muted);">Stock: <span style="color:#2ecc71">In Stock (<?= $product['stock'] ?>)</span></h4>
                <?php else: ?>
                    <h4 style="color: var(--text-muted);">Stock: <span style="color:#ef4444">Out of Stock</span></h4>
                <?php endif; ?>
            </div>
            
            <a href="index.php" style="display: inline-block; margin-top: 2rem; color: var(--text-muted);">&larr; Back to Products</a>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
