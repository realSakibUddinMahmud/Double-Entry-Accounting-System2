## Incident Response Runbook

### Triage
- Check `/health` on affected environment
- Review Sentry errors and recent deploys
- Verify DB connectivity, cache status

### Common Issues
- 500 errors: inspect logs (`storage/logs/laravel.json`) and Sentry event
- DB down: failover/restore service; update env if endpoint changed
- PDF export fails: ensure `php-gd` and storage writable

### Mitigation
- Rollback to previous image (see deploy runbook)
- Feature flag or temporarily disable affected routes

### Postmortem
- Root cause, impact, timeline
- Action items with owners and due dates

