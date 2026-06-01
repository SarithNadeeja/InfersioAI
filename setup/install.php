<?php
declare(strict_types=1);

/**
 * One-time PostgreSQL setup for InfersioAI.
 * Open: http://localhost/InfersioAI/setup/install.php
 * Delete or protect this folder after successful install.
 */

require_once __DIR__ . "/../includes/db.php";

$steps = [];
$error = null;

if (!extension_loaded("pdo_pgsql")) {
    $error = "PHP extension pdo_pgsql is not enabled. Enable it in php.ini and restart Apache.";
} else {
    try {
        ensure_database_exists();
        $steps[] = "Database checked/created.";

        bootstrap_database();
        $steps[] = "Tables created or verified.";

        reset_admin_credentials();
        $steps[] = "Admin login: username admin, password admin.";

        $lockDir = __DIR__ . "/../storage";
        if (!is_dir($lockDir)) {
            mkdir($lockDir, 0777, true);
        }
        file_put_contents($lockDir . "/installed.lock", date("c") . PHP_EOL);
        $steps[] = "Install lock written.";
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$c = db_config();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfersioAI Setup</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #0f1117; color: #e8e8ef; margin: 0; padding: 40px 20px; }
        .card { max-width: 640px; margin: 0 auto; background: #171a22; border: 1px solid #2a2f3d; border-radius: 12px; padding: 28px; }
        h1 { margin: 0 0 8px; font-size: 1.5rem; }
        p { color: #a8afc0; line-height: 1.5; }
        ul { padding-left: 20px; }
        .ok { color: #7dffb2; }
        .err { color: #ff8f9b; background: rgba(255, 80, 100, 0.12); padding: 12px; border-radius: 8px; }
        a { color: #8ab4ff; }
        code { background: #0d1018; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>InfersioAI — PostgreSQL Setup</h1>
        <p>Target database: <code><?= htmlspecialchars($c["name"]) ?></code> on
            <code><?= htmlspecialchars($c["host"]) ?>:<?= htmlspecialchars($c["port"]) ?></code>
            as user <code><?= htmlspecialchars($c["user"]) ?></code>.</p>

        <?php if ($error): ?>
            <div class="err"><strong>Setup failed:</strong> <?= htmlspecialchars($error) ?></div>
            <p>Check that PostgreSQL is running, credentials in <code>config/database.php</code> are correct, and the <code>pdo_pgsql</code> PHP extension is enabled.</p>
        <?php else: ?>
            <p class="ok"><strong>Setup completed successfully.</strong></p>
            <ul>
                <?php foreach ($steps as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                <?php endforeach; ?>
            </ul>
            <p>
                <a href="../admin/login.php">Open Admin Login</a>
            </p>
            <p>For security, remove or restrict access to the <code>setup/</code> folder after install.</p>
        <?php endif; ?>
    </div>
</body>
</html>
