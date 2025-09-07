#!/usr/bin/env bash
set -euo pipefail

# Simple MySQL backup helper
# Usage:
#   DB_HOST=127.0.0.1 DB_USERNAME=root DB_PASSWORD=secret \
#   ./scripts/db_backup.sh landlord_master tenant_demo
#
# Env:
#   BACKUP_DIR (default: storage/backups)
#   RETENTION_DAYS (default: 14)

BACKUP_DIR=${BACKUP_DIR:-storage/backups}
RETENTION_DAYS=${RETENTION_DAYS:-14}
DB_HOST=${DB_HOST:-127.0.0.1}
DB_USERNAME=${DB_USERNAME:-root}
DB_PASSWORD=${DB_PASSWORD:-}

mkdir -p "$BACKUP_DIR"
timestamp=$(date +"%Y%m%d_%H%M%S")

if ! command -v mysqldump >/dev/null 2>&1; then
  echo "mysqldump not found. Please install MySQL client." >&2
  exit 1
fi

if [ "$#" -lt 1 ]; then
  echo "No databases specified. Example: ./scripts/db_backup.sh landlord_master tenant_demo" >&2
  exit 2
fi

for db in "$@"; do
  out="$BACKUP_DIR/${db}_${timestamp}.sql.gz"
  echo "Backing up $db -> $out"
  mysqldump \
    -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" \
    --single-transaction --routines --triggers --events \
    --hex-blob --skip-lock-tables "$db" | gzip -9 > "$out"
done

echo "Applying retention: ${RETENTION_DAYS} days"
find "$BACKUP_DIR" -type f -name "*.sql.gz" -mtime +"$RETENTION_DAYS" -print -delete || true
echo "Done."

