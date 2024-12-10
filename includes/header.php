<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection
require_once '../db.php'; 

if (!defined('BASE_URL')) {
    $projectFolder = 'ASE230-Final'; 
    $baseURL = "http://" . $_SERVER['HTTP_HOST'] . '/' . $projectFolder . '/';
    define('BASE_URL', $baseURL);
}

// Pages where the navbar should not be displayed
$noNavbarPages = ['signin.php', 'signup.php', 'signout.php'];

// Get the current page name
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<?php if (!in_array($currentPage, $noNavbarPages)): ?> <!-- Only display navbar if not in exclusion list -->
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
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
