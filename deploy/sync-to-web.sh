#!/usr/bin/env bash
# Deploy repo to Apache web root WITHOUT deleting uploaded images.
#
# Usage (on server):
#   cd /home/ubuntu/InfersioAI
#   git pull
#   bash deploy/sync-to-web.sh
#
# Do NOT use: rsync -av --delete ...  (that deletes storage/uploads on the server)

set -euo pipefail

REPO_DIR="$(cd "$(dirname "$0")/.." && pwd)"
WEB_ROOT="${WEB_ROOT:-/var/www/html}"
WEB_USER="${WEB_USER:-www-data}"
DEPLOY_USER="${SUDO_USER:-$(whoami)}"

echo "Deploying $REPO_DIR -> $WEB_ROOT"

if [ ! -d "$WEB_ROOT" ]; then
    echo "ERROR: Web root $WEB_ROOT does not exist."
    exit 1
fi

run_root() {
    if [ "$(id -u)" -eq 0 ]; then
        "$@"
    elif command -v sudo >/dev/null 2>&1; then
        sudo "$@"
    else
        "$@"
    fi
}

# Sync code only — never delete the live uploads folder.
run_root rsync -av --delete \
    --exclude ".git/" \
    --exclude "storage/uploads/" \
    --exclude "config/uploads.local.php" \
    --exclude "config/database.local.php" \
    "$REPO_DIR/" "$WEB_ROOT/"

# Restore persistent uploads + symlinks in repo and web root.
WEB_ROOT="$WEB_ROOT" bash "$REPO_DIR/deploy/ensure-external-uploads.sh"

run_root chown -R "${DEPLOY_USER}:${WEB_USER}" "$WEB_ROOT"
run_root chown -R "${DEPLOY_USER}:${WEB_USER}" "${UPLOADS_DIR:-/home/ubuntu/uploads}"
run_root systemctl restart apache2 2>/dev/null || true

echo "Deploy complete. Uploaded images are in ${UPLOADS_DIR:-/home/ubuntu/uploads}"
