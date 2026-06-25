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

function uploads_detect_external_base_dir(): ?string
{
    foreach (uploads_external_dir_candidates() as $candidate) {
        $resolved = realpath($candidate);
        if ($resolved !== false && is_dir($resolved) && is_readable($resolved)) {
            return $resolved;
        }
    }

    return null;
}

/** @return list<string> */
function uploads_external_roots(): array
{
    $roots = [];
    foreach (uploads_external_dir_candidates() as $candidate) {
        $resolved = realpath($candidate);
        if ($resolved !== false && is_dir($resolved)) {
            $roots[] = $resolved;
        }
    }

    return $roots;
}

function uploads_config(): array
{
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    $defaults = [
        "base_dir" => uploads_project_root() . DIRECTORY_SEPARATOR . "uploads",
    ];

    $localFile = __DIR__ . "/../config/uploads.local.php";
    if (is_file($localFile)) {
        $fromLocal = require $localFile;
        if (is_array($fromLocal)) {
            $defaults = array_merge($defaults, $fromLocal);
        }
    }

    $envDir = getenv("UPLOADS_DIR");
    if ($envDir !== false && $envDir !== "") {
        $defaults["base_dir"] = $envDir;
    } elseif (!is_file($localFile)) {
        $external = uploads_detect_external_base_dir();
        if ($external !== null) {
            $defaults["base_dir"] = $external;
        }
    }

    $defaults["base_dir"] = rtrim(str_replace(["/", "\\"], DIRECTORY_SEPARATOR, (string) $defaults["base_dir"]), DIRECTORY_SEPARATOR);
    $config = $defaults;

    return $config;
}

function uploads_base_dir(): string
{
    return uploads_config()["base_dir"];
}

/** @return list<string> */
function uploads_allowed_roots(): array
{
    $roots = [uploads_base_dir()];

    foreach (uploads_external_roots() as $external) {
        if (!in_array($external, $roots, true)) {
            $roots[] = $external;
        }
    }

    $legacy = realpath(uploads_project_root() . DIRECTORY_SEPARATOR . "uploads");
    if ($legacy !== false && !in_array($legacy, $roots, true)) {
        $roots[] = $legacy;
    }

    return $roots;
}

function uploads_ensure_subdir(string $subdir): string
{
    $dir = uploads_base_dir() . DIRECTORY_SEPARATOR . trim(str_replace(["/", "\\"], DIRECTORY_SEPARATOR, $subdir), DIRECTORY_SEPARATOR);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    return $dir;
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
