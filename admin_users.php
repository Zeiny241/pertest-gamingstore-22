<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch users and their order stats
$stmt = $pdo->query("
    SELECT u.id, u.username, u.fullname, u.email, 
           COUNT(o.id) as order_count, 
           COALESCE(SUM(o.total_price), 0) as total_spent 
    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id AND o.status = 'completed'
    GROUP BY u.id
    ORDER BY total_spent DESC
");
$users = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="container" style="margin-top: 2rem;">
    <h1 class="page-title">Customer Statistics</h1>

    <div class="card" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; color: white;">
            <thead>
                <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                    <th style="padding: 15px;">User ID</th>
                    <th style="padding: 15px;">Username</th>
                    <th style="padding: 15px;">Full Name</th>
                    <th style="padding: 15px;">Email</th>
                    <th style="padding: 15px;">Orders</th>
                    <th style="padding: 15px;">Total Spent</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 15px;">#<?= $user['id'] ?></td>
                        <td style="padding: 15px;"><?= htmlspecialchars($user['username']) ?></td>
                        <td style="padding: 15px;"><?= htmlspecialchars($user['fullname'] ?? '-') ?></td>
                        <td style="padding: 15px;"><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                        <td style="padding: 15px;"><?= $user['order_count'] ?></td>
                        <td style="padding: 15px; color: #2ecc71; font-weight: bold;">$<?= number_format($user['total_spent'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
