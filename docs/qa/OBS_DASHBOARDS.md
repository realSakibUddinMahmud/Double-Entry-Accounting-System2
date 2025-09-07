## Observability Dashboards

### Sentry
- Dashboards: error rate by release; top issues; performance transactions (auth, export)
- Alerts: regression on new release; spike thresholds

### Logs
- Queries: 5xx over time; slow request patterns; tenant-specific errors

### Uptime
- Checks: `/health` on staging/production at 1-min interval
- Alert: 2 consecutive failures

