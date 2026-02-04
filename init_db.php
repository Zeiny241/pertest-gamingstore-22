<?php
require 'db.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        image VARCHAR(255),
        platform VARCHAR(50),
        user_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        fullname VARCHAR(100),
        email VARCHAR(100),
        phone VARCHAR(20),
        address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    
    // Attempt to add columns if they don't exist (for existing tables)
    $alter_sql = "
        ALTER TABLE products ADD COLUMN IF NOT EXISTS user_id INT;
        ALTER TABLE users ADD COLUMN IF NOT EXISTS fullname VARCHAR(100);
        ALTER TABLE users ADD COLUMN IF NOT EXISTS email VARCHAR(100);
        ALTER TABLE users ADD COLUMN IF NOT EXISTS phone VARCHAR(20);
        ALTER TABLE users ADD COLUMN IF NOT EXISTS address TEXT;
        ALTER TABLE users ADD COLUMN IF NOT EXISTS role VARCHAR(20) DEFAULT 'user';
    ";
    try {
        $pdo->exec($alter_sql);
    } catch (PDOException $e) {
        // Ignore if error occurs (e.g., MariaDB version might not support IF NOT EXISTS in ALTER)
        // Alternative: individual ALTERS wrapped in try-catch
    }

    // Create default admin user if not exists
    $admin_user = 'admin';
    $admin_pass = '1234';
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$admin_user]);
    if (!$stmt->fetch()) {
        $hashed_pass = password_hash($admin_pass, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, fullname) VALUES (?, ?, 'admin', 'System Administrator')");
        $stmt->execute([$admin_user, $hashed_pass]);
        echo "\nDefault admin user created (admin/1234).";
    }

    echo "Tables created/updated successfully.";
} catch(PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>
