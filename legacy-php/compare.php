<?php
session_start();
require 'db.php';

$ids = $_GET['ids'] ?? '';
$product_ids = array_filter(explode(',', $ids));

if (count($product_ids) < 2) {
    // Show selection page if less than 2 products
    // For now, just show all products to select? 
    // Or just redirect to index.
    // MVP: Assume user clicks "Compare" on products and we build a link.
    // Let's make a simple selector if empty.
    include 'includes/header.php';
    echo '<div class="container" style="margin-top: 5rem; text-align: center;"><h1>เลือกสินค้าเพื่อเปรียบเทียบ</h1><p>กรุณาเลือกสินค้าจากหน้าเลือกซื้อ</p></div>';
    include 'includes/footer.php';
    exit;
}

$placeholders = implode(',', array_fill(0, count($product_ids), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute($product_ids);
$products = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="container" style="margin-top: 2rem;">
    <h1 class="page-title">เปรียบเทียบสินค้า</h1>
    
    <div class="card" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; color: white;">
            <tr>
                <th style="padding: 20px; text-align: left; width: 200px;">คุณสมบัติ</th>
                <?php foreach ($products as $p): ?>
                    <th style="padding: 20px; text-align: center;">
                        <img src="<?= htmlspecialchars($p['image']) ?>" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px; margin-bottom: 10px;"><br>
                        <?= htmlspecialchars($p['name']) ?>
                    </th>
                <?php endforeach; ?>
            </tr>
            <tr style="border-top: 1px solid rgba(255,255,255,0.1);">
                <td style="padding: 20px; font-weight: bold;">ราคา</td>
                <?php foreach ($products as $p): ?>
                    <td style="padding: 20px; text-align: center; font-size: 1.2rem; color: var(--primary);">$<?= number_format($p['price'], 2) ?></td>
                <?php endforeach; ?>
            </tr>
            <tr style="border-top: 1px solid rgba(255,255,255,0.1);">
                <td style="padding: 20px; font-weight: bold;">หมวดหมู่</td>
                <?php foreach ($products as $p): ?>
                    <td style="padding: 20px; text-align: center;"><?= htmlspecialchars($p['platform']) ?></td>
                <?php endforeach; ?>
            </tr>
            <tr style="border-top: 1px solid rgba(255,255,255,0.1);">
                <td style="padding: 20px; font-weight: bold;">รายละเอียด</td>
                <?php foreach ($products as $p): ?>
                    <td style="padding: 20px; vertical-align: top; font-size: 0.9rem; color: var(--text-muted);">
                        <?= nl2br(htmlspecialchars($p['description'] ?? '-')) ?>
                    </td>
                <?php endforeach; ?>
            </tr>
             <tr style="border-top: 1px solid rgba(255,255,255,0.1);">
                <td style="padding: 20px; font-weight: bold;">การดำเนินการ</td>
                <?php foreach ($products as $p): ?>
                    <td style="padding: 20px; text-align: center;">
                        <a href="product_details.php?id=<?= $p['id'] ?>" class="btn" style="font-size: 0.9rem;">ดูรายละเอียด</a>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
