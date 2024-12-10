<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'anime_blog');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log the error message for debugging
    error_log("Database connection failed: " . $e->getMessage());
    
    // Display a user-friendly message
    echo "<p>System error: Unable to connect to the database. Please try again later.</p>";
    
    // Exit to stop further execution
    exit;
}
?>
