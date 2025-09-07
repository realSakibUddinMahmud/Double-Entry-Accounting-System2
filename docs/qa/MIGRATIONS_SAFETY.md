## Migration Safety

### Checks
- `migrate:fresh` succeeds on clean DB
- Incremental up/down tested on staging
- Avoid destructive changes without backfill/lock-step deploys

### CI
- Manual workflow: `.github/workflows/migration-safety.yml`

