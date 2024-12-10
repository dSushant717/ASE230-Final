<?php
require_once '../db.php'; 
require '../functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
requireAuthentication(); // Ensure the user is logged in

// Fetch the post ID
$postId = $_GET['id'] ?? null;

if (!$postId) {
    die("Error: Post ID is missing. Please navigate back to the posts page.");
}

// Fetch the post to edit
$stmt = $pdo->prepare("SELECT * FROM post WHERE post_id = :post_id");
$stmt->execute([':post_id' => $postId]);
$post = $stmt->fetch();

if (!$post) {
    die("Error: Post does not exist.");
}

// Check if the user has permission to edit the post
$isAdmin = $_SESSION['role'] === 'admin';
$isOwner = $_SESSION['user_id'] === $post['author_id'];
if (!$isAdmin && !$isOwner) {
    die("Error: You are not authorized to edit this post.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $stmt = $pdo->prepare("UPDATE post SET title = :title, content = :content WHERE post_id = :post_id");
    $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':post_id' => $postId,
    ]);

    header('Location: posts.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container content mt-5">
        <h2>Edit Post</h2>
        <form method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" 
                       value="<?= htmlspecialchars_decode($post['title']); ?>" 
                       class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="5" class="form-control" required><?= htmlspecialchars_decode($post['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
