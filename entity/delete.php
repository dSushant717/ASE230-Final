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
        alert('You are not authorized to delete this post.');
        window.history.back();
    </script>";
    exit;
}

// Delete the post
unset($posts[$id]);
saveData('../data/posts.json', array_values($posts));
header('Location: posts.php');
exit;
?>
