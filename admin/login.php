<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/admin_auth.php";

admin_session_start();
bootstrap_database();

if (!empty($_SESSION["admin_user_id"])) {
    header("Location: index.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim((string) ($_POST["username"] ?? ""));
    $password = (string) ($_POST["password"] ?? "");
    $user = admin_attempt_login($username, $password);
    if ($user) {
        if (!empty($user["must_change_password"])) {
            header("Location: change-password.php");
            exit;
        }
        header("Location: index.php");
        exit;
    }
    $error = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - InfersioAI</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="auth-wrap">
        <form class="auth-card" method="post" autocomplete="off">
            <h1>InfersioAI Admin</h1>
            <p>First login: <span class="muted">admin / admin123</span></p>
            <?php if ($error): ?>
                <div class="msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <label for="username">Username</label>
            <input id="username" name="username" type="text" required>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            <button class="btn" type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
