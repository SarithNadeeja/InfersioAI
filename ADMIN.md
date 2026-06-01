# InfersioAI Admin Panel (PostgreSQL)

## Requirements

- PHP 8+ with **pdo_pgsql** enabled
- PostgreSQL server running locally

## Database settings

Edit `config/database.php`:

| Setting  | Default     |
|----------|-------------|
| Database | `infersioai` |
| User     | `postgres`  |
| Password | `1234`      |
| Host     | `127.0.0.1` |
| Port     | `5432`      |

## First-time setup

1. Start PostgreSQL.
2. Open in browser:  
   `http://localhost/InfersioAI/setup/install.php`
3. When setup succeeds, open:  
   `http://localhost/InfersioAI/admin/login.php`

**Default login**

- Username: `admin`
- Password: `admin`

Remove or protect the `setup/` folder after installation.

## Admin features

- **Dashboard** — overview
- **Client Manager** — logos for About page
- **Team (About)** — team members
- **Service projects** — AI, Web, Mobile, Software categories

## Enable pdo_pgsql (XAMPP)

In `php.ini`, uncomment or add:

```ini
extension=pdo_pgsql
extension=pgsql
```

Restart Apache.
