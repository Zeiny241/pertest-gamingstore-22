<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch all orders with user and product details
$stmt = $pdo->query("
    SELECT o.id, o.total_price, o.created_at, u.username, p.name as product_name 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN products p ON o.product_id = p.id
    ORDER BY o.created_at DESC
");
$orders = $stmt->fetchAll();

// Calculate Total Revenue
$total_revenue = 0;
foreach ($orders as $order) {
    // If total_price is null (old orders), we might want to fetch product price, but for now treat as 0 or handle logic
    // Assuming new orders have price.
    $total_revenue += $order['total_price'] ?? 0;
}

include 'includes/header.php';
?>

<div class="container" style="margin-top: 2rem;">
    <h1 class="page-title">Sales Dashboard</h1>

    <div class="grid" style="grid-template-columns: 1fr; margin-bottom: 2rem;">
        <div class="card" style="text-align: center; padding: 2rem;">
            <h3 style="color: var(--text-muted);">Total Revenue</h3>
            <div style="font-size: 3rem; color: #2ecc71; font-weight: bold;">
                $<?= number_format($total_revenue, 2) ?>
            </div>
        </div>
    </div>

    <div class="card" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; color: white;">
            <thead>
                <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                    <th style="padding: 15px;">Order ID</th>
                    <th style="padding: 15px;">Customer</th>
                    <th style="padding: 15px;">Product</th>
                    <th style="padding: 15px;">Amount Paid</th>
                    <th style="padding: 15px;">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 15px;">#<?= $order['id'] ?></td>
                        <td style="padding: 15px;"><?= htmlspecialchars($order['username']) ?></td>
                        <td style="padding: 15px;"><?= htmlspecialchars($order['product_name']) ?></td>
                        <td style="padding: 15px;">$<?= number_format($order['total_price'], 2) ?></td>
                        <td style="padding: 15px;"><?= $order['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if(count($orders) === 0): ?>
            <p class="text-center" style="padding: 2rem; color: var(--text-muted);">No orders found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
