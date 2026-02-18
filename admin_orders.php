<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch all orders with user and product details
$stmt = $pdo->query("
    SELECT o.id, o.total_price, o.created_at, o.status, o.slip, u.username, p.name as product_name 
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
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px;">Date</th>
                    <th style="padding: 15px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 15px;">#<?= $order['id'] ?></td>
                        <td style="padding: 15px;"><?= htmlspecialchars($order['username']) ?></td>
                        <td style="padding: 15px;"><?= htmlspecialchars($order['product_name']) ?></td>
                        <td style="padding: 15px;">$<?= number_format($order['total_price'], 2) ?></td>
                        <td style="padding: 15px;">
                            <?php 
                                $statusColor = match($order['status'] ?? 'pending') {
                                    'pending' => 'orange',
                                    'waiting_verify' => 'var(--primary)',
                                    'completed', 'paid' => '#2ecc71',
                                    'cancelled' => 'red',
                                    default => 'white'
                                };
                                echo '<span style="color:'.$statusColor.'">'.ucfirst($order['status'] ?? 'pending').'</span>';
                            ?>
                        </td>
                        <td style="padding: 15px;"><?= $order['created_at'] ?></td>
                        <td style="padding: 15px;">
                            <?php if(!empty($order['slip'])): ?>
                                <button onclick="viewSlip('<?= htmlspecialchars($order['slip']) ?>')" class="btn" style="padding: 5px 10px; font-size: 0.8rem;">View Slip</button>
                            <?php else: ?>
                                <span style="color: var(--text-muted);">-</span>
                            <?php endif; ?>
                            
                            <?php if(($order['status'] ?? 'pending') == 'waiting_verify'): ?>
                                <a href="update_order.php?id=<?= $order['id'] ?>&status=paid" class="btn" style="padding: 5px 10px; font-size: 0.8rem; background: #2ecc71;">Confirm</a>
                                <a href="update_order.php?id=<?= $order['id'] ?>&status=cancelled" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;">Reject</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Slip Modal -->
        <div id="slipModal" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.8); z-index: 2000; justify-content: center; align-items: center;">
            <div style="position: relative; max-width: 90%; max-height: 90%;">
                <span onclick="document.getElementById('slipModal').style.display='none'" style="position: absolute; top: -40px; right: 0; color: white; font-size: 30px; cursor: pointer;">&times;</span>
                <img id="slipImage" src="" style="max-width: 100%; max-height: 80vh; border-radius: 10px;">
            </div>
        </div>
        
        <script>
        function viewSlip(url) {
            document.getElementById('slipImage').src = url;
            document.getElementById('slipModal').style.display = 'flex';
        }
        </script>
        </table>
        <?php if(count($orders) === 0): ?>
            <p class="text-center" style="padding: 2rem; color: var(--text-muted);">No orders found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
