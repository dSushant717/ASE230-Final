<?php
require_once '../db.php';
require '../functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
requireAuthentication(); // Ensure the user is logged in

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $authorId = $_SESSION['user_id']; 

    // Server-side validation
    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } elseif (strlen($title) > 255) {
        $error = "Title cannot exceed 255 characters.";
    } else {
        try {
            // Insert new post into the database
            $stmt = $pdo->prepare("INSERT INTO post (title, content, author_id) VALUES (:title, :content, :author_id)");
            $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':author_id' => $authorId,
            ]);

            // Set success message
            $success = "Your post has been created successfully!";
            // Redirect after a short delay
            header('Refresh: 2; URL=../entity/posts.php');
        } catch (PDOException $e) {
            error_log("Error creating post: " . $e->getMessage(), 0);
            $error = "There was an issue creating your post. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Post</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container content">
        <h2>Create a New Post</h2>

        <!-- Display Error or Success Messages -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?= $success; ?></div>
        <?php endif; ?>

        <!-- Post Creation Form -->
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

    <?php include '../includes/footer.php'; ?>
</body>
</html>
