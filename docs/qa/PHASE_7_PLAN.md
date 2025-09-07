### Phase 7 — Production Readiness and SRE Excellence (Execution Plan)

#### 1) SLOs/SLIs and alerting
- Define targets: availability 99.9%, p95 auth < 400ms, p95 export < 2s, error rate < 0.5%.
- Configure alerts: Sentry error spike, /health failures, k6 p95 breaches.
- Deliverables: `docs/qa/SLOs.md`, CI annotations.

#### 2) Blue/green + canary deployments
- Strategy doc with rollback steps; traffic split via env/router rules.
- Canary approval gate in Actions; auto-rollback on health errors.
- Deliverables: updated `deploy.yml`, `docs/runbooks/deploy.md`.

#### 3) Backups and disaster recovery
- Nightly DB dump; retention 14 days; restore drill script.
- Store encrypted artifacts; document RPO/RTO.
- Deliverables: `scripts/db_backup.sh`, `docs/qa/DR_PLAN.md`.

#### 4) Secrets and key management
- Centralize in GH Environments; rotation cadence; audit log.
- Deliverables: `docs/qa/SECRETS.md`.

#### 5) Security hardening
- Add security headers (Nginx), TLS guidance, CORS policy, basic rate limit.
- Deliverables: header config, `docs/qa/SECURITY_HARDENING.md`.

#### 6) Data protection and compliance
- PII inventory; redact logs; retention windows.
- Deliverables: `docs/qa/DATA_PROTECTION.md`.

#### 7) Chaos and resilience testing
- Inject DB/cache/network faults in staging; verify graceful degradation.
- Deliverables: `docs/qa/CHAOS.md`.

#### 8) Observability dashboards
- Build Sentry dashboards; add uptime probes.
- Deliverables: screenshots/links, `docs/qa/OBS_DASHBOARDS.md`.

#### 9) Performance and cost optimization
- DB index/query audit; cache plan; capacity report.
- Deliverables: `docs/qa/PERF_NOTES.md`.

#### 10) Accessibility and i18n QA
- a11y lint + manual checks; currency/locale review.
- Deliverables: `docs/qa/A11Y_I18N.md`.

#### 11) Tenant scale and isolation tests
- E2E/domain matrix; data leak checks.
- Deliverables: tests + notes.

#### 12) Release management
- Semantic versioning; changelog; pre-release smoke.
- Deliverables: `CHANGELOG.md`, `docs/qa/RELEASE.md`.

#### 13) Infra as Code (optional)
- Compose → K8s plan; GitOps outline.
- Deliverables: `docs/qa/IaC_PLAN.md`.

#### 14) Queues, schedules, caching
- Horizon/queue monitoring; retry/backoff; cache warmers.
- Deliverables: docs + sample scripts.

#### 15) Database migration safety
- Preflight checks; zero-downtime patterns; CI guard.
- Deliverables: CI step + `docs/qa/MIGRATIONS_SAFETY.md`.

#### 16) Pen-test readiness
- Scope, ROE, SLAs; tracking template.
- Deliverables: `docs/qa/PENTEST.md`.

#### 17) Seed scale data and perf tests
- Create `scripts/seed_scale.php` to insert ~100k products and realistic sales.
- Add `tests/Performance/*` to time critical queries and capture `EXPLAIN`.
- Document thresholds, measurements, and indexes in `docs/qa/PERF_NOTES.md`.

#### 18) Migration verification
- Validate `migrate:fresh` and individual up/down on empty and populated DBs.
- Scripted checklist and CI optional job.

### Commands & Artifacts
- Seed scale: `php scripts/seed_scale.php --tenants=1 --products=100000`
- Perf tests: `php artisan test --testsuite=Performance`
- DB backup: `./scripts/db_backup.sh`
- Artifacts: perf CSVs under `storage/perf/`, SBOM, ZAP reports, k6 results.

