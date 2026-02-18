<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cart_items = $_SESSION['cart'] ?? [];
$direct_buy_id = $_GET['id'] ?? null;

// If coming from "Buy Now" (Direct), we handle it, otherwise use Cart.
// Actually, new logic: "Buy Now" -> Add to Cart -> Redirect here? 
// Or support both? Let's support Cart primarily. 
// If cart is empty and no direct ID, redirect.
if (empty($cart_items) && !$direct_buy_id) {
    header("Location: index.php");
    exit;
}

$products = [];
$total_price = 0;

if ($direct_buy_id) {
    // Single item checkout
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$direct_buy_id]);
    $p = $stmt->fetch();
    if ($p) {
        $p['qty'] = 1;
        $products[] = $p;
        $total_price = $p['price'];
    }
} else {
    // Cart checkout
    $ids = implode(',', array_keys($cart_items));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $fetched_products = $stmt->fetchAll();
    foreach ($fetched_products as $p) {
        $qty = $cart_items[$p['id']];
        $p['qty'] = $qty;
        $products[] = $p;
        $total_price += $p['price'] * $qty;
    }
}

$final_price = $total_price;
$discount = 0;
$coupon_code = '';
$coupon_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['apply_coupon'])) {
        $coupon_code = $_POST['coupon_code'];
        if ($coupon_code === 'XD007') {
            $discount = $total_price * 0.20; // 20% discount
            $final_price = $total_price - $discount;
            $coupon_message = "Coupon applied! You saved $" . number_format($discount, 2);
        } else {
            $coupon_message = "Invalid coupon code";
            $final_price = $total_price;
        }
    } elseif (isset($_POST['confirm_order'])) {
        $coupon_submitted = $_POST['coupon_code_hidden'];
        if ($coupon_submitted === 'XD007') {
           $discount = $total_price * 0.20; 
           $final_price = $total_price - $discount;
        }

        $user_id = $_SESSION['user_id'];
        
        // Validate Stock first
        foreach ($products as $p) {
             $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
             $stmt->execute([$p['id']]);
             $current_stock = $stmt->fetchColumn();
             
             if ($current_stock < $p['qty']) {
                 $coupon_message = "Item " . htmlspecialchars($p['name']) . " is out of stock (only " . $current_stock . " left)";
                 // Stop execution
                 break; 
             }
        }
        
        if (strpos($coupon_message, 'out of stock') === false) {
            foreach ($products as $p) {
                $item_total = $p['price'] * $p['qty'] * (1 - ($discount/$total_price)); 
                $ratio = $p['price'] * $p['qty'] / $total_price;
                $item_final_price = $final_price * $ratio;
                
                $stmt = $pdo->prepare("INSERT INTO orders (user_id, product_id, total_price, status) VALUES (?, ?, ?, 'completed')");
                $stmt->execute([$user_id, $p['id'], $item_final_price]);
                
                // Reduce Stock
                $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                $stmt->execute([$p['qty'], $p['id']]);
            }
            
            // Clear Cart
            unset($_SESSION['cart']);
            
            header("Location: index.php?order_success=1");
            exit;
        }
    }
}

include 'includes/header.php';
?>

