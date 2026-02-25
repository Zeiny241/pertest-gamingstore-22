<?php
require 'db.php';

echo "<h1>Database Schema Fixer</h1>";

try {
    echo "<p>Attempting to add 'slip' column to 'orders' table...</p>";
    // Try adding the column directly. If it exists, it will throw an exception which we catch.
    $pdo->exec("ALTER TABLE orders ADD COLUMN slip VARCHAR(255)");
    echo "<p style='color: green;'>Success: Column 'slip' added.</p>";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "<p style='color: orange;'>Notice: Column 'slip' already exists.</p>";
    } else {
        echo "<p style='color: red;'>Error adding column 'slip': " . $e->getMessage() . "</p>";
    }
}

try {
    echo "<p>Attempting to add 'status' column to 'orders' table...</p>";
    $pdo->exec("ALTER TABLE orders ADD COLUMN status VARCHAR(50) DEFAULT 'white'");
    echo "<p style='color: green;'>Success: Column 'status' added.</p>";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
             echo "<p style='color: orange;'>Notice: Column 'status' already exists.</p>";
    } else {
             echo "<p style='color: red;'>Error adding column 'status': " . $e->getMessage() . "</p>";
    }
}

echo "<hr>";
echo "<p>Database update process finished. You can now <a href='admin_orders.php'>return to Admin Orders</a>.</p>";
?>
