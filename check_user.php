<?php
require_once 'config/database.php';

$user = dbQueryOne('SELECT * FROM users WHERE username = :u', [':u' => 'admin']);
echo "<pre>";
var_dump($user);
echo "</pre>";

if ($user) {
    echo "Password verify result: " . (password_verify('password123', $user['password']) ? 'OK' : 'FAIL');
} else {
    echo "User 'admin' not found in database. Please run the SQL script.";
}
