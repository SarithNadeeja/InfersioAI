<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/admin_auth.php";

$user = admin_require_login();
bootstrap_database();

if (empty($user["must_change_password"])) {
    header("Location: index.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new = (string) ($_POST["new_password"] ?? "");
    $confirm = (string) ($_POST["confirm_password"] ?? "");

    if (strlen($new) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($new !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        admin_force_password_change((int) $user["id"], $new);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - InfersioAI</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="auth-wrap">
        <form class="auth-card" method="post">
            <h1>Change Password</h1>
            <p>Your first login requires a new password.</p>
            <?php if ($error): ?>
                <div class="msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <label for="new_password">New Password</label>
            <input id="new_password" name="new_password" type="password" minlength="8" required>
            <label for="confirm_password">Confirm Password</label>
            <input id="confirm_password" name="confirm_password" type="password" minlength="8" required>
            <button class="btn" type="submit">Update Password</button>
        </form>
    </div>
</body>
</html>
