<?php
require_once '../db.php'; // Ensure the correct path to db.php
session_start();

// Fetch post ID from the URL
$postId = $_GET['id'] ?? null;

if (!$postId) {
    die("Error: Post ID is missing. Please navigate back to the posts page.");
}

// Fetch post and author details from the database
$stmt = $pdo->prepare("
    SELECT p.*, u.username AS author_name 
    FROM post p 
    JOIN user u ON p.author_id = u.user_id 
    WHERE p.post_id = :post_id
");
$stmt->execute([':post_id' => $postId]);
$post = $stmt->fetch();

if (!$post) {
    die("Error: The post does not exist. Please navigate back to the posts page.");
}

// Fetch comments for the post
$stmt = $pdo->prepare("
    SELECT c.content, c.created_at, u.username AS author_name 
    FROM comment c 
    JOIN user u ON c.author_id = u.user_id 
    WHERE c.post_id = :post_id 
    ORDER BY c.created_at DESC
");
$stmt->execute([':post_id' => $postId]);
$comments = $stmt->fetchAll();

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user'])) {
        $content = htmlspecialchars($_POST['content']);
        $authorId = $_SESSION['user_id'];
        $stmt = $pdo->prepare("INSERT INTO comment (content, post_id, author_id) VALUES (:content, :post_id, :author_id)");
        $stmt->execute([
            ':content' => $content,
            ':post_id' => $postId,
            ':author_id' => $authorId,
        ]);
        header("Location: detail.php?id=$postId");
        exit;
    } else {
        echo "<script>alert('Please log in to add a comment.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']); ?></title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Page Header with Post Image -->
    <header class="masthead" style="background-image: url('../<?= htmlspecialchars($post['image'] ?? 'assets/img/default-bg.jpg'); ?>');">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="post-heading">
                        <h1><?= htmlspecialchars($post['title']); ?></h1>
                        <h2 class="subheading">Posted by <?= htmlspecialchars($post['author_name']); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <p><?= nl2br(htmlspecialchars($post['content'])); ?></p>
                </div>
            </div>
        </div>
    </article>

    <!-- Comments Section -->
    <div class="container mt-5">
        <h3>Comments</h3>

        <!-- Display Existing Comments -->
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-box">
                    <p><strong><?= htmlspecialchars($comment['author_name']); ?></strong> said:</p>
                    <p><?= nl2br(htmlspecialchars($comment['content'])); ?></p>
                    <p><small><?= htmlspecialchars(date("F j, Y, g:i a", strtotime($comment['created_at']))); ?></small></p>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>

        <!-- Add a New Comment -->
        <?php if (isset($_SESSION['user'])): ?>
            <form action="detail.php?id=<?= $postId; ?>" method="POST">
                <textarea name="content" rows="4" class="form-control mb-3" placeholder="Add your comment..." required></textarea>
                <button type="submit" class="btn btn-primary">Post Comment</button>
            </form>
        <?php else: ?>
            <p><a href="../auth/signin.php">Log in</a> to add a comment.</p>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
