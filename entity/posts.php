<?php
require_once '../db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch posts from the database
$stmt = $pdo->prepare("
    SELECT p.post_id, p.title, p.content, DATE(p.created_at) AS created_date, u.username AS author, u.user_id AS author_id
    FROM post p
    JOIN user u ON p.author_id = u.user_id
    ORDER BY p.created_at DESC
");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if the current user is an admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Get the current user's ID from session (if logged in)
$currentUserId = $_SESSION['user_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Include Header -->
    <?php include '../includes/header.php'; ?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('../assets/img/header.png')">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="site-heading">
                        <h1>All Blog Posts</h1>
                        <span class="subheading">Explore all our anime-themed posts!</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <!-- Button to Create New Post -->
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="create.php" class="btn btn-primary mb-3">Create New Post</a>
                <?php endif; ?>

                <!-- Display Posts -->
                <?php foreach ($posts as $post): ?>
                    <div class="post-preview">
                        <a href="detail.php?id=<?= htmlspecialchars($post['post_id']); ?>">
                            <h2 class="post-title"><?= htmlspecialchars_decode($post['title']); ?></h2>
                            <h3 class="post-subtitle"><?= htmlspecialchars_decode(substr($post['content'], 0, 100)) . '...'; ?></h3>
                        </a>
                        <p class="post-meta">
                            Posted by <?= htmlspecialchars($post['author']); ?> on <?= htmlspecialchars($post['created_date']); ?>
                            <?php if ($isAdmin || $currentUserId == $post['author_id']): ?>
                                | <a href="edit.php?id=<?= htmlspecialchars($post['post_id']); ?>">Edit</a>
                                | <a href="delete.php?id=<?= htmlspecialchars($post['post_id']); ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                            <?php endif; ?>
                        </p>
                    </div>

                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>
