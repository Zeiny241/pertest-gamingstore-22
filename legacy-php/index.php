<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'includes/header.php';

// Fetch products with search and filter
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($search) {
    $sql .= " AND name LIKE ?";
    $params[] = "%$search%";
}

if ($category) {
    $sql .= " AND platform = ?";
    $params[] = $category;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<section class="hero">
    <div class="container">
        <h1>Level Up Your Setup</h1>
        <p>The Ultimate Destination for High-Performance Gaming Gear.</p>
        <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn">Join the Squad</a>
        <?php else: ?>
            <a href="#products" class="btn">Shop Now</a>
        <?php endif; ?>

        <form action="index.php" method="GET" style="margin-top: 2rem; display: flex; justify-content: center; gap: 10px;">
            <input type="text" name="search" placeholder="ค้นหาสินค้า..." class="form-control" style="width: 300px; background: rgba(255,255,255,0.1);">
            <select name="category" class="form-control" style="width: 150px; background: rgba(255,255,255,0.1); color: white;">
                <option value="">All Categories</option>
                <option value="Mouse">Gaming Mouse</option>
                <option value="Keyboard">Mechanical Keyboard</option>
                <option value="Headset">Headset</option>
                <option value="Monitor">Gaming Monitor</option>
                <option value="Chair">Gaming Chair</option>
                <option value="Controller">Controller</option>
                <option value="Accessories">Accessories</option>
            </select>
            <button type="submit" class="btn" style="border-radius: 12px;">ค้นหา</button>
        </form>
    </div>
</section>

<h1 class="page-title" id="products">New Arrivals</h1>

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
                            <a href="product_details.php?id=<?= $product['id'] ?>" class="btn" style="padding: 5px 15px; font-size: 0.9rem; background: var(--secondary);">รายละเอียด</a>
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