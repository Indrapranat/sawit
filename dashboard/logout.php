<?php
/**
 * Logout Logic
 * Destroys session and redirects to login page.
 */
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: ../login.php");
exit;
