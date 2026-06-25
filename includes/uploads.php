<?php
declare(strict_types=1);

/**
 * Admin uploads — filesystem path is configurable (e.g. /home/ubuntu/uploads).
 * URLs stay as uploads/client-logos/… — symlink website/uploads → base_dir on the server.
 */

function uploads_config(): array
{
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    $defaults = [
        "base_dir" => dirname(__DIR__) . DIRECTORY_SEPARATOR . "uploads",
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
    $legacy = realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . "uploads");
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

/** Public URL path for &lt;img src&gt; (website root or admin ../ prefix). */
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

/** Public URL path for &lt;img src&gt; (website root or admin ../ prefix). */
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
