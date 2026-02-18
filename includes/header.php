<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Store</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <div class="container">
        <nav>
            <a href="index.php" class="logo">GG<span style="color: var(--primary);">Store</span></a>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="create.php" class="btn">Add Gear</a>
                    <a href="admin_orders.php" class="btn" style="background: var(--secondary);">Orders</a>
                    <a href="admin_users.php" class="btn" style="background: #3498db;">Users</a>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span style="color: var(--text-color); align-self: center;">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="wishlist.php" class="btn" style="background: #e91e63; margin-right: 5px;">❤</a>
                    <a href="cart.php" class="btn" style="background: #27ae60; margin-right: 10px;">Cart</a>
                    <a href="profile.php" class="btn" style="background: var(--secondary); margin-right: 10px;">Profile</a>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="register.php" class="btn">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>

<main class="container">
