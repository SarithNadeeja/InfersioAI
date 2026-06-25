<?php
declare(strict_types=1);

/**
 * @return list<array{key?: string, label: string, href?: string, section?: bool}>
 */
function admin_nav_items(): array
{
    return [
        ["key" => "dashboard", "label" => "Dashboard", "href" => "index.php"],
        ["section" => true, "label" => "Website content"],
        ["key" => "clients", "label" => "Clients", "href" => "clients.php"],
        ["key" => "leadership", "label" => "Leadership", "href" => "team.php"],
        ["key" => "comments", "label" => "Comments", "href" => "comments.php"],
        ["section" => true, "label" => "Administration"],
        ["key" => "users", "label" => "Users", "href" => "users.php"],
    ];
}

function admin_page_start(string $title, string $activeKey): void
{
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — InfersioAI Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-app">
        <aside class="admin-sidebar" aria-label="Admin navigation">
            <div class="admin-sidebar__brand">
                <span class="admin-sidebar__logo">IA</span>
                <div>
                    <strong>InfersioAI</strong>
                    <span>Admin Panel</span>
                </div>
            </div>
            <nav class="admin-sidebar__nav">
                <?php foreach (admin_nav_items() as $item): ?>
                    <?php if (!empty($item["section"])): ?>
                        <p class="admin-sidebar__section"><?= htmlspecialchars($item["label"]) ?></p>
                    <?php else: ?>
                        <a
                            class="admin-sidebar__link<?= ($item["key"] ?? "") === $activeKey ? " is-active" : "" ?>"
                            href="<?= htmlspecialchars((string) $item["href"]) ?>"
                        >
                            <?= htmlspecialchars($item["label"]) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
            <div class="admin-sidebar__footer">
                <a class="admin-sidebar__link admin-sidebar__link--muted" href="../index.php" target="_blank" rel="noopener noreferrer">View website</a>
                <a class="admin-sidebar__link admin-sidebar__link--logout" href="logout.php">Logout</a>
            </div>
        </aside>
        <div class="admin-main">
    <?php
}

function admin_page_header(string $heading, string $subtitle = ""): void
{
    ?>
            <header class="admin-topbar">
                <div>
                    <h1 class="admin-topbar__title"><?= htmlspecialchars($heading) ?></h1>
                    <?php if ($subtitle !== ""): ?>
                        <p class="admin-topbar__sub"><?= htmlspecialchars($subtitle) ?></p>
                    <?php endif; ?>
                </div>
            </header>
            <main class="admin-content">
    <?php
}

function admin_projects_active_key(string $service): string
{
    $map = [
        "ai-solutions" => "projects-ai",
        "web-solutions" => "projects-web",
        "mobile-applications" => "projects-mobile",
        "software-development" => "projects-software",
    ];

    return $map[$service] ?? "projects-ai";
}

function admin_page_end(): void
{
    ?>
            </main>
        </div>
    </div>
</body>
</html>
    <?php
}
