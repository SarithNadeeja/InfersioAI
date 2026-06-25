#!/usr/bin/env bash
# Run after every git pull on the server so uploads stay outside the website folder.
# Usage: bash deploy/ensure-external-uploads.sh

set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
EXTERNAL_UPLOADS="${UPLOADS_DIR:-/home/ubuntu/uploads}"
WEB_USER="${WEB_USER:-www-data}"
DEPLOY_USER="${SUDO_USER:-$(whoami)}"

echo "Project:     $PROJECT_DIR"
echo "Uploads:     $EXTERNAL_UPLOADS"
echo "Web user:    $WEB_USER"
echo "Deploy user: $DEPLOY_USER"

run_root() {
    if [ "$(id -u)" -eq 0 ]; then
        "$@"
    elif command -v sudo >/dev/null 2>&1; then
        sudo "$@"
    else
        "$@" 2>/dev/null || true
    fi
}

# PHP (www-data) must traverse /home/ubuntu to reach /home/ubuntu/uploads.
HOME_DIR="$(dirname "$EXTERNAL_UPLOADS")"
if [ -d "$HOME_DIR" ] && [ "$HOME_DIR" != "/" ]; then
    echo "Ensuring web server can access $HOME_DIR ..."
    run_root usermod -aG "$DEPLOY_USER" "$WEB_USER" 2>/dev/null || true
    run_root chgrp "$DEPLOY_USER" "$HOME_DIR" 2>/dev/null || true
    run_root chmod 750 "$HOME_DIR" 2>/dev/null || true
    if command -v setfacl >/dev/null 2>&1; then
        run_root setfacl -m "u:${WEB_USER}:--x" "$HOME_DIR" 2>/dev/null || true
    fi
fi

mkdir -p "$EXTERNAL_UPLOADS/client-logos" "$EXTERNAL_UPLOADS/team-photos"

echo "Setting ownership and permissions on uploads ..."
run_root chown -R "${DEPLOY_USER}:${WEB_USER}" "$EXTERNAL_UPLOADS"
run_root chmod 2775 "$EXTERNAL_UPLOADS"
run_root find "$EXTERNAL_UPLOADS" -type d -exec chmod 2775 {} +
run_root find "$EXTERNAL_UPLOADS" -type f -exec chmod 664 {} + 2>/dev/null || true

if command -v setfacl >/dev/null 2>&1; then
    run_root setfacl -R -m "u:${WEB_USER}:rwx" "$EXTERNAL_UPLOADS"
    run_root setfacl -R -d -m "u:${WEB_USER}:rwx" "$EXTERNAL_UPLOADS"
fi

# If git recreated a real uploads/ folder, move files out then replace with symlink.
if [ -e "$PROJECT_DIR/uploads" ] && [ ! -L "$PROJECT_DIR/uploads" ]; then
    echo "Replacing project uploads/ directory with symlink to external storage..."
    if [ -d "$PROJECT_DIR/uploads" ]; then
        cp -an "$PROJECT_DIR/uploads/." "$EXTERNAL_UPLOADS/" 2>/dev/null || true
        rm -rf "$PROJECT_DIR/uploads"
    fi
fi

ln -sfn "$EXTERNAL_UPLOADS" "$PROJECT_DIR/uploads"

CONFIG_FILE="$PROJECT_DIR/config/uploads.local.php"
if [ ! -f "$CONFIG_FILE" ]; then
    echo "Creating config/uploads.local.php ..."
    cat > "$CONFIG_FILE" <<PHP
<?php
declare(strict_types=1);

return [
    "base_dir" => "$EXTERNAL_UPLOADS",
];
PHP
fi

# Quick write test as the web user (best signal that PHP uploads will work).
WRITE_TEST="$EXTERNAL_UPLOADS/client-logos/.deploy_write_test"
if id "$WEB_USER" >/dev/null 2>&1; then
  if run_root -u "$WEB_USER" test -w "$EXTERNAL_UPLOADS/client-logos"; then
    echo "OK: $WEB_USER can write to $EXTERNAL_UPLOADS/client-logos"
  else
  if run_root -u "$WEB_USER" sh -c "echo ok > '$WRITE_TEST'" 2>/dev/null; then
    run_root rm -f "$WRITE_TEST"
    echo "OK: $WEB_USER can write to $EXTERNAL_UPLOADS/client-logos"
  else
    echo ""
    echo "WARNING: $WEB_USER still cannot write to $EXTERNAL_UPLOADS/client-logos"
    echo "Run these commands manually, then restart Apache/PHP:"
    echo "  sudo usermod -aG $DEPLOY_USER $WEB_USER"
    echo "  sudo chown -R $DEPLOY_USER:$WEB_USER $EXTERNAL_UPLOADS"
    echo "  sudo chmod 2775 $EXTERNAL_UPLOADS"
    echo "  sudo chmod -R 2775 $EXTERNAL_UPLOADS/client-logos $EXTERNAL_UPLOADS/team-photos"
    echo "  sudo systemctl restart apache2"
    echo ""
  fi
  fi
fi

echo "Done. uploads -> $(readlink -f "$PROJECT_DIR/uploads")"
