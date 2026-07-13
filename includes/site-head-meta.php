<?php
declare(strict_types=1);

/**
 * Favicon, Open Graph, and Organization schema for search engines.
 *
 * Call after <title> on public pages:
 *   infersio_render_site_meta(["path" => "/about.php", "description" => "..."]);
 *
 * @param array{path?: string, description?: string, title?: string, image?: string} $options
 */
function infersio_site_base_url(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $host = trim((string) ($_SERVER["HTTP_HOST"] ?? "www.infersioai.com"));
    if ($host === "") {
        $host = "www.infersioai.com";
    }

    $https = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off")
        || (isset($_SERVER["SERVER_PORT"]) && (string) $_SERVER["SERVER_PORT"] === "443")
        || str_contains($host, "infersioai.com");

    $base = ($https ? "https" : "http") . "://" . $host;

    return $base;
}

function infersio_asset_url(string $relativePath): string
{
    $relativePath = "/" . ltrim(str_replace("\\", "/", $relativePath), "/");

    return infersio_site_base_url() . $relativePath;
}

/** @param array{path?: string, description?: string, title?: string, image?: string} $options */
function infersio_render_site_meta(array $options = []): void
{
    $defaultDescription = "We combine artificial intelligence, custom software development, and cloud technologies to create solutions that help businesses operate more efficiently and scale with confidence.";
    $description = trim((string) ($options["description"] ?? $defaultDescription));
    $title = trim((string) ($options["title"] ?? "InfersioAI"));
    $path = (string) ($options["path"] ?? "/");
    if ($path !== "/" && !str_starts_with($path, "/")) {
        $path = "/" . $path;
    }

    $canonical = infersio_site_base_url() . $path;
    $logoUrl = infersio_asset_url("assets/images/favicon-512.png");
    $icon192 = infersio_asset_url("assets/images/favicon-192.png");
    $icon512 = infersio_asset_url("assets/images/favicon-512.png");
    $ogImage = trim((string) ($options["image"] ?? ""));
    if ($ogImage === "") {
        $ogImage = $logoUrl;
    } elseif (!preg_match("#^https?://#i", $ogImage)) {
        $ogImage = infersio_asset_url($ogImage);
    }

    $schema = [
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "name" => "InfersioAI",
        "url" => infersio_site_base_url() . "/",
        "logo" => $logoUrl,
        "email" => "infersio.ai@gmail.com",
        "telephone" => "+94788197114",
        "description" => $description,
    ];
    ?>
    <meta name="description" content="<?= htmlspecialchars($description, ENT_QUOTES, "UTF-8") ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES, "UTF-8") ?>">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="48x48" href="/assets/images/favicon-48.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/images/favicon-192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#05070d">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="InfersioAI">
    <meta property="og:title" content="<?= htmlspecialchars($title, ENT_QUOTES, "UTF-8") ?>">
    <meta property="og:description" content="<?= htmlspecialchars($description, ENT_QUOTES, "UTF-8") ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical, ENT_QUOTES, "UTF-8") ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, "UTF-8") ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($title, ENT_QUOTES, "UTF-8") ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($description, ENT_QUOTES, "UTF-8") ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES, "UTF-8") ?>">
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <?php
}
