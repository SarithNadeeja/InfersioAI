<?php
declare(strict_types=1);

require_once __DIR__ . "/db.php";

function admin_session_start(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function admin_current_user(): ?array
{
    admin_session_start();
    if (empty($_SESSION["admin_user_id"])) {
        return null;
    }

    try {
        bootstrap_database();
        $pdo = db();
        $stmt = $pdo->prepare(
            "SELECT id, username, must_change_password
             FROM admin_users
             WHERE id = :id
             LIMIT 1"
        );
        $stmt->execute(["id" => (int) $_SESSION["admin_user_id"]]);
        $row = $stmt->fetch();
        return $row ?: null;
    } catch (Throwable $e) {
        return null;
    }
}

function admin_require_login(): array
{
    $user = admin_current_user();
    if (!$user) {
        header("Location: login.php");
        exit;
    }
    return $user;
}

function admin_attempt_login(string $username, string $password): ?array
{
    bootstrap_database();
    $pdo = db();
    $stmt = $pdo->prepare(
        "SELECT id, username, password_hash, must_change_password
         FROM admin_users
         WHERE username = :username
         LIMIT 1"
    );
    $stmt->execute(["username" => $username]);
    $user = $stmt->fetch();
    if (!$user) {
        return null;
    }

    if (!password_verify($password, $user["password_hash"])) {
        return null;
    }

    admin_session_start();
    $_SESSION["admin_user_id"] = (int) $user["id"];

    return [
        "id" => (int) $user["id"],
        "username" => $user["username"],
        "must_change_password" => (bool) $user["must_change_password"],
    ];
}

function admin_complete_initial_setup(int $userId, string $newUsername, string $newPassword): void
{
    $pdo = db();
    $newUsername = trim($newUsername);
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
        "UPDATE admin_users
         SET username = :username,
             password_hash = :hash,
             must_change_password = FALSE
         WHERE id = :id"
    );
    $stmt->execute([
        "username" => $newUsername,
        "hash" => $hash,
        "id" => $userId,
    ]);
}

function admin_username_taken(string $username, int $exceptUserId = 0): bool
{
    $pdo = db();
    $stmt = $pdo->prepare(
        "SELECT id FROM admin_users WHERE username = :username AND id <> :id LIMIT 1"
    );
    $stmt->execute([
        "username" => trim($username),
        "id" => $exceptUserId,
    ]);

    return (bool) $stmt->fetch();
}

/** @return string|null Error message, or null if valid */
function admin_validate_username(string $username): ?string
{
    $username = trim($username);
    if ($username === "") {
        return "Username is required.";
    }
    if (strlen($username) < 3 || strlen($username) > 80) {
        return "Username must be between 3 and 80 characters.";
    }
    if (!preg_match('/^[a-zA-Z0-9._-]+$/', $username)) {
        return "Username may only use letters, numbers, dots, underscores, and hyphens.";
    }

    return null;
}

/** @return string|null Error message, or null if valid */
function admin_validate_password(string $password, string $confirm = ""): ?string
{
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters.";
    }
    if ($confirm !== "" && $password !== $confirm) {
        return "Passwords do not match.";
    }

    return null;
}

/** @return list<array{id: int, username: string, must_change_password: bool, created_at: string}> */
function admin_list_users(): array
{
    bootstrap_database();
    $pdo = db();
    $stmt = $pdo->query(
        "SELECT id, username, must_change_password, created_at::text AS created_at
         FROM admin_users
         ORDER BY id ASC"
    );

    return $stmt->fetchAll();
}

function admin_create_user(string $username, string $password): int
{
    $pdo = db();
    $stmt = $pdo->prepare(
        "INSERT INTO admin_users (username, password_hash, must_change_password)
         VALUES (:username, :hash, FALSE)"
    );
    $stmt->execute([
        "username" => trim($username),
        "hash" => password_hash($password, PASSWORD_DEFAULT),
    ]);

    return (int) $pdo->lastInsertId();
}

function admin_update_user(int $userId, string $username, ?string $newPassword = null): void
{
    $pdo = db();
    $username = trim($username);

    if ($newPassword !== null && $newPassword !== "") {
        $stmt = $pdo->prepare(
            "UPDATE admin_users
             SET username = :username, password_hash = :hash, must_change_password = FALSE
             WHERE id = :id"
        );
        $stmt->execute([
            "username" => $username,
            "hash" => password_hash($newPassword, PASSWORD_DEFAULT),
            "id" => $userId,
        ]);
        return;
    }

    $stmt = $pdo->prepare(
        "UPDATE admin_users SET username = :username WHERE id = :id"
    );
    $stmt->execute([
        "username" => $username,
        "id" => $userId,
    ]);
}

/** @return string|null Error message on failure */
function admin_delete_user(int $userId, int $actingUserId): ?string
{
    if ($userId === $actingUserId) {
        return "You cannot remove your own account while logged in.";
    }

    bootstrap_database();
    $pdo = db();
    $count = (int) $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    if ($count <= 1) {
        return "At least one admin user must remain.";
    }

    $del = $pdo->prepare("DELETE FROM admin_users WHERE id = :id");
    $del->execute(["id" => $userId]);
    if ($del->rowCount() === 0) {
        return "User not found.";
    }

    return null;
}

function admin_logout(): void
{
    admin_session_start();
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), "", time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
}
