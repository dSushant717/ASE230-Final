<?php
require_once '../db.php'; // Database connection
session_start();

// Fetch all posts
$stmt = $pdo->query("SELECT * FROM post ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
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
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h1>All Posts</h1>
        <hr>

        <!-- Loop Through Posts -->
        <?php foreach ($posts as $post): ?>
            <div class="post-preview">
                <a href="detail.php?id=<?= $post['post_id']; ?>">
                    <h2 class="post-title"><?= htmlspecialchars($post['title']); ?></h2>
                    <h3 class="post-subtitle"><?= htmlspecialchars(substr($post['content'], 0, 100)) . '...'; ?></h3>
                </a>
                <p class="post-meta">
                    Posted by User <?= htmlspecialchars($post['author_id']); ?> on <?= htmlspecialchars($post['created_at']); ?>
                </p>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
