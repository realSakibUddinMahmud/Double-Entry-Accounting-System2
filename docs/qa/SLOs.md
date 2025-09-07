## SLOs / SLIs and Alerting

### Service Level Objectives
- Availability: 99.9% monthly (<= 43m 49s downtime/month)
- Latency p95:
  - Auth (POST /login): < 400ms
  - Stock report (GET /report/stock): < 2000ms
  - Sales export (GET /report/sales/export): < 2000ms
- Error rate: < 0.5% 5m rolling window (HTTP 5xx)

### SLIs and Sources
- Uptime/Health: GET /health success rate, response time
- Application errors: Sentry issue/event rate, release regression
- Performance: k6 p95, PHPUnit Performance suite timings
- CI Smoke: Playwright login, /health; export endpoints (PDF)

### Alert Policies (initial)
- Critical
  - /health failing for 2 consecutive checks (10 min) → page on-call
  - Sentry error rate > 1% for 5 min → page on-call
- Warning
  - k6 nightly p95 breach (auth > 400ms or export > 2s) → Slack/Email
  - Performance suite assertion failures → CI fails + GitHub notification

### Escalation and Ownership
- Level 1: On-call Engineer (triage via incident runbook)
- Level 2: Domain Owner (module-specific)
- Level 3: Platform/SRE (infra/database)

### Measurement & Enforcement
- CI runs Performance tests (phpunit Performance suite) with hard assertions
- Nightly k6 workflow logs p95; future: fail job on threshold breach
- Sentry DSN configured; release tagging enabled; alert rules configurable in UI

### Review Cadence
- Monthly SLO review; track burn rate and exceptions

