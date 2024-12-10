<?php
include '../functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
requireAuthentication(); // Ensure the user is logged in

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['user']; // Use the logged-in user's name as the author
    $date = date('Y-m-d');

    // Fetch existing posts
    $posts = readData('../data/posts.json');

    // Add new post
    $posts[] = ['title' => $title, 'content' => $content, 'author' => $author, 'date' => $date];
    saveData('../data/posts.json', $posts);

    // Redirect to posts page
    header('Location: ../entity/posts.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Post</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include the header -->

    <div class="container">
        <h2>Create a New Post</h2>
        <form method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Enter post title" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="5" class="form-control" placeholder="Write your content here" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
