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
    $newUsername = trim((string) ($_POST["new_username"] ?? ""));
    $newPassword = (string) ($_POST["new_password"] ?? "");
    $confirm = (string) ($_POST["confirm_password"] ?? "");

    if ($newUsername === "") {
        $error = "Username is required.";
    } elseif (strlen($newUsername) < 3 || strlen($newUsername) > 80) {
        $error = "Username must be between 3 and 80 characters.";
    } elseif (!preg_match('/^[a-zA-Z0-9._-]+$/', $newUsername)) {
        $error = "Username may only use letters, numbers, dots, underscores, and hyphens.";
    } elseif (admin_username_taken($newUsername, (int) $user["id"])) {
        $error = "That username is already in use.";
    } elseif (strlen($newPassword) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($newPassword !== $confirm) {
        $error = "Passwords do not match.";
    } elseif ($newUsername === "admin" && $newPassword === "admin") {
        $error = "Choose a different username and password than the temporary defaults.";
    } else {
        admin_complete_initial_setup((int) $user["id"], $newUsername, $newPassword);
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
    <title>Set Up Admin Account — InfersioAI</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="auth-wrap">
        <form class="auth-card" method="post" autocomplete="off">
            <h1>Set up your account</h1>
            <p>Before continuing, choose your permanent admin username and password. These will be saved to the database.</p>
            <?php if ($error): ?>
                <div class="msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <label for="new_username">New username</label>
            <input id="new_username" name="new_username" type="text" required minlength="3" maxlength="80" autocomplete="username" value="<?= htmlspecialchars((string) ($_POST["new_username"] ?? "")) ?>">
            <label for="new_password">New password</label>
            <input id="new_password" name="new_password" type="password" minlength="8" required autocomplete="new-password">
            <label for="confirm_password">Confirm password</label>
            <input id="confirm_password" name="confirm_password" type="password" minlength="8" required autocomplete="new-password">
            <button class="btn" type="submit">Save and continue</button>
        </form>
    </div>
</body>
</html>
