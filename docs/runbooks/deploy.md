## Deploy Runbook

### CI/CD
- Build & push image: `.github/workflows/deploy.yml`
- Image: `ghcr.io/realsakibuddinmahmud/dea-app:<sha>`
- Migrations:
  - Landlord: `php artisan migrate --force`
  - Tenant: `php artisan migrate --force --database=tenant --path=database/migrations/tenant`

### Staging
1. Ensure secrets (DB, SENTRY) are set in environment
2. Pull latest image
3. Run migrations (landlord, tenant)
4. Start container(s): `docker compose -f docker-compose.staging.yml up -d`
5. Verify `/health` returns 200

### Rollback
1. Deploy previous image tag
2. If necessary, roll-forward migrations or restore from backup

