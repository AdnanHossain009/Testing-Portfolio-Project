<?php
session_start();

require_once __DIR__ . '/../includes/db.php';

// If remember me cookie exists, delete the token from database
if (!empty($_COOKIE['remember_me'])) {
    list($selector, $validator) = explode(':', $_COOKIE['remember_me']);
    
    $pdo = get_pdo_connection();
    $stmt = $pdo->prepare('DELETE FROM auth_tokens WHERE selector = ?');
    $stmt->execute([$selector]);
    
    // Delete the cookie by setting expiration to past
    setcookie('remember_me', '', time() - 3600, '/');
}

// Destroy all session data
$_SESSION = array();
session_destroy();

// Redirect to portfolio front page instead of login page
header('Location: /portfolio/index.php'); // Adjust path as needed
exit;
?>