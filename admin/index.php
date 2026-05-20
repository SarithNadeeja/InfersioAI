<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/admin_auth.php";

$user = admin_require_login();
if (!empty($user["must_change_password"])) {
    header("Location: change-password.php");
    exit;
}

bootstrap_database();
$pdo = db();

$totalClients = (int) $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
$totalProjects = (int) $pdo->query("SELECT COUNT(*) FROM service_projects")->fetchColumn();
$latestClients = $pdo->query(
    "SELECT company_name, company_website, created_at
     FROM clients
     ORDER BY created_at DESC
     LIMIT 5"
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - InfersioAI</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand">InfersioAI Admin</div>
            <a class="nav-link active" href="index.php">Dashboard</a>
            <a class="nav-link" href="clients.php">Client Manager</a>
            <a class="nav-link" href="team.php">Team (About)</a>
            <a class="nav-link" href="projects.php?service=ai-solutions">AI Solutions</a>
            <a class="nav-link" href="projects.php?service=web-solutions">Web Solutions</a>
            <a class="nav-link" href="projects.php?service=mobile-applications">Mobile Applications</a>
            <a class="nav-link" href="projects.php?service=software-development">Software Development</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </aside>
        <main class="content">
            <div class="card">
                <h2>Dashboard</h2>
                <p class="muted">Welcome, <?= htmlspecialchars((string) $user["username"]) ?>.</p>
                <p>Total Clients: <strong><?= $totalClients ?></strong></p>
                <p>Total Service Projects: <strong><?= $totalProjects ?></strong></p>
            </div>

            <div class="card">
                <h2>Recent Clients</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Website</th>
                                <th>Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$latestClients): ?>
                                <tr><td colspan="3" class="muted">No clients yet.</td></tr>
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
        </main>
    </div>
</body>
</html>
