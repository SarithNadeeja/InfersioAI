<?php
declare(strict_types=1);

/**
 * Admin uploads — persisted outside the web root (e.g. /var/www/infersio-uploads).
 * storage/uploads/ in the project is a symlink to that folder.
 */

function uploads_project_root(): string
{
    return dirname(__DIR__);
}

function uploads_persistent_dir(): string
{
    static $dir = null;
    if ($dir !== null) {
        return $dir;
    }

    $localFile = __DIR__ . "/../config/uploads.local.php";
    if (is_file($localFile)) {
        $fromLocal = require $localFile;
        if (is_array($fromLocal) && !empty($fromLocal["base_dir"])) {
            $dir = rtrim(str_replace(["/", "\\"], DIRECTORY_SEPARATOR, (string) $fromLocal["base_dir"]), DIRECTORY_SEPARATOR);
            return $dir;
        }
    }

    $envDir = getenv("UPLOADS_DIR");
    if ($envDir !== false && $envDir !== "") {
        $dir = rtrim(str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $envDir), DIRECTORY_SEPARATOR);
        return $dir;
    }

    foreach ([
        "/var/www/infersio-uploads",
        "/home/ubuntu/uploads",
        dirname(uploads_project_root()) . DIRECTORY_SEPARATOR . "uploads",
    ] as $candidate) {
        if (is_dir($candidate)) {
            $resolved = realpath($candidate);
            $dir = $resolved !== false ? $resolved : $candidate;
            return $dir;
        }
    }

    $dir = uploads_project_root() . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . "uploads";
    return $dir;
}

/** Path under the project used for /uploads/ URLs (usually a symlink). */
function uploads_storage_dir(): string
{
    return uploads_project_root() . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . "uploads";
}

/** @return list<string> */
function uploads_legacy_dir_candidates(): array
{
    $root = uploads_project_root();

    return array_values(array_unique([
        uploads_persistent_dir(),
        uploads_storage_dir(),
        $root . DIRECTORY_SEPARATOR . "uploads",
        dirname($root) . DIRECTORY_SEPARATOR . "uploads",
        "/var/www/infersio-uploads",
        "/home/ubuntu/uploads",
        "/var/www/uploads",
        "/var/www/html/storage/uploads",
    ]));
}

/** Optional override from config/env. */
function uploads_configured_dir(): ?string
{
    $persistent = uploads_persistent_dir();
    $storage = uploads_storage_dir();
    if ($persistent !== $storage && is_dir($persistent)) {
        return $persistent;
    }

    return null;
}

function uploads_resolve_dir(string $dir): string
{
    if (is_link($dir)) {
        return $dir;
    }

    $resolved = realpath($dir);
    return $resolved !== false ? $resolved : $dir;
}

