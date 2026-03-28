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

function admin_force_password_change(int $userId, string $newPassword): void
{
    $pdo = db();
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
        "UPDATE admin_users
         SET password_hash = :hash, must_change_password = FALSE
         WHERE id = :id"
    );
    $stmt->execute([
        "hash" => $hash,
        "id" => $userId,
    ]);
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
