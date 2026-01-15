<?php
require_once 'config/database.php';

// Check if users table exists, if not create it
try {
    $pdo = getConnection();
    
    // Create table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Check if admin exists
    $user = dbQueryOne('SELECT id FROM users WHERE username = :u', [':u' => 'admin']);
    
    if (!$user) {
        // Insert admin with password123
        $hash = password_hash('password123', PASSWORD_DEFAULT);
        dbExecute('INSERT INTO users (username, password) VALUES (:u, :p)', [
            ':u' => 'admin',
            ':p' => $hash
        ]);
        echo "User 'admin' created successfully with password 'password123'";
    } else {
        // Update password
        $hash = password_hash('password123', PASSWORD_DEFAULT);
        dbExecute('UPDATE users SET password = :p WHERE username = :u', [
            ':p' => $hash,
            ':u' => 'admin'
        ]);
        echo "User 'admin' password updated to 'password123'";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
