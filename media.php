<?php
declare(strict_types=1);

/**
 * Serves uploaded images — fallback when /storage/uploads/ URL is blocked.
 * URL: /media.php?f=client-logos/filename.webp
 */

require_once __DIR__ . "/includes/uploads.php";

$relative = (string) ($_GET["f"] ?? "");
$relative = str_replace(["\\", "\0"], "/", $relative);
$relative = ltrim($relative, "/");

if ($relative === "" || str_contains($relative, "..")) {
    http_response_code(400);
    exit;
}

try {
    $stored = "uploads/" . $relative;
    $absolute = uploads_resolve_fs_path($stored);

    if ($absolute === null || !is_readable($absolute)) {
        http_response_code(404);
        exit;
    }

    $ext = strtolower(pathinfo($absolute, PATHINFO_EXTENSION));
    $mimeMap = [
        "jpg" => "image/jpeg",
        "jpeg" => "image/jpeg",
        "png" => "image/png",
        "webp" => "image/webp",
        "gif" => "image/gif",
    ];
    $mime = $mimeMap[$ext] ?? null;
    if ($mime === null && function_exists("mime_content_type")) {
        $detected = mime_content_type($absolute);
        $mime = is_string($detected) ? $detected : null;
    }
    if ($mime === null || !in_array($mime, array_values($mimeMap), true)) {
        http_response_code(403);
        exit;
    }

    header("Content-Type: " . $mime);
    header("Cache-Control: public, max-age=86400");
    header("Content-Length: " . (string) filesize($absolute));
    readfile($absolute);
} catch (Throwable $e) {
    error_log("media.php error: " . $e->getMessage());
    http_response_code(500);
}
