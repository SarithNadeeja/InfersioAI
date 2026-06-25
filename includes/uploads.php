<?php
declare(strict_types=1);

/**
 * Admin uploads — stored OUTSIDE the git repo on production when possible.
 * Default server path: sibling folder ../uploads (e.g. /home/ubuntu/uploads).
 */

function uploads_project_root(): string
{
    return dirname(__DIR__);
}

/** @return list<string> */
function uploads_external_dir_candidates(): array
{
    $root = uploads_project_root();
    $parent = dirname($root);

    return array_values(array_unique([
        $parent . DIRECTORY_SEPARATOR . "uploads",
        "/home/ubuntu/uploads",
        "/var/www/uploads",
    ]));
}

function uploads_configured_base_dir(): string
{
    static $dir = null;
    if ($dir !== null) {
        return $dir;
    }

    $dir = uploads_project_root() . DIRECTORY_SEPARATOR . "uploads";

    $localFile = __DIR__ . "/../config/uploads.local.php";
    if (is_file($localFile)) {
        $fromLocal = require $localFile;
        if (is_array($fromLocal) && !empty($fromLocal["base_dir"])) {
            $dir = (string) $fromLocal["base_dir"];
        }
    }

    $envDir = getenv("UPLOADS_DIR");
    if ($envDir !== false && $envDir !== "") {
        $dir = $envDir;
    } elseif (!is_file($localFile)) {
        $external = uploads_detect_external_base_dir();
        if ($external !== null) {
            $dir = $external;
        }
    }

    $dir = rtrim(str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $dir), DIRECTORY_SEPARATOR);
    return $dir;
}

function uploads_dir_is_writable(string $dir): bool
{
    if (!is_dir($dir)) {
        return false;
    }

    if (!is_writable($dir)) {
        return false;
    }

    $test = $dir . DIRECTORY_SEPARATOR . ".write_test_" . getmypid();
    $written = @file_put_contents($test, "1");
    if ($written === false) {
        return false;
    }
    @unlink($test);

    return true;
}

function uploads_detect_external_base_dir(): ?string
{
    foreach (uploads_external_dir_candidates() as $candidate) {
        $resolved = realpath($candidate);
        if ($resolved !== false && uploads_dir_is_writable($resolved)) {
            return $resolved;
        }
    }

    return null;
}

/**
 * Path used for mkdir/move_uploaded_file. Prefers project/uploads when it is a
 * symlink to the configured external folder so PHP open_basedir still allows writes.
 */
function uploads_base_dir(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $configured = uploads_configured_base_dir();
    $projectUploads = uploads_project_root() . DIRECTORY_SEPARATOR . "uploads";
    $configuredReal = realpath($configured);

    if (is_link($projectUploads)) {
        $linkTarget = realpath($projectUploads);
        if ($linkTarget !== false && ($configuredReal === false || $linkTarget === $configuredReal)) {
            $base = $projectUploads;
            return $base;
        }
    }

    if ($configuredReal !== false && uploads_path_is_under_root($configuredReal, uploads_project_root())) {
        $base = $configuredReal;
        return $base;
    }

    if (is_dir($projectUploads) && !is_link($projectUploads)) {
        $projectReal = realpath($projectUploads);
        if ($projectReal !== false && ($configuredReal === false || $projectReal === $configuredReal)) {
            $base = $projectUploads;
            return $base;
        }
    }

    $base = $configured;
    return $base;
}

/** @return list<string> */
function uploads_allowed_roots(): array
{
    $roots = [];
    foreach ([uploads_base_dir(), uploads_configured_base_dir()] as $candidate) {
        $resolved = realpath($candidate);
        $path = $resolved !== false ? $resolved : $candidate;
        if (!in_array($path, $roots, true)) {
            $roots[] = $path;
        }
    }

    foreach (uploads_external_dir_candidates() as $external) {
        $resolved = realpath($external);
        if ($resolved !== false && is_dir($resolved) && !in_array($resolved, $roots, true)) {
            $roots[] = $resolved;
        }
    }

    $legacy = realpath(uploads_project_root() . DIRECTORY_SEPARATOR . "uploads");
    if ($legacy !== false && !in_array($legacy, $roots, true)) {
        $roots[] = $legacy;
    }

    return $roots;
}

function uploads_can_write_to_dir(string $dir): bool
{
    if (!is_dir($dir)) {
        if (!@mkdir($dir, 0775, true) && !is_dir($dir)) {
            return false;
        }
    }

    if (!uploads_dir_is_writable($dir)) {
        @chmod($dir, 0775);
    }

    return uploads_dir_is_writable($dir);
}

function uploads_permission_fix_hint(): string
{
    return "SSH to the server and run: bash deploy/ensure-external-uploads.sh "
        . "(fixes www-data write access to /home/ubuntu/uploads).";
}

/**
 * @return array{ok: bool, path: string, error: string}
 */
