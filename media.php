<?php
declare(strict_types=1);

/**
 * Serves uploaded images from the configured uploads directory (including external paths).
 * URL: media.php?f=client-logos/filename.webp
 */

require_once __DIR__ . "/includes/uploads.php";

$relative = (string) ($_GET["f"] ?? "");
$relative = str_replace(["\\", "\0"], "/", $relative);
$relative = ltrim($relative, "/");

if ($relative === "" || str_contains($relative, "..")) {
    http_response_code(400);
    exit;
}

$stored = "uploads/" . $relative;
$absolute = uploads_resolve_fs_path($stored);

if ($absolute === null || !is_readable($absolute)) {
    http_response_code(404);
    exit;
}

$mime = mime_content_type($absolute) ?: "application/octet-stream";
$allowed = ["image/png", "image/jpeg", "image/webp", "image/gif"];
if (!in_array($mime, $allowed, true)) {
    http_response_code(403);
    exit;
}

header("Content-Type: " . $mime);
header("Cache-Control: public, max-age=86400");
header("Content-Length: " . (string) filesize($absolute));
readfile($absolute);
