<?php
declare(strict_types=1);

function db_config(): array
{
    $defaults = [
        "host" => "127.0.0.1",
        "port" => "5432",
        "name" => "infersioai_db",
        "user" => "infersioai_user",
        "pass" => "",
    ];

    $file = __DIR__ . "/../config/database.php";
    if (is_file($file)) {
        $fromFile = require $file;
        if (is_array($fromFile)) {
            $defaults = array_merge($defaults, $fromFile);
        }
    }

    $localFile = __DIR__ . "/../config/database.local.php";
    if (is_file($localFile)) {
        $fromLocal = require $localFile;
        if (is_array($fromLocal)) {
            $defaults = array_merge($defaults, $fromLocal);
        }
    }

    return [
        "host" => getenv("DB_HOST") ?: $defaults["host"],
        "port" => getenv("DB_PORT") ?: $defaults["port"],
        "name" => getenv("DB_NAME") ?: $defaults["name"],
        "user" => getenv("DB_USER") ?: $defaults["user"],
        "pass" => getenv("DB_PASS") !== false && getenv("DB_PASS") !== ""
            ? getenv("DB_PASS")
            : $defaults["pass"],
    ];
}

function db_connect_server(): PDO
{
    $c = db_config();
    $dsn = "pgsql:host={$c['host']};port={$c['port']};dbname=postgres";
    return new PDO($dsn, $c["user"], $c["pass"], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $c = db_config();
    $dsn = "pgsql:host={$c['host']};port={$c['port']};dbname={$c['name']};connect_timeout=3";
    $pdo = new PDO($dsn, $c["user"], $c["pass"], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}

function bootstrap_database(): void
{
    $pdo = db();

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS admin_users (
            id SERIAL PRIMARY KEY,
            username VARCHAR(80) NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            must_change_password BOOLEAN NOT NULL DEFAULT TRUE,
            created_at TIMESTAMP NOT NULL DEFAULT NOW()
        )"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS clients (
            id SERIAL PRIMARY KEY,
            company_name VARCHAR(180) NOT NULL,
            company_website TEXT NOT NULL,
            logo_path TEXT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT NOW(),
            updated_at TIMESTAMP NOT NULL DEFAULT NOW()
        )"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS service_projects (
            id SERIAL PRIMARY KEY,
            service_type VARCHAR(60) NOT NULL,
            category VARCHAR(140) NOT NULL DEFAULT '',
            client_name VARCHAR(180) NOT NULL,
            client_website TEXT NOT NULL,
            simple_description TEXT NOT NULL DEFAULT '',
            engagement_start_date DATE NOT NULL,
            delivery_date DATE NOT NULL,
            project_value NUMERIC(12,2) NOT NULL DEFAULT 0,
            created_at TIMESTAMP NOT NULL DEFAULT NOW(),
            updated_at TIMESTAMP NOT NULL DEFAULT NOW()
        )"
    );

    // Backward-compatible migrations for existing databases
    $pdo->exec("ALTER TABLE service_projects ADD COLUMN IF NOT EXISTS category VARCHAR(140) NOT NULL DEFAULT ''");
    $pdo->exec("ALTER TABLE service_projects ADD COLUMN IF NOT EXISTS simple_description TEXT NOT NULL DEFAULT ''");

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS team_members (
            id SERIAL PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            role VARCHAR(120) NOT NULL,
            image_url TEXT NOT NULL,
            profile_link TEXT NOT NULL,
            sort_order INT NOT NULL DEFAULT 0,
            created_at TIMESTAMP NOT NULL DEFAULT NOW(),
            updated_at TIMESTAMP NOT NULL DEFAULT NOW()
        )"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS visitor_comments (
            id SERIAL PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            company VARCHAR(180) NOT NULL,
            comment_text TEXT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT NOW()
        )"
    );

    seed_admin_user_if_missing($pdo);
    admin_purge_stale_bootstrap_users($pdo);
}

/**
 * Create default admin/admin only when the table is empty (first install).
 * Do not re-create "admin" after the first account is renamed during setup.
 */
function seed_admin_user_if_missing(?PDO $pdo = null): void
{
    $pdo = $pdo ?? db();

    $count = (int) $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    if ($count > 0) {
        return;
    }

    $insert = $pdo->prepare(
        "INSERT INTO admin_users (username, password_hash, must_change_password)
         VALUES (:username, :hash, TRUE)"
    );
    $insert->execute([
        "username" => "admin",
        "hash" => password_hash("admin", PASSWORD_DEFAULT),
    ]);
}

