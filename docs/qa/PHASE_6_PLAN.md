### Phase 6 — CI/CD hardening, Security, and Observability (Plan)

#### A) Containerized CI/CD + Staging
- Deliverables:
  - `Dockerfile`, `docker-compose.yml`, `docker-compose.staging.yml`
  - `ops/nginx/nginx.conf`, `ops/php/php.ini`
  - `.github/workflows/deploy.yml`
  - `docs/qa/PHASE_6_PLAN.md` (final doc)
- Steps:
  - Build image:
```bash
docker build -t dea-app:latest .
```
  - Local run:
```bash
docker compose up -d
```
  - Staging deploy (GH Actions):
    - Build and push image to GHCR
    - SSH/runner deploy and `php artisan migrate --force`
- Artifacts/quality gates:
  - Image SBOM (see B)
  - Healthcheck endpoint returns 200
  - Zero-downtime deploy (migrate gated)

#### B) Security Hardening (SAST/DAST/Secrets/SBOM)
- Deliverables:
  - `.github/workflows/zap-baseline.yml` (OWASP ZAP baseline)
  - `.github/workflows/secrets-scan.yml` (Gitleaks/TruffleHog)
  - `.github/workflows/sbom.yml` (Syft SBOM + Cosign attest)
- Steps:
  - SAST: keep PHPStan high level in CI (done; raise level gradually)
  - DAST:
```bash
docker run -t ghcr.io/zaproxy/zaproxy:stable zap-baseline.py -t http://127.0.0.1:8081 -r zap.html
```
  - Secrets:
```bash
gitleaks detect --redact --report-format json --report-path gitleaks.json
```
  - SBOM + attest:
```bash
syft packages dir:. -o spdx-json > sbom.spdx.json
cosign attest --predicate sbom.spdx.json --type spdx <IMAGE_URL>
```
- Quality gates:
  - Fail CI on secrets found
  - Fail CI on ZAP medium/high alerts (allowlist login etc.)
  - SBOM uploaded per build

#### C) Observability and Reliability
- Deliverables:
  - Sentry wiring (PHP + JS), `SENTRY_DSN` env
  - Structured JSON logs via `monolog` channel
  - `/health` endpoint + DB/connectivity checks
  - Slack/Teams webhook notifications for CI failures and prod incidents
- Steps:
  - Install Sentry PHP SDK (app + queue)
  - Add `LOG_CHANNEL=json` for non-local; forward to file/stdout
  - Add `GET /health` controller (checks DB, cache, queue)
- Quality gates:
  - Health endpoint 200 in CI smoke
  - Error budgets and alert thresholds in Sentry

#### D) E2E Scaling and Flake Control
- Deliverables:
  - Playwright sharding across CI matrix
  - Flaky test quarantine tag `@flaky`
- Steps:
```bash
npx playwright test --shard=1/3
```
  - Retries per-spec and slow test thresholds
- Quality gates:
  - No test exceeds time budget
  - Quarantined tests tracked and rotated out weekly

#### E) Performance in CI (Nightly/Cron)
- Deliverables:
  - `.github/workflows/perf.yml` (cron)
- Steps:
```bash
BASE_URL=${STAGING_URL} k6 run tests/perf/k6_auth_login.js
BASE_URL=${STAGING_URL} k6 run tests/perf/k6_sales_export.js
```
- Quality gates:
  - k6 thresholds enforced (p95 < SLOs)
  - Perf artifacts (JSON/HTML) uploaded

#### F) Dependency/Change Automation
- Deliverables:
  - `.github/dependabot.yml` (Composer/npm/GitHub Actions)
- Steps:
  - Enable auto-PRs with labels, CI required
- Quality gates:
  - Require green CI before merge
  - Auto-merge only for low-risk, patch updates

#### G) Documentation and Runbooks
- Deliverables:
  - `docs/qa/PHASE_6_PLAN.md`
  - `docs/runbooks/incident_response.md`
  - `docs/runbooks/deploy.md`
- Content:
  - How to run CI jobs locally
  - Rollback procedures
  - Alert routing and on-call

#### H) Report/Export Testing (PDF/CSV/etc.)
- Deliverables:
  - `tests/Feature/Export/*`
  - E2E export tests (download verification)
  - CI artifacts: exported files attached on test runs
- Discovery:
  - Search for export routes/services/packages (e.g., `barryvdh/laravel-dompdf`, Snappy, CSV generators)
- Feature tests (per endpoint):
  - Hit route; assert 200
  - Assert headers: `Content-Type`, `Content-Disposition` filename
  - Validate body:
    - PDF: bytes > 0 and expected text present
    - CSV: parse; assert headers and sample rows
- E2E:
  - Trigger export via UI; confirm file download and minimal validation
- CI:
  - Save downloaded files to artifacts for inspection

