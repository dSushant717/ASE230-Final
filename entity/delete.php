<?php
require_once '../db.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // Redirect to login page if user is not authenticated
    header('Location: ../auth/signin.php');
    exit;
}

$postId = $_GET['id'] ?? null;

if (!$postId) {
    // Log the error and redirect to the posts page with an error message
    error_log("Error: Post ID is missing.");
    header('Location: posts.php?error=missing_post_id');
    exit;
}

// Fetch the post
$stmt = $pdo->prepare("SELECT * FROM post WHERE post_id = :post_id");
$stmt->execute([':post_id' => $postId]);
$post = $stmt->fetch();

if (!$post) {
    // Log the error and redirect to the posts page with an error message
    error_log("Error: Post with ID $postId does not exist.");
    header('Location: posts.php?error=post_not_found');
    exit;
}

// Check permissions
$isAdmin = $_SESSION['role'] === 'admin';
$isOwner = $_SESSION['user_id'] === $post['author_id'];

if (!$isAdmin && !$isOwner) {
    // Log the error and redirect to the posts page with an error message
    error_log("Error: Unauthorized deletion attempt by user ID {$_SESSION['user_id']} for post ID $postId.");
    header('Location: posts.php?error=unauthorized');
    exit;
}

try {
    // Delete the post
    $stmt = $pdo->prepare("DELETE FROM post WHERE post_id = :post_id");
    $stmt->execute([':post_id' => $postId]);

    // Redirect to the posts page with a success message
    header('Location: posts.php?success=post_deleted');
    exit;
} catch (PDOException $e) {
    // Log the error and redirect to the posts page with an error message
    error_log("Error deleting post ID $postId: " . $e->getMessage());
    header('Location: posts.php?error=delete_failed');
    exit;
}
?>