<div class="form-container" style="max-width: 800px;">
    <h2 class="text-center mb-4" style="color: white;">Checkout</h2>
    
    <div class="grid" style="grid-template-columns: 1fr; gap: 1rem; margin-bottom: 2rem;">
        <?php foreach ($products as $p): ?>
        <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                 <?php if ($p['image']): ?>
                    <img src="<?= htmlspecialchars($p['image']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                <?php endif; ?>
                <div>
                    <h4><?= htmlspecialchars($p['name']) ?></h4>
                    <span style="color: var(--text-muted);">x<?= $p['qty'] ?></span>
                </div>
            </div>
            <div class="card-price" style="font-size: 1.2rem;">$<?= number_format($p['price'] * $p['qty'], 2) ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if($coupon_message): ?>
        <p style="color: <?= strpos($coupon_message, 'applied') !== false ? '#2ecc71' : '#ff4757' ?>; text-align: center; margin-bottom: 20px;"><?= $coupon_message ?></p>
    <?php endif; ?>
    
    <!-- Coupon Form -->
    <form method="POST" style="margin-bottom: 2rem;">
        <label style="color:white;">Coupon Code</label>
        <div style="display: flex; gap: 10px;">
            <input type="text" name="coupon_code" class="form-control" value="<?= htmlspecialchars($coupon_code) ?>" placeholder="Enter code e.g. XD007">
            <button type="submit" name="apply_coupon" class="btn" style="background: var(--secondary);">Apply</button>
        </div>
    </form>

    <div style="background: rgba(0,0,0,0.3); padding: 15px; border-radius: 10px; margin-bottom: 20px; color: white;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
            <span>Subtotal:</span>
            <span>$<?= number_format($total_price, 2) ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 5px; color: #2ecc71;">
            <span>Discount:</span>
            <span>-$<?= number_format($discount, 2) ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.5rem; margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
            <span>Total:</span>
            <span>$<?= number_format($final_price, 2) ?></span>
        </div>
    </div>
    
    <!-- Payment Method -->
    <h3 style="color: white; margin-bottom: 1rem;">Payment Method</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 2rem;">
        <label class="btn" onclick="selectPayment('tng')" style="background: rgba(255,255,255,0.1); text-align: center; border: 1px solid transparent;">
            <input type="radio" name="payment" value="tng" checked style="display: none;"> PromptPay
        </label>
        <label class="btn" onclick="selectPayment('bank')" style="background: rgba(255,255,255,0.1); text-align: center; border: 1px solid transparent;">
            <input type="radio" name="payment" value="bank" style="display: none;"> Bank Transfer
        </label>
        <label class="btn" onclick="selectPayment('card')" style="background: rgba(255,255,255,0.1); text-align: center; border: 1px solid transparent;">
            <input type="radio" name="payment" value="card" style="display: none;"> Credit Card
        </label>
    </div>

    <!-- PromptPay Section -->
    <div id="promptpay-section" style="display: block; text-align: center; background: rgba(0,0,0,0.3); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
        <h4 style="color: white;">Scan QR to Pay</h4>
        <div id="qr-container" style="margin: 20px 0;">
            <!-- QR Placeholder -->
            <img id="promptpay-qr" src="https://promptpay.io/0812345678/<?= $final_price ?>.png" alt="PromptPay QR" style="max-width: 250px; border-radius: 10px; border: 2px solid white;">
        </div>
        <p style="color: var(--primary); font-size: 1.2rem;">Amount: $<?= number_format($final_price, 2) ?></p>
        <p style="color: var(--text-muted);">PromptPay ID: 081-234-5678</p>
        
        <div style="margin-top: 20px;">
            <label style="display: block; color: white; margin-bottom: 10px;">Upload Payment Slip</label>
            <input type="file" id="slip-upload" accept="image/*" class="form-control" style="max-width: 300px; margin: 0 auto;">
        </div>
    </div>

    <form method="POST" id="checkout-form" onsubmit="event.preventDefault(); processCheckout();">
        <input type="hidden" name="coupon_code_hidden" value="<?= htmlspecialchars($coupon_code) ?>">
        <div class="text-center">
            <button type="submit" name="confirm_order" class="btn" style="width: 100%; font-size: 1.2rem; padding: 1rem;">Confirm Payment</button>
            <a href="cart.php" style="display: block; margin-top: 15px; color: var(--text-muted);">Back to Cart</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function selectPayment(method) {
    document.querySelectorAll('input[name="payment"]').forEach(el => {
        el.parentElement.style.border = '1px solid transparent';
    });
    event.currentTarget.style.border = '1px solid var(--primary)';
    
    // Toggle PromptPay Section
    if (method === 'tng') {
        document.getElementById('promptpay-section').style.display = 'block';
    } else {
        document.getElementById('promptpay-section').style.display = 'none';
        Swal.fire({
            icon: 'info',
            title: 'Under Development',
            text: 'This payment method is not available yet. Please use PromptPay.',
            background: '#1e293b',
            color: '#fff'
        });
    }
}

function processCheckout() {
    const slipFile = document.getElementById('slip-upload').files[0];
    
    if (!slipFile) {
        Swal.fire({
            icon: 'warning',
            title: 'Slip Required',
            text: 'Please upload your payment slip to proceed.',
            background: '#1e293b',
            color: '#fff'
        });
        return;
    }

    const formData = new FormData();
    formData.append('slip', slipFile);
    formData.append('total_price', '<?= $final_price ?>');
    formData.append('cart_data', '<?= json_encode($products) ?>');
    <?php if($discount > 0): ?>
    formData.append('coupon_code', '<?= $coupon_code ?>');
    <?php endif; ?>

    Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we verify your slip.',
        allowOutsideClick: false,
        background: '#1e293b',
        color: '#fff',
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('upload_slip.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Order Placed!',
                text: 'Your order is now pending verification.',
                background: '#1e293b',
                color: '#fff'
            }).then(() => {
                window.location.href = 'index.php';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Something went wrong.',
                background: '#1e293b',
                color: '#fff'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to process request.',
            background: '#1e293b',
            color: '#fff'
        });
    });
}
</script>

<?php include 'includes/footer.php'; ?>
