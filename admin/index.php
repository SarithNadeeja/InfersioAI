<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/admin_auth.php";
require_once __DIR__ . "/../includes/admin_layout.php";

$user = admin_require_login();
if (!empty($user["must_change_password"])) {
    header("Location: change-password.php");
    exit;
}

bootstrap_database();
$pdo = db();

$totalClients = (int) $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
$totalTeam = (int) $pdo->query("SELECT COUNT(*) FROM team_members")->fetchColumn();
$totalComments = (int) $pdo->query("SELECT COUNT(*) FROM visitor_comments")->fetchColumn();
$totalProjects = (int) $pdo->query("SELECT COUNT(*) FROM service_projects")->fetchColumn();

$latestClients = $pdo->query(
    "SELECT company_name, company_website, created_at
     FROM clients
     ORDER BY created_at DESC
     LIMIT 5"
)->fetchAll();

$latestTeam = $pdo->query(
    "SELECT name, role, created_at
     FROM team_members
     ORDER BY created_at DESC
     LIMIT 5"
)->fetchAll();

admin_page_start("Dashboard", "dashboard");
admin_page_header("Dashboard", "Welcome back, " . (string) $user["username"]);
?>

<div class="admin-stats">
    <article class="admin-stat-card">
        <p class="admin-stat-card__label">Clients</p>
        <p class="admin-stat-card__value"><?= $totalClients ?></p>
        <a href="clients.php">Manage clients →</a>
    </article>
    <article class="admin-stat-card">
        <p class="admin-stat-card__label">Leadership</p>
        <p class="admin-stat-card__value"><?= $totalTeam ?></p>
        <a href="team.php">Manage leadership →</a>
    </article>
    <article class="admin-stat-card">
        <p class="admin-stat-card__label">Comments</p>
        <p class="admin-stat-card__value"><?= $totalComments ?></p>
        <a href="comments.php">View comments →</a>
    </article>
    <article class="admin-stat-card">
        <p class="admin-stat-card__label">Projects</p>
        <p class="admin-stat-card__value"><?= $totalProjects ?></p>
        <a href="projects.php?service=ai-solutions">View projects →</a>
    </article>
</div>

<div class="admin-grid-2">
    <div class="card">
        <h2>Recent clients</h2>
        <p class="muted">Shown on the homepage and About page.</p>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Client name</th>
                        <th>Website</th>
                        <th>Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$latestClients): ?>
                        <tr><td colspan="3" class="muted">No clients yet. <a href="clients.php">Add one</a>.</td></tr>
                    <?php else: ?>
                        <?php foreach ($latestClients as $c): ?>
                            <tr>
                                <td><?= htmlspecialchars($c["company_name"]) ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($c["company_website"]) ?>" target="_blank" rel="noopener noreferrer">
                                        <?= htmlspecialchars($c["company_website"]) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars((string) $c["created_at"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h2>Recent leadership</h2>
        <p class="muted">Shown on the homepage and About page.</p>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Profession</th>
                        <th>Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$latestTeam): ?>
                        <tr><td colspan="3" class="muted">No members yet. <a href="team.php">Add one</a>.</td></tr>
                    <?php else: ?>
                        <?php foreach ($latestTeam as $m): ?>
                            <tr>
                                <td><?= htmlspecialchars($m["name"]) ?></td>
                                <td><?= htmlspecialchars($m["role"]) ?></td>
                                <td><?= htmlspecialchars((string) $m["created_at"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
admin_page_end();
