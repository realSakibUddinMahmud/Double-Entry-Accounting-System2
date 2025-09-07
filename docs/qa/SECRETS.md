## Secrets & Key Management

### Storage
- GitHub Environments/Actions secrets for CI/CD (DB creds, Sentry DSN)
- Local `.env` not committed; rotate on schedule

### Rotation
- Quarterly rotation of DB users/passwords and Sentry DSN
- Process:
  1) Create new secret value
  2) Update GH Envs; deploy canary; validate
  3) Promote; remove old secret after grace period

### Audit
- Track changes via PRs/reviews; note owner and reason