/** True when writes must stay on the project storage path (symlink / open_basedir). */
function uploads_use_storage_path_for_writes(): bool
{
    $storage = uploads_storage_dir();
    return is_link($storage) || is_dir($storage);
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

function uploads_can_write_to_dir(string $dir): bool
{
    if (!is_dir($dir)) {
        if (!@mkdir($dir, 0775, true) && !is_dir($dir)) {
            return false;
        }
    }

    if (!uploads_dir_is_writable($dir)) {
        @chmod($dir, 2775);
    }

    return uploads_dir_is_writable($dir);
}

/**
 * Directory used for move_uploaded_file — never resolved through symlinks
 * (PHP open_basedir blocks writes to /home/ubuntu/... even when symlinked).
 */
function uploads_base_dir(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    if (uploads_use_storage_path_for_writes()) {
        $base = uploads_storage_dir();
        return $base;
    }

    $persistent = uploads_persistent_dir();
    if (!is_dir($persistent)) {
        @mkdir($persistent, 0775, true);
    }
    $base = $persistent;

    return $base;
}

/** @return list<string> */
function uploads_allowed_roots(): array
{
    $roots = [];
    $candidates = [
        uploads_persistent_dir(),
        uploads_storage_dir(),
        uploads_project_root() . DIRECTORY_SEPARATOR . "uploads",
        dirname(uploads_project_root()) . DIRECTORY_SEPARATOR . "uploads",
        "/var/www/infersio-uploads",
        "/home/ubuntu/uploads",
        "/var/www/uploads",
        "/var/www/html/storage/uploads",
    ];

    $configured = uploads_configured_dir();
    if ($configured !== null) {
        $candidates[] = $configured;
    }

    foreach ($candidates as $candidate) {
        if (!in_array($candidate, $roots, true)) {
            $roots[] = $candidate;
        }
        $resolved = realpath($candidate);
        if ($resolved !== false && !in_array($resolved, $roots, true)) {
            $roots[] = $resolved;
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
            . ". On the server run: sudo bash deploy/sync-to-web.sh",
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

function uploads_resolve_read_paths(string $storedPath): array
{
    if ($storedPath === "" || preg_match('#^https?://#i', $storedPath)) {
        return [];
    }

    $relative = uploads_normalize_relative($storedPath);
    if ($relative === "") {
        return [];
    }

    $relativeFs = str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $relative);
    $paths = [];
    $seen = [];

    $add = static function (string $path) use (&$paths, &$seen): void {
        if ($path === "" || isset($seen[$path])) {
            return;
        }
        $seen[$path] = true;
        $paths[] = $path;
    };

    $add(uploads_storage_dir() . DIRECTORY_SEPARATOR . $relativeFs);

    foreach (uploads_allowed_roots() as $root) {
        $add($root . DIRECTORY_SEPARATOR . $relativeFs);
    }

    return $paths;
}

function uploads_resolve_fs_path(string $storedPath): ?string
{
    foreach (uploads_resolve_read_paths($storedPath) as $candidate) {
        if (is_file($candidate) && is_readable($candidate)) {
            return $candidate;
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

    if (is_link($root)) {
        $linkTarget = realpath($root);
        if ($linkTarget !== false) {
            return uploads_path_is_under_root($real, $linkTarget);
        }
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

function uploads_web_base(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $docRoot = realpath((string) ($_SERVER["DOCUMENT_ROOT"] ?? ""));
    $projectRoot = realpath(uploads_project_root());
    if ($docRoot !== false && $projectRoot !== false && str_starts_with($projectRoot, $docRoot)) {
        $relative = substr($projectRoot, strlen($docRoot));
        $relative = str_replace("\\", "/", $relative);
        $base = rtrim($relative, "/");
        return $base;
    }

    $scriptDir = str_replace("\\", "/", dirname((string) ($_SERVER["SCRIPT_NAME"] ?? "/index.php")));
    if ($scriptDir === "/" || $scriptDir === ".") {
        $base = "";
    } else {
        $base = rtrim($scriptDir, "/");
    }

    return $base;
}

function uploads_site_base(string $prefix = ""): string
{
    if ($prefix === "..") {
        return "..";
    }
    if ($prefix !== "") {
        return rtrim(str_replace("\\", "/", $prefix), "/");
    }

    return uploads_web_base();
}

function uploads_public_src(string $storedPath, string $prefix = ""): string
{
    if ($storedPath === "") {
        return "";
    }
    if (preg_match('#^https?://#i', $storedPath)) {
        return $storedPath;
    }
    if (str_contains($storedPath, "media.php?f=")) {
        return $storedPath;
    }

    $relative = uploads_normalize_relative($storedPath);
    if ($relative === "") {
        $relative = ltrim(preg_replace('#^uploads/#i', "", str_replace("\\", "/", $storedPath)), "/");
    }
    $relativeUrl = str_replace("\\", "/", $relative);
    $webPath = "storage/uploads/" . $relativeUrl;

    if ($prefix === "..") {
        return "../" . $webPath;
    }
    if ($prefix !== "") {
        return rtrim(str_replace("\\", "/", $prefix), "/") . "/" . $webPath;
    }

    return "/" . $webPath;
}
