<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define the base URL dynamically if not already defined
if (!defined('BASE_URL')) {
    $projectFolder = 'ASE230-Final'; // Your project folder name
    $baseURL = "http://" . $_SERVER['HTTP_HOST'] . '/' . $projectFolder . '/';
    define('BASE_URL', $baseURL);
}

// Pages where the navbar should NOT be displayed
$noNavbarPages = ['signin.php', 'signup.php', 'signout.php'];

// Pages where the dark navbar should be displayed
$darkNavbarPages = ['create.php', 'edit.php', 'detail.php'];

// Get the current page name
$currentPage = basename($_SERVER['PHP_SELF']);

// Include database connection
$dbPath = realpath(__DIR__ . '/../db.php');
if (file_exists($dbPath)) {
    require_once $dbPath;
} else {
    // Log the error and handle gracefully
    error_log("Database file not found at $dbPath");
    echo "<p>System error: Unable to connect to the database. Please contact support.</p>";
    exit; // Stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Park Blog</title>
    <link href="<?= BASE_URL; ?>assets/css/styles.css" rel="stylesheet"> <!-- Custom CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
</head>
<body>
<?php if (!in_array($currentPage, $noNavbarPages)): ?>
    <nav class="navbar navbar-expand-lg 
        <?= in_array($currentPage, $darkNavbarPages) ? 'navbar-dark bg-dark' : 'navbar-light'; ?>" 
        id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="<?= BASE_URL; ?>">Anime Park Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>entity/posts.php">Posts</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>entity/about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>entity/contact.php">Contact</a></li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>auth/signout.php">Logout (<?= htmlspecialchars($_SESSION['user']); ?>)</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>auth/signin.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>auth/signup.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
<?php endif; ?>
