<?php
declare(strict_types=1);

/**
 * Admin uploads live in storage/uploads/ inside the project (gitignored).
 * www-data can always write there. Old files in /home/ubuntu/uploads are still readable.
 */

function uploads_project_root(): string
{
    return dirname(__DIR__);
}

/** Writable storage — real directory, never a symlink. */
function uploads_storage_dir(): string
{
    return uploads_project_root() . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . "uploads";
}

/** @return list<string> */
function uploads_legacy_dir_candidates(): array
{
    $root = uploads_project_root();

    return array_values(array_unique([
        $root . DIRECTORY_SEPARATOR . "uploads",
        dirname($root) . DIRECTORY_SEPARATOR . "uploads",
        "/home/ubuntu/uploads",
        "/var/www/uploads",
    ]));
}

/** Optional override from config/env — only used when writable. */
function uploads_configured_dir(): ?string
{
    $localFile = __DIR__ . "/../config/uploads.local.php";
    if (is_file($localFile)) {
        $fromLocal = require $localFile;
        if (is_array($fromLocal) && !empty($fromLocal["base_dir"])) {
            return rtrim(str_replace(["/", "\\"], DIRECTORY_SEPARATOR, (string) $fromLocal["base_dir"]), DIRECTORY_SEPARATOR);
        }
    }

    $envDir = getenv("UPLOADS_DIR");
    if ($envDir !== false && $envDir !== "") {
        return rtrim(str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $envDir), DIRECTORY_SEPARATOR);
    }

    return null;
}

function uploads_dir_is_writable(string $dir): bool
{
    if (!is_dir($dir) || is_link($dir)) {
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

function uploads_can_write_to_dir(string $dir): bool
{
    if (is_link($dir)) {
        return false;
    }

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

/** Directory used for new uploads — always storage/uploads inside the project. */
function uploads_base_dir(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $configured = uploads_configured_dir();
    if ($configured !== null && uploads_can_write_to_dir($configured)) {
        $base = realpath($configured) ?: $configured;
        return $base;
    }

    $storage = uploads_storage_dir();
    uploads_can_write_to_dir($storage);
    $base = realpath($storage) ?: $storage;

    return $base;
}

/** @return list<string> */
function uploads_allowed_roots(): array
{
    $roots = [];
    $candidates = [
        uploads_storage_dir(),
        uploads_project_root() . DIRECTORY_SEPARATOR . "uploads",
        dirname(uploads_project_root()) . DIRECTORY_SEPARATOR . "uploads",
        "/home/ubuntu/uploads",
        "/var/www/uploads",
    ];

    $configured = uploads_configured_dir();
    if ($configured !== null) {
        $candidates[] = $configured;
    }

    foreach ($candidates as $candidate) {
        $resolved = realpath($candidate);
        $path = $resolved !== false ? $resolved : $candidate;
        if (!in_array($path, $roots, true)) {
            $roots[] = $path;
        }
    }

    foreach (uploads_legacy_dir_candidates() as $legacy) {
        if (is_link($legacy)) {
            $target = realpath($legacy);
            if ($target !== false && is_dir($target) && !in_array($target, $roots, true)) {
                $roots[] = $target;
            }
            continue;
        }
        $resolved = realpath($legacy);
        if ($resolved !== false && is_dir($resolved) && !in_array($resolved, $roots, true)) {
            $roots[] = $resolved;
        }
    }

    return $roots;
}

/**
 * @return array{ok: bool, path: string, error: string}
 */
function uploads_ensure_subdir(string $subdir): array
{
    $subdir = trim(str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $subdir), DIRECTORY_SEPARATOR);
    $dir = uploads_base_dir() . DIRECTORY_SEPARATOR . $subdir;

    if (uploads_can_write_to_dir($dir)) {
        return [
            "ok" => true,
            "path" => $dir,
            "error" => "",
        ];
    }

    return [
        "ok" => false,
        "path" => $dir,
        "error" => "Upload folder is not writable: " . $dir
            . ". Run on the server: bash deploy/ensure-external-uploads.sh",
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
        return [
            "ok" => false,
            "stored_path" => "",
            "error" => "Failed to save uploaded file. Run: bash deploy/ensure-external-uploads.sh",
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

function uploads_normalize_relative(string $storedPath): string
{
    $storedPath = trim(str_replace("\\", "/", $storedPath));
    if ($storedPath === "") {
        return "";
    }

    if (preg_match('#(?:^|/)client-logos/([^/?#]+)$#i', $storedPath, $matches)) {
        return "client-logos/" . $matches[1];
    }

    if (preg_match('#(?:^|/)team-photos/([^/?#]+)$#i', $storedPath, $matches)) {
        return "team-photos/" . $matches[1];
    }

    return uploads_relative_from_stored($storedPath);
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

    $relative = uploads_normalize_relative($storedPath);
    if ($relative === "") {
        return null;
    }

    $relativeFs = str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $relative);
    foreach (uploads_allowed_roots() as $root) {
        $candidate = $root . DIRECTORY_SEPARATOR . $relativeFs;
        if (!is_file($candidate)) {
            continue;
        }

        $real = realpath($candidate) ?: $candidate;
        if (uploads_path_is_under_root($real, $root)) {
            return $real;
        }
    }

    return null;
}

function uploads_path_is_under_root(string $absolutePath, string $root): bool
{
    $real = realpath($absolutePath);
    if ($real === false) {
        return false;
    }

    $base = realpath($root);
    if ($base !== false) {
        if ($real === $base) {
            return true;
        }
        return str_starts_with($real, $base . DIRECTORY_SEPARATOR);
    }

    $rootNorm = rtrim(str_replace("\\", "/", $root), "/");
    $pathNorm = str_replace("\\", "/", $real);

    return $pathNorm === $rootNorm || str_starts_with($pathNorm, $rootNorm . "/");
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

    $relative = uploads_normalize_relative($storedPath);
    if ($relative === "") {
        $relative = ltrim(str_replace("\\", "/", $storedPath), "/");
    }
    $relativeUrl = str_replace("\\", "/", $relative);
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
