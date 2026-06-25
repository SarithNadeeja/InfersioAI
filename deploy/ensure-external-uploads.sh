#!/usr/bin/env bash
# Run after every git pull on the server so uploads stay outside the website folder.
# Usage: bash deploy/ensure-external-uploads.sh

set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
EXTERNAL_UPLOADS="${UPLOADS_DIR:-/home/ubuntu/uploads}"

echo "Project:  $PROJECT_DIR"
echo "Uploads:  $EXTERNAL_UPLOADS"

mkdir -p "$EXTERNAL_UPLOADS/client-logos" "$EXTERNAL_UPLOADS/team-photos"
chmod 775 "$EXTERNAL_UPLOADS" 2>/dev/null || true

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
    echo "Creating config/uploads.local.php..."
    cat > "$CONFIG_FILE" <<PHP
<?php
declare(strict_types=1);

return [
    "base_dir" => "$EXTERNAL_UPLOADS",
];
PHP
fi

echo "Done. uploads -> $(readlink -f "$PROJECT_DIR/uploads")"
