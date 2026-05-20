<?php
declare(strict_types=1);

function db_config(): array
{
    return [
        "host" => getenv("DB_HOST") ?: "127.0.0.1",
        "port" => getenv("DB_PORT") ?: "5432",
        "name" => getenv("DB_NAME") ?: "infersioai",
        "user" => getenv("DB_USER") ?: "postgres",
        "pass" => getenv("DB_PASS") ?: "",
    ];
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

    $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = :username LIMIT 1");
    $stmt->execute(["username" => "admin"]);
    if (!$stmt->fetch()) {
        $seedHash = password_hash("admin123", PASSWORD_DEFAULT);
        $insert = $pdo->prepare(
            "INSERT INTO admin_users (username, password_hash, must_change_password)
             VALUES (:username, :hash, TRUE)"
        );
        $insert->execute([
            "username" => "admin",
            "hash" => $seedHash,
        ]);
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
