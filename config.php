<?php
// Database configuration for XAMPP (MySQL/MariaDB)
// Update these if your local setup differs

define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // XAMPP default is empty password

// Base URL (optional). If deploying under a subfolder, set accordingly.
// Example: define('BASE_URL', 'http://localhost/Testing%20Portfolio/');
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = rtrim(str_replace(basename($scriptName), '', $scriptName), '/');
    define('BASE_URL', $protocol . $host . $dir . '/');
}
?>




