#!/usr/bin/env bash
# Run after git pull — keeps uploads in /home/ubuntu/uploads (never deleted by rsync).
# Usage:
#   bash deploy/ensure-external-uploads.sh
#   WEB_ROOT=/var/www/html bash deploy/ensure-external-uploads.sh

set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
WEB_ROOT="${WEB_ROOT:-$PROJECT_DIR}"
EXTERNAL_UPLOADS="${UPLOADS_DIR:-/home/ubuntu/uploads}"
WEB_USER="${WEB_USER:-www-data}"
DEPLOY_USER="${SUDO_USER:-$(whoami)}"

echo "Repo:     $PROJECT_DIR"
echo "Web root: $WEB_ROOT"
echo "Uploads:  $EXTERNAL_UPLOADS"

run_root() {
    if [ "$(id -u)" -eq 0 ]; then
        "$@"
    elif command -v sudo >/dev/null 2>&1; then
        sudo "$@"
    else
        "$@"
    fi
}

external_realpath() {
    mkdir -p "$EXTERNAL_UPLOADS"
    readlink -f "$EXTERNAL_UPLOADS" 2>/dev/null || echo "$EXTERNAL_UPLOADS"
}

run_root mkdir -p "$EXTERNAL_UPLOADS/client-logos" "$EXTERNAL_UPLOADS/team-photos"

migrate_into_external() {
    local source="$1"
    if [ -z "$source" ] || [ ! -e "$source" ]; then
        return 0
    fi

    local resolved
    resolved="$(readlink -f "$source" 2>/dev/null || true)"
    if [ -z "$resolved" ] || [ ! -d "$resolved" ]; then
        return 0
    fi
    if [ "$resolved" = "$(external_realpath)" ]; then
        return 0
    fi

    echo "Migrating uploads from $resolved ..."
    run_root cp -a --update=none "$resolved/." "$EXTERNAL_UPLOADS/" 2>/dev/null || true
}

for LEGACY in \
    "$WEB_ROOT/storage/uploads" \
    "/var/www/html/storage/uploads" \
    "$PROJECT_DIR/storage/uploads" \
    "$WEB_ROOT/uploads" \
    "$PROJECT_DIR/uploads"
do
    migrate_into_external "$LEGACY"
done

link_storage_uploads() {
    local site_root="$1"
    local storage_dir="$site_root/storage"
    local link_path="$storage_dir/uploads"
    local external_target
    external_target="$(external_realpath)"

    run_root mkdir -p "$storage_dir"

    if [ -L "$link_path" ]; then
        local current_target
        current_target="$(readlink -f "$link_path" 2>/dev/null || true)"
        if [ "$current_target" = "$external_target" ]; then
            echo "Already linked: $link_path -> $EXTERNAL_UPLOADS"
            return 0
        fi
        echo "Replacing symlink $link_path ..."
        run_root rm -f "$link_path"
    elif [ -d "$link_path" ]; then
        echo "Replacing folder $link_path with symlink ..."
        migrate_into_external "$link_path"
        run_root rm -rf "$link_path"
    elif [ -e "$link_path" ]; then
        run_root rm -f "$link_path"
    fi

    run_root ln -sfn "$EXTERNAL_UPLOADS" "$link_path"
    echo "Linked $link_path -> $EXTERNAL_UPLOADS"
}

link_storage_uploads "$PROJECT_DIR"
if [ "$(readlink -f "$WEB_ROOT" 2>/dev/null || echo "$WEB_ROOT")" != "$(readlink -f "$PROJECT_DIR" 2>/dev/null || echo "$PROJECT_DIR")" ]; then
    link_storage_uploads "$WEB_ROOT"
fi

write_uploads_config() {
    local site_root="$1"
    local config_dir="$site_root/config"
    local config_file="$config_dir/uploads.local.php"

    run_root mkdir -p "$config_dir"
    run_root tee "$config_file" >/dev/null <<PHP
<?php
declare(strict_types=1);

return [
    "base_dir" => "$EXTERNAL_UPLOADS",
];
PHP
    echo "Wrote $config_file"
}

write_uploads_config "$PROJECT_DIR"
if [ "$(readlink -f "$WEB_ROOT" 2>/dev/null || echo "$WEB_ROOT")" != "$(readlink -f "$PROJECT_DIR" 2>/dev/null || echo "$PROJECT_DIR")" ]; then
    write_uploads_config "$WEB_ROOT"
fi

run_root chown -R "${DEPLOY_USER}:${WEB_USER}" "$EXTERNAL_UPLOADS"
run_root chmod 2775 "$EXTERNAL_UPLOADS"
run_root chmod 2775 "$EXTERNAL_UPLOADS/client-logos" "$EXTERNAL_UPLOADS/team-photos" 2>/dev/null || true
run_root find "$EXTERNAL_UPLOADS" -type d -exec chmod 2775 {} + 2>/dev/null || true
run_root find "$EXTERNAL_UPLOADS" -type f -exec chmod 664 {} + 2>/dev/null || true

if id "$WEB_USER" >/dev/null 2>&1; then
    if run_root -u "$WEB_USER" test -w "$EXTERNAL_UPLOADS/client-logos" 2>/dev/null; then
        echo "OK: $WEB_USER can write to $EXTERNAL_UPLOADS/client-logos"
    else
        echo "WARNING: sudo chown -R $DEPLOY_USER:$WEB_USER $EXTERNAL_UPLOADS && sudo chmod -R 2775 $EXTERNAL_UPLOADS"
    fi
fi

echo "Done. Uploads persist in $EXTERNAL_UPLOADS (safe from git pull and rsync --delete)."