/** Run from setup/install.php only — single bootstrap admin/admin (one-time login). */
function reset_admin_credentials(?PDO $pdo = null): void
{
    $pdo = $pdo ?? db();
    $pdo->exec("DELETE FROM admin_users");
    seed_admin_user_if_missing($pdo);
}

function ensure_database_exists(): void
{
    $c = db_config();
    $safeName = preg_replace('/[^a-zA-Z0-9_]/', '', $c["name"]) ?: "infersioai_db";

    try {
        $dsn = "pgsql:host={$c['host']};port={$c['port']};dbname={$safeName}";
        $test = new PDO($dsn, $c["user"], $c["pass"], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        unset($test);
        return;
    } catch (Throwable) {
        // Target database not reachable — try to create (local dev / superuser only).
    }

    try {
        $pdo = db_connect_server();
        $exists = $pdo->prepare("SELECT 1 FROM pg_database WHERE datname = :name");
        $exists->execute(["name" => $safeName]);
        if (!$exists->fetchColumn()) {
            $pdo->exec('CREATE DATABASE "' . str_replace('"', '""', $safeName) . '"');
        }
    } catch (Throwable $e) {
        throw new RuntimeException(
            'Cannot connect to database "' . $safeName . '". On AWS Lightsail, create the database '
            . 'and user in the console first, then set host/user/password in config/database.php. '
            . $e->getMessage(),
            0,
            $e
        );
    }
}

/** @return array{ai-solutions: int, web-solutions: int, mobile-applications: int, software-development: int, clients: int, today_revenue: float} */
function public_home_counters(): array
{
    $counters = [
        "ai-solutions" => 0,
        "web-solutions" => 0,
        "mobile-applications" => 0,
        "software-development" => 0,
        "clients" => 0,
        "today_revenue" => 0.0,
    ];

    try {
        bootstrap_database();
        $pdo = db();

        $countStmt = $pdo->query(
            "SELECT service_type, COUNT(*) AS total
             FROM service_projects
             GROUP BY service_type"
        );
        foreach ($countStmt->fetchAll() as $row) {
            $serviceType = (string) ($row["service_type"] ?? "");
            if (array_key_exists($serviceType, $counters)) {
                $counters[$serviceType] = (int) $row["total"];
            }
        }
    } catch (Throwable $e) {
        // service_projects table may be absent — ignore
    }

    try {
        bootstrap_database();
        $pdo = db();
        $counters["clients"] = (int) $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
    } catch (Throwable $e) {
        // Keep homepage resilient if DB is unavailable.
    }

    try {
        bootstrap_database();
        $pdo = db();
        $counters["today_revenue"] = (float) $pdo->query(
            "SELECT COALESCE(SUM(project_value), 0)
             FROM service_projects
             WHERE DATE(created_at) = CURRENT_DATE"
        )->fetchColumn();
    } catch (Throwable $e) {
        // service_projects table may be absent — ignore
    }

    return $counters;
}

function public_clients(): array
{
    try {
        bootstrap_database();
        $pdo = db();
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $stmt = $pdo->query(
            "SELECT id, company_name, company_website, logo_path
             FROM clients
             ORDER BY created_at DESC"
        );
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}

/** @return list<array<string, mixed>> */
function clients_for_display(?array $clients = null): array
{
    require_once __DIR__ . "/uploads.php";

    if ($clients === null) {
        $clients = public_clients();
    }

    $display = [];
    foreach ($clients as $client) {
        if (!is_array($client)) {
            continue;
        }
        $logo = (string) ($client["logo_path"] ?? "");
        if ($logo === "") {
            continue;
        }
        $client["logo_path"] = uploads_public_src($logo);
        $display[] = $client;
    }

    return $display;
}

/** @return list<array{name: string, role: string, image_url: string, profile_link: string}> */
function public_team_members(): array
{
    try {
        bootstrap_database();
        $pdo = db();
        $stmt = $pdo->query(
            "SELECT name, role, image_url, profile_link
             FROM team_members
             ORDER BY sort_order ASC, id ASC"
        );
        return $stmt->fetchAll();
    } catch (Throwable $e) {
        return [];
    }
}
