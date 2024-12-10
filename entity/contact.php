<?php
include '../functions.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="../assets/css/styles.css" rel="stylesheet"> 
</head>
<body>
    <!-- Include Header -->
    <?php include '../includes/header.php'; ?> 
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('../assets/img/contact-bg.jpg')"> 
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1>Contact Us</h1>
                        <span class="subheading">We’d love to hear from you</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contact Form -->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <p>Have questions, suggestions, or feedback? Reach out to us using the form below:</p>
                <form action="../process-contact.php" method="POST"> 
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>
