#!/usr/bin/env bash
# Run after git pull — sets up writable uploads inside the project (gitignored).
# Usage: bash deploy/ensure-external-uploads.sh

set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
STORAGE_UPLOADS="$PROJECT_DIR/storage/uploads"
LEGACY_EXTERNAL="${UPLOADS_DIR:-/home/ubuntu/uploads}"
WEB_USER="${WEB_USER:-www-data}"
DEPLOY_USER="${SUDO_USER:-$(whoami)}"

echo "Project:  $PROJECT_DIR"
echo "Storage:  $STORAGE_UPLOADS"

run_root() {
    if [ "$(id -u)" -eq 0 ]; then
        "$@"
    elif command -v sudo >/dev/null 2>&1; then
        sudo "$@"
    else
        "$@" 2>/dev/null || true
    fi
}

mkdir -p "$STORAGE_UPLOADS/client-logos" "$STORAGE_UPLOADS/team-photos"

# Copy any files from old locations into storage/uploads.
for LEGACY in "$LEGACY_EXTERNAL" "$PROJECT_DIR/uploads"; do
    if [ -d "$LEGACY" ] && [ ! -L "$LEGACY" ]; then
        echo "Migrating files from $LEGACY ..."
        cp -an "$LEGACY/." "$STORAGE_UPLOADS/" 2>/dev/null || true
    elif [ -L "$LEGACY" ]; then
        TARGET="$(readlink -f "$LEGACY" 2>/dev/null || true)"
        if [ -n "$TARGET" ] && [ -d "$TARGET" ]; then
            echo "Migrating files from symlink $LEGACY -> $TARGET ..."
            cp -an "$TARGET/." "$STORAGE_UPLOADS/" 2>/dev/null || true
        fi
    fi
done

# Remove broken external symlink — uploads now live in storage/uploads (gitignored).
if [ -L "$PROJECT_DIR/uploads" ]; then
    echo "Removing uploads symlink (using storage/uploads instead) ..."
    rm -f "$PROJECT_DIR/uploads"
elif [ -d "$PROJECT_DIR/uploads" ]; then
    echo "Removing old project uploads/ folder (files copied to storage/uploads) ..."
    rm -rf "$PROJECT_DIR/uploads"
fi

# uploads.local.php pointing to /home/ubuntu/uploads breaks www-data writes — remove it.
CONFIG_FILE="$PROJECT_DIR/config/uploads.local.php"
if [ -f "$CONFIG_FILE" ]; then
    echo "Removing config/uploads.local.php (using storage/uploads instead) ..."
    rm -f "$CONFIG_FILE"
fi

echo "Setting permissions on storage/uploads ..."
run_root chown -R "${DEPLOY_USER}:${WEB_USER}" "$PROJECT_DIR/storage" 2>/dev/null \
    || chown -R "${DEPLOY_USER}:${DEPLOY_USER}" "$PROJECT_DIR/storage" 2>/dev/null \
    || true
run_root chmod -R 775 "$PROJECT_DIR/storage" 2>/dev/null || chmod -R 775 "$PROJECT_DIR/storage" 2>/dev/null || true

if id "$WEB_USER" >/dev/null 2>&1; then
    if run_root -u "$WEB_USER" test -w "$STORAGE_UPLOADS/client-logos" 2>/dev/null; then
        echo "OK: $WEB_USER can write to $STORAGE_UPLOADS/client-logos"
    else
        echo "WARNING: run: sudo chown -R $DEPLOY_USER:$WEB_USER $PROJECT_DIR/storage && sudo chmod -R 775 $PROJECT_DIR/storage"
    fi
fi

echo "Done. New uploads go to: $STORAGE_UPLOADS"
echo "This folder is gitignored — git pull will not delete your images."
