<?php
session_start();
require_once 'config/database.php';

// If coming properly from form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitize input
    // Sanitize and retrieve input
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
    
    // Basic Validation
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username dan Password wajib diisi.";
        header("Location: login.php");
        exit;
    }

    try {
        // Find user by username
        $sql = "SELECT id, username, password FROM users WHERE username = :username LIMIT 1";
        $user = dbQueryOne($sql, [':username' => $username]);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Success: Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['logged_in'] = true;
                $_SESSION['last_activity'] = time();
                
                // Redirect to dashboard
                // We check if dashboard exists, usually `dashboard/index.php` or just `dashboard/`
                header("Location: dashboard/"); // Assuming dashboard folder exists based on project structure
                exit;
            } else {
                $_SESSION['error'] = "Kombinasi username atau password salah.";
            }
        } else {
            // Generic error message for security (don't reveal user existence)
            $_SESSION['error'] = "Kombinasi username atau password salah.";
        }
    } catch (Exception $e) {
        // Log error
        error_log($e->getMessage());
        $_SESSION['error'] = "Terjadi kesalahan sistem. Silakan coba lagi.";
    }

    // Redirect back to login on failure
    header("Location: login.php");
    exit;

} else {
    // Direct access not allowed
    header("Location: login.php");
    exit;
}