function uploads_ensure_subdir(string $subdir): array
{
    $subdir = trim(str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $subdir), DIRECTORY_SEPARATOR);
    $candidates = array_values(array_unique([
        uploads_base_dir(),
        uploads_project_root() . DIRECTORY_SEPARATOR . "uploads",
        uploads_configured_base_dir(),
    ]));

    foreach ($candidates as $base) {
        $dir = $base . DIRECTORY_SEPARATOR . $subdir;
        if (uploads_can_write_to_dir($dir)) {
            return [
                "ok" => true,
                "path" => $dir,
                "error" => "",
            ];
        }
    }

    $display = uploads_configured_base_dir() . DIRECTORY_SEPARATOR . $subdir;

    return [
        "ok" => false,
        "path" => $display,
        "error" => "Upload folder is not writable: " . $display
            . ". The web server (www-data) needs write access. "
            . uploads_permission_fix_hint(),
    ];
}

/**
 * @return array{ok: bool, stored_path: string, error: string}
 */
function uploads_save_uploaded_file(string $tmpPath, string $subdir, string $filename): array
{
    $dirResult = uploads_ensure_subdir($subdir);
    if (!$dirResult["ok"]) {
        return [
            "ok" => false,
            "stored_path" => "",
            "error" => $dirResult["error"],
        ];
    }

    $target = $dirResult["path"] . DIRECTORY_SEPARATOR . ltrim($filename, "/\\");
    if (!is_uploaded_file($tmpPath)) {
        return [
            "ok" => false,
            "stored_path" => "",
            "error" => "Invalid upload temp file.",
        ];
    }

    if (!move_uploaded_file($tmpPath, $target)) {
        $hint = "Check that the web server can write to the uploads folder.";
        if (is_link(uploads_project_root() . DIRECTORY_SEPARATOR . "uploads")) {
            $hint = "Run: bash deploy/ensure-external-uploads.sh and ensure www-data owns /home/ubuntu/uploads.";
        }

        return [
            "ok" => false,
            "stored_path" => "",
            "error" => "Failed to save uploaded file. " . $hint,
        ];
    }

    @chmod($target, 0664);

    return [
        "ok" => true,
        "stored_path" => uploads_store_relative_path($subdir, $filename),
        "error" => "",
    ];
}

function uploads_store_relative_path(string $subdir, string $filename): string
{
    return "uploads/" . trim($subdir, "/\\") . "/" . ltrim($filename, "/\\");
}

function uploads_relative_from_stored(string $storedPath): string
{
    return ltrim((string) preg_replace('#^uploads[/\\\\]#i', "", $storedPath), "/\\");
}

function uploads_resolve_fs_path(string $storedPath): ?string
{
    if ($storedPath === "" || preg_match('#^https?://#i', $storedPath)) {
        return null;
    }

    $relative = uploads_relative_from_stored($storedPath);
    foreach (uploads_allowed_roots() as $root) {
        $candidate = $root . DIRECTORY_SEPARATOR . str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $relative);
        $real = realpath($candidate);
        if ($real !== false && is_file($real) && uploads_path_is_under_root($real, $root)) {
            return $real;
        }
    }

    return null;
}

function uploads_path_is_under_root(string $absolutePath, string $root): bool
{
    $real = realpath($absolutePath);
    $base = realpath($root);
    if ($real === false || $base === false) {
        return false;
    }
    if ($real === $base) {
        return true;
    }
    $prefix = $base . DIRECTORY_SEPARATOR;
    return str_starts_with($real, $prefix);
}

function uploads_delete_stored_file(string $storedPath): void
{
    $abs = uploads_resolve_fs_path($storedPath);
    if ($abs === null) {
        return;
    }
    foreach (uploads_allowed_roots() as $root) {
        if (uploads_path_is_under_root($abs, $root)) {
            @unlink($abs);
            return;
        }
    }
}

function uploads_site_base(string $prefix = ""): string
{
    if ($prefix === "..") {
        return "..";
    }
    if ($prefix !== "") {
        return rtrim(str_replace("\\", "/", $prefix), "/");
    }

    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $scriptDir = str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? ""));
    if ($scriptDir === "/" || $scriptDir === ".") {
        $base = "";
    } else {
        $base = rtrim($scriptDir, "/");
    }

    return $base;
}

function uploads_public_src(string $storedPath, string $prefix = ""): string
{
    if ($storedPath === "") {
        return "";
    }
    if (preg_match('#^https?://#i', $storedPath)) {
        return $storedPath;
    }

    $relative = uploads_relative_from_stored($storedPath);
    $relativeUrl = str_replace("\\", "/", $relative);

    if (uploads_resolve_fs_path($storedPath) !== null) {
        $query = "media.php?f=" . rawurlencode($relativeUrl);
        if ($prefix === "..") {
            return "../" . $query;
        }
        if ($prefix !== "") {
            return rtrim(str_replace("\\", "/", $prefix), "/") . "/" . $query;
        }
        $base = uploads_site_base();
        return ($base !== "" ? $base . "/" : "/") . $query;
    }

    $path = ltrim(str_replace("\\", "/", $storedPath), "/");
    if ($prefix === "..") {
        return "../" . $path;
    }
    if ($prefix !== "") {
        return rtrim(str_replace("\\", "/", $prefix), "/") . "/" . $path;
    }
    $base = uploads_site_base();
    return ($base !== "" ? $base . "/" : "") . $path;
}
