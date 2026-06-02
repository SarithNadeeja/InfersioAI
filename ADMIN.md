# InfersioAI Admin Panel (PostgreSQL)

## Requirements

- PHP 8+ with **pdo_pgsql** enabled
- PostgreSQL (local or AWS Lightsail managed database)

## Database settings

Edit `config/database.php` (see `config/database.example.php` for a template).

| Setting  | AWS Lightsail value   |
|----------|------------------------|
| Database | `infersioai_db`        |
| User     | `infersioai_user`      |
| Password | (set in config file)   |
| Host     | Lightsail DB endpoint  |
| Port     | `5432`                 |

**Host:** In the [Lightsail console](https://lightsail.aws.amazon.com/) → Databases → your instance → copy the **endpoint**. Paste it as `host` in `config/database.php` (not `127.0.0.1` unless PostgreSQL runs on the same server as the website).

Optional overrides without editing the main file: copy `config/database.example.php` to `config/database.local.php` (ignored by git).

Environment variables (optional, override config file):

- `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`

## AWS Lightsail deployment

1. Create a **PostgreSQL** database in Lightsail named `infersioai_db` (or create DB + user matching config).
2. Create user `infersioai_user` with password and grant access to `infersioai_db`.
3. Allow the **Lightsail instance** (web server) to connect to the database (same VPC / public access + firewall as needed).
4. Upload the site files to the instance; set `config/database.php` **host** to the database endpoint.
5. Enable PHP extensions on the instance:

```ini
extension=pdo_pgsql
extension=pgsql
```

6. Open once: `https://your-domain/setup/install.php` — creates tables and admin user.
7. Log in at `/admin/login.php`, then **remove or block** `/setup/`.

## Local development (XAMPP)

| Setting  | Typical local        |
|----------|----------------------|
| Host     | `127.0.0.1`          |
| Database | `infersioai_db`      |
| User     | `infersioai_user`    |

Use `config/database.local.php` for local-only passwords.

## First-time setup

1. Start PostgreSQL (local) or finish Lightsail database setup.
2. Open: `http://localhost/InfersioAI/setup/install.php` (or your deployed URL).
3. When setup succeeds, open: `/admin/login.php`

**First login only** (after `setup/install.php` resets credentials)

- Temporary username: `admin`
- Temporary password: `admin`

You will be required to choose a new username and password before using the panel. After that, `admin` / `admin` no longer works.

## Admin features

- **Dashboard** — overview
- **Clients** — logos for homepage / About
- **Leadership** — team for homepage / About
- **Comments** — homepage testimonials
- **Service projects** — AI, Web, Mobile, Software categories

## Enable pdo_pgsql (XAMPP)

In `php.ini`, uncomment or add:

```ini
extension=pdo_pgsql
extension=pgsql
```

Restart Apache.
