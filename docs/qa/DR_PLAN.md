## Disaster Recovery Plan

### Backups
- Script: `scripts/db_backup.sh` (gzipped SQL dumps)
- Retention: 14 days (configurable via RETENTION_DAYS)
- Schedule: daily cron (runner or server)

### Restore Procedure
1. Identify backup file by timestamp
2. Stop writes; put app in maintenance
3. Restore: `gunzip -c storage/backups/<db>_YYYYmmdd_HHMMSS.sql.gz | mysql -hHOST -uUSER -pPASS <db>`
4. Run `php artisan migrate --force` if schema changed forward
5. Exit maintenance; verify `/health`

### Drill & Validation
- Quarterly restore drills to staging
- Verify integrity (counts, checksum where feasible)

### RPO/RTO
- RPO: 24h (daily backups)
- RTO: < 1h for small datasets; adjust with size

