<?php
require_once '../db.php';
session_start();

$error = ''; // To display error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = $_POST['username_or_email'];
    $password = $_POST['password'];

    try {
        // Prepare query to check username or email
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username OR email = :email");
        $stmt->execute([
            ':username' => $usernameOrEmail,
            ':email' => $usernameOrEmail
        ]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role']; // Assuming "role" is a column in the `user` table
            header('Location: ../entity/posts.php');
            exit;
        } else {
            $error = "Invalid username/email or password.";
        }
    } catch (PDOException $e) {
        error_log("Sign-in error: " . $e->getMessage());
        $error = "An error occurred. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In</title>
    <link href="../assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container">
        <h2>Sign In</h2>
        <?php if ($error) echo "<p class='text-danger'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username_or_email">Username or Email</label>
                <input type="text" id="username_or_email" name="username_or_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
