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
        <h1>ยินดีต้อนรับสู่ TechHardware</h1>
        <p>แหล่งรวมอุปกรณ์คอมพิวเตอร์ครบวงจร GPU, CPU, Mainboard และอื่นๆ</p>
        <?php if(!isset($_SESSION['user_id'])): ?>
            <a href="register.php" class="btn">เริ่มต้นใช้งาน</a>
        <?php else: ?>
            <a href="#products" class="btn">เลือกชมสินค้า</a>
        <?php endif; ?>

        <form action="index.php" method="GET" style="margin-top: 2rem; display: flex; justify-content: center; gap: 10px;">
            <input type="text" name="search" placeholder="ค้นหาสินค้า..." class="form-control" style="width: 300px; background: rgba(255,255,255,0.1);">
            <select name="category" class="form-control" style="width: 150px; background: rgba(255,255,255,0.1); color: white;">
                <option value="">ทุกหมวดหมู่</option>
                <option value="GPU">GPU</option>
                <option value="CPU">CPU</option>
                <option value="Mainboard">Mainboard</option>
                <option value="RAM">RAM</option>
                <option value="Storage">SSD / HDD</option>
                <option value="Monitor">Monitor</option>
                <option value="Peripheral">Peripheral</option>
            </select>
            <button type="submit" class="btn" style="border-radius: 12px;">ค้นหา</button>
        </form>
    </div>
</section>

<h1 class="page-title" id="products">สินค้าแนะนำ</h1>

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