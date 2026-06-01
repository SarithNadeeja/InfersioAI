<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/comments.php";

session_start();

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["ok" => false, "error" => "method", "message" => "Method not allowed."]);
    exit;
}

$token = (string) ($_POST["csrf_token"] ?? "");
if ($token === "" || empty($_SESSION["comment_csrf"]) || !hash_equals($_SESSION["comment_csrf"], $token)) {
    http_response_code(403);
    echo json_encode(["ok" => false, "error" => "csrf", "message" => "Session expired. Please refresh the page and try again."]);
    exit;
}

$name = trim((string) ($_POST["name"] ?? ""));
$company = trim((string) ($_POST["company"] ?? ""));
$comment = trim((string) ($_POST["comment"] ?? ""));

if ($name === "" || $company === "" || $comment === "") {
    http_response_code(422);
    echo json_encode(["ok" => false, "error" => "missing", "message" => "Please fill in name, company, and comment."]);
    exit;
}

$len = static function (string $value): int {
    return function_exists("mb_strlen") ? mb_strlen($value) : strlen($value);
};

if ($len($name) > 120 || $len($company) > 180 || $len($comment) > 2000) {
    http_response_code(422);
    echo json_encode(["ok" => false, "error" => "invalid", "message" => "One or more fields are too long. Please shorten and try again."]);
    exit;
}

try {
    $row = insert_visitor_comment($name, $company, $comment);
    $_SESSION["comment_csrf"] = bin2hex(random_bytes(16));

    echo json_encode([
        "ok" => true,
        "message" => "Thank you — your comment has been added.",
        "csrf_token" => $_SESSION["comment_csrf"],
        "comment" => [
            "id" => (int) $row["id"],
            "name" => (string) $row["name"],
            "company" => (string) $row["company"],
            "comment_text" => (string) $row["comment_text"],
            "created_at" => (string) $row["created_at"],
        ],
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(["ok" => false, "error" => "error", "message" => "Could not save your comment. Please try again later."]);
}
