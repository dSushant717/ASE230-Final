<?php
require_once '../db.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ../auth/signin.php');
    exit;
}

$postId = $_GET['id'] ?? null;

if (!$postId) {
    die('Error: Post ID is missing.');
}

// Fetch the post
$stmt = $pdo->prepare("SELECT * FROM post WHERE post_id = :post_id");
$stmt->execute([':post_id' => $postId]);
$post = $stmt->fetch();

if (!$post) {
    die('Error: Post does not exist.');
}

// Check permissions
$isAdmin = $_SESSION['role'] === 'admin';
$isOwner = $_SESSION['user_id'] === $post['author_id'];

if (!$isAdmin && !$isOwner) {
    die('Error: You are not authorized to delete this post.');
}

// Delete the post
$stmt = $pdo->prepare("DELETE FROM post WHERE post_id = :post_id");
$stmt->execute([':post_id' => $postId]);

header('Location: posts.php');
exit;
?>
