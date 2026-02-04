<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'includes/header.php';

// Fetch products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<section class="hero">
    <div class="container">
        <h1>Welcome to TechHardware Store</h1>
        <p>Your one-stop shop for the best PC components: GPUs, CPUs, Mainboards, and more.</p>
        <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn">Get Started</a>
        <?php else: ?>
            <a href="#products" class="btn">Browse Hardware</a>
        <?php endif; ?>
    </div>
</section>

<h1 class="page-title" id="products">Featured Hardware</h1>

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
                    <div>
                        <a href="buy.php?id=<?= $product['id'] ?>" class="btn" style="padding: 5px 15px; font-size: 0.9rem; background: var(--secondary);">Buy Now</a>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="edit.php?id=<?= $product['id'] ?>" class="btn" style="padding: 5px 10px; font-size: 0.8rem;">Edit</a>
                            <button onclick="confirmDelete(<?= $product['id'] ?>)" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;">Delete</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (count($products) === 0): ?>
    <div class="text-center mt-4">
        <p style="color: var(--text-muted);">No games found in the store.</p>
        <br>
        <a href="create.php" class="btn">Add Your First Game</a>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>