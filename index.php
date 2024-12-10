<?php
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Amusement Park</title>
    <link href="assets/css/styles.css" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Include Header -->
    <?php include 'includes/header.php'; ?> 

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('assets/img/home-bg.jpg')"> 
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1>Anime Amusement Park</h1>
                        <span class="subheading">Discover the Magic of Anime-Inspired Adventures!</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <p>
                    Welcome to the Anime Amusement Park Blog! Dive into thrilling stories, immersive attractions, and fascinating insights inspired by your favorite anime like One Piece, Attack on Titan, and Naruto.
                </p>
                <p>
                    Get started by exploring:
                </p>
                <ul>
                    <li><a href="<?= BASE_URL; ?>entity/posts.php">Our Posts</a></li>
                    <li><a href="<?= BASE_URL; ?>entity/about.php">About Us</a></li>
                    <li><a href="<?= BASE_URL; ?>entity/contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include 'includes/footer.php'; ?> <!-- Correct path to footer.php -->
    
    <!-- Include JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
