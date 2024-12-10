<?php
/**
 * Reads data from a JSON file and returns it as an associative array.
 */
function readData($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }
    $data = file_get_contents($filePath);
    return json_decode($data, true) ?? [];
}

/**
 * Saves data to a JSON file.
 */
function saveData($filePath, $data) {
    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
}

/**
 * Fetch comments by post ID.
 */
function fetchCommentsByPost($pdo, $postId) {
    $stmt = $pdo->prepare("SELECT c.*, u.username AS author_name 
                           FROM comment c 
                           JOIN user u ON c.author_id = u.user_id 
                           WHERE c.post_id = :post_id 
                           ORDER BY c.created_at DESC");
    $stmt->execute([':post_id' => $postId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Add a new comment.
 */
function addComment($pdo, $content, $postId, $authorId) {
    $stmt = $pdo->prepare("INSERT INTO comment (content, post_id, author_id) VALUES (:content, :post_id, :author_id)");
    $stmt->execute([
        ':content' => $content,
        ':post_id' => $postId,
        ':author_id' => $authorId,
    ]);
}

/**
 * Checks if the user is authenticated (logged in).
 */
function isAuthenticated() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['user_id']);
}

/**
 * Redirects the user to the login page if they are not authenticated.
 */
function requireAuthentication() {
    if (!isAuthenticated()) {
        header('Location: ../auth/signin.php');
        exit;
    }
}
?>
