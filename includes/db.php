<?php
declare(strict_types=1);

function db_config(): array
{
    $defaults = [
        "host" => "127.0.0.1",
        "port" => "5432",
        "name" => "infersioai",
        "user" => "postgres",
        "pass" => "1234",
    ];

    $file = __DIR__ . "/../config/database.php";
    if (is_file($file)) {
        $fromFile = require $file;
        if (is_array($fromFile)) {
            $defaults = array_merge($defaults, $fromFile);
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
    $dsn = "pgsql:host={$c['host']};port={$c['port']};dbname={$c['name']}";
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
}

function seed_admin_user_if_missing(?PDO $pdo = null): void
{
    $pdo = $pdo ?? db();

    $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = :username LIMIT 1");
    $stmt->execute(["username" => "admin"]);
    if ($stmt->fetch()) {
        return;
    }

    $insert = $pdo->prepare(
        "INSERT INTO admin_users (username, password_hash, must_change_password)
         VALUES (:username, :hash, FALSE)"
    );
    $insert->execute([
        "username" => "admin",
        "hash" => password_hash("admin", PASSWORD_DEFAULT),
    ]);
}

/** Run from setup/install.php only — resets default admin credentials. */
function reset_admin_credentials(?PDO $pdo = null): void
{
    $pdo = $pdo ?? db();
    $upsert = $pdo->prepare(
        "INSERT INTO admin_users (username, password_hash, must_change_password)
         VALUES (:username, :hash, FALSE)
         ON CONFLICT (username) DO UPDATE SET
            password_hash = EXCLUDED.password_hash,
            must_change_password = FALSE"
    );
    $upsert->execute([
        "username" => "admin",
        "hash" => password_hash("admin", PASSWORD_DEFAULT),
    ]);
}

function ensure_database_exists(): void
{
    $c = db_config();
    $pdo = db_connect_server();
    $safeName = preg_replace('/[^a-zA-Z0-9_]/', '', $c["name"]) ?: "infersioai";
    $exists = $pdo->prepare("SELECT 1 FROM pg_database WHERE datname = :name");
    $exists->execute(["name" => $safeName]);
    if (!$exists->fetchColumn()) {
        $pdo->exec('CREATE DATABASE "' . str_replace('"', '""', $safeName) . '"');
    }
}

function public_clients(): array
{
    try {
        bootstrap_database();
        $pdo = db();
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
