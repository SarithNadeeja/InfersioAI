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

### Homepage video feels slow only on the server

If the intro works on XAMPP but stalls on Lightsail, check these in order:

1. **Upload `assets/banner.webm`** — confirm the file exists on the instance (same path as local) and is not a partial FTP upload. The homepage downloads the full file before showing **Visit website**; a missing or slow file keeps the loader visible or blocks instant play.
2. **Deploy `.htaccess`** in the site root (included in the repo). It sets `video/webm` MIME type, `Accept-Ranges`, long cache for media, and disables gzip on `.webm` files.
3. **Database host** — in `config/database.php`, set `host` to the Lightsail PostgreSQL endpoint. Wrong host (`127.0.0.1` with no local DB) used to delay the whole page before the browser could download the video; the homepage now loads DB content after the hero, but other pages still need a correct DB host.
4. **Apache modules** — enable `mod_headers`, `mod_mime`, and `mod_setenvif` (or `mod_deflate`) so `.htaccess` rules apply.
5. **File size** — re-encode `banner.webm` to a smaller file if the instance has limited bandwidth (target roughly under 5–8 MB for an intro clip).
6. **Mobile (iPhone / iPad)** — upload **`assets/banner.mp4`** (H.264) in addition to `banner.webm`. iOS does not play WebM reliably; the site picks MP4 on phones when that file exists. Intro is started with **swipe down** or **scroll down** (no button).

**Nginx** (if not Apache): add `types { video/webm webm; }`, `gzip off` for `*.webm`, and `add_header Accept-Ranges bytes;` for video locations.

## Local development (XAMPP)

| Setting  | Typical local        |
|----------|----------------------|
| Host     | `127.0.0.1`          |
| Database | `infersioai_db`      |
| User     | `infersioai_user`    |

Use `config/database.local.php` for local-only passwords.

## Uploads folder (admin images)

Client logos and team photos are stored in **`/home/ubuntu/uploads`** — outside the git repo and outside `rsync --delete`.

### Deploy to /var/www/html (your setup)

**Do not use** `rsync --delete` without excluding uploads. It deletes images on every deploy.

After every update, run:

```bash
cd /home/ubuntu/InfersioAI
git pull
bash deploy/sync-to-web.sh
```

That script:

- Syncs code to `/var/www/html` **without** deleting `storage/uploads/`
- Keeps real files in `/home/ubuntu/uploads`
- Links `storage/uploads` → `/home/ubuntu/uploads` in both the repo and web root
- Sets permissions for `www-data`

### Manual deploy (if needed)

```bash
sudo rsync -av --delete \
  --exclude '.git/' \
  --exclude 'storage/uploads/' \
  --exclude 'config/uploads.local.php' \
  /home/ubuntu/InfersioAI/ /var/www/html/

WEB_ROOT=/var/www/html bash /home/ubuntu/InfersioAI/deploy/ensure-external-uploads.sh
sudo chown -R www-data:www-data /var/www/html /home/ubuntu/uploads
sudo systemctl restart apache2
```

### One-time fix (if symlink setup failed with "Permission denied")

```bash
cd /home/ubuntu/InfersioAI
git pull
sudo bash deploy/ensure-external-uploads.sh
# or full deploy:
sudo bash deploy/sync-to-web.sh
```

Verify:

```bash
ls -la /var/www/html/storage/uploads    # must show: uploads -> /home/ubuntu/uploads
ls -la /home/ubuntu/uploads/client-logos/
```

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
- **Users** — add / remove admin users; change username and password

## Enable pdo_pgsql (XAMPP)

In `php.ini`, uncomment or add:

```ini
extension=pdo_pgsql
extension=pgsql
```

Restart Apache.
