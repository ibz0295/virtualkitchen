<?php
// Check if a session is already active
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session only if not already active
}

// Generate CSRF token if not already present
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a secure token
}

global $pdo; 
$host = 'localhost';
$dbname = 'u_240125594_vkitchen_db';
$username = 'u-240125594';
$password = 'N928HtFddQwoEeL';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

