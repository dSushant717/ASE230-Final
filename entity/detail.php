<?php
require_once '../db.php'; // Ensure the correct path to db.php
session_start();

// Fetch post ID from the URL
$postId = $_GET['id'] ?? null;

if (!$postId) {
    // Log the error and redirect to a user-friendly error page or the posts page
    error_log("Post ID is missing.");
    header("Location: posts.php?error=missing_post_id");
    exit;
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
    // Log the error and redirect to a user-friendly error page or the posts page
    error_log("Post with ID $postId does not exist.");
    header("Location: posts.php?error=post_not_found");
    exit;
}

// Handle comment deletion
if (isset($_GET['delete_comment']) && isset($_SESSION['user_id'])) {
    $commentId = $_GET['delete_comment'];

    // Fetch the comment to check permissions
    $stmt = $pdo->prepare("SELECT * FROM comment WHERE comment_id = :comment_id");
    $stmt->execute([':comment_id' => $commentId]);
    $comment = $stmt->fetch();

    if ($comment) {
        $isAdmin = $_SESSION['role'] === 'admin';
        $isOwner = $_SESSION['user_id'] === $comment['author_id'];

        if ($isAdmin || $isOwner) {
            // Delete the comment
            $stmt = $pdo->prepare("DELETE FROM comment WHERE comment_id = :comment_id");
            $stmt->execute([':comment_id' => $commentId]);
            header("Location: detail.php?id=$postId");
            exit;
        } else {
            echo "<script>alert('You are not authorized to delete this comment.');</script>";
        }
    } else {
        echo "<script>alert('Comment does not exist.');</script>";
    }
}

// Fetch comments for the post
$stmt = $pdo->prepare("
    SELECT c.comment_id, c.content, c.created_at, u.username AS author_name, c.author_id
    FROM comment c 
    JOIN user u ON c.author_id = u.user_id 
    WHERE c.post_id = :post_id 
    ORDER BY c.created_at DESC
");
$stmt->execute([':post_id' => $postId]);
$comments = $stmt->fetchAll();

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES | ENT_HTML5);
    $authorId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("INSERT INTO comment (content, post_id, author_id) VALUES (:content, :post_id, :author_id)");
    $stmt->execute([
        ':content' => $content,
        ':post_id' => $postId,
        ':author_id' => $authorId,
    ]);
    header("Location: detail.php?id=$postId");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars_decode($post['title'], ENT_QUOTES | ENT_HTML5); ?></title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Post Details -->
    <div class="container content mt-5">
        <h2><?= htmlspecialchars_decode($post['title'], ENT_QUOTES | ENT_HTML5); ?></h2>
        <p>Posted by <?= htmlspecialchars($post['author_name']); ?> on <?= htmlspecialchars(date("F j, Y", strtotime($post['created_at']))); ?></p>
        <p><?= nl2br(htmlspecialchars_decode($post['content'], ENT_QUOTES | ENT_HTML5)); ?></p>
    </div>

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
                    <?php if (isset($_SESSION['user_id']) && ($_SESSION['role'] === 'admin' || $_SESSION['user_id'] === $comment['author_id'])): ?>
                        <a href="detail.php?id=<?= $postId; ?>&delete_comment=<?= $comment['comment_id']; ?>" 
                        onclick="return confirm('Are you sure you want to delete this comment?');" 
                        class="text-danger" 
                        title="Delete Comment">
                            <i class="fas fa-trash-alt"></i> <!-- Trash icon -->
                        </a>
                    <?php endif; ?>
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
