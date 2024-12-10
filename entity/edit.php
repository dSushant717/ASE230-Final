<?php
include '../functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
requireAuthentication(); // Ensure the user is logged in

// Fetch the post ID and data
$id = $_GET['id'] ?? null;
$posts = readData('../data/posts.json');
$post = $id !== null && isset($posts[$id]) ? $posts[$id] : null;

// Check if the post exists and the logged-in user is the author
if ($post === null || $_SESSION['user'] !== $post['author']) {
    echo "<script>
        alert('You are not authorized to edit this post.');
        window.history.back();
    </script>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posts[$id]['title'] = $_POST['title'];
    $posts[$id]['content'] = $_POST['content'];
    saveData('../data/posts.json', $posts);
    header('Location: posts.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Post</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Edit Post</h2>
        <form method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="5" class="form-control" required><?= htmlspecialchars($post['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
