## Phase 5 — CI/CD, E2E scale-up, and quality gates

Goal: Validate critical user journeys in a real browser with Playwright, wire tests into CI/CD, and enforce quality gates (static analysis, style, security, mutation, optional perf).

### 5.1 Playwright setup and server
- Configure baseURL to `http://127.0.0.1:8081` in `playwright.config.ts`.
- Start server for E2E runs: `php artisan serve --host=127.0.0.1 --port=8081`.
- Enable artifacts: traces/videos/screenshots on failure; generate `playwright-report/` and `test-results/`.

### 5.2 E2E specs to implement (under `tests/e2e/`)
- `auth.spec.ts`: valid login (dashboard widgets), logout (back to login), invalid login error.
- `catalog.spec.ts`: create Category, Unit, Product; verify UI confirmations and listings.
- `purchase.spec.ts`: create Supplier/Store; post multi-line Purchase; UI totals correct; DB shows stock increase; view pages load.
- `sale.spec.ts`: create Customer; post Sale with tax/discount; UI totals and DB stock decrease; insufficient stock error path.
- `reports.spec.ts`: open Stock/COGS screens; totals match DB queries; verify dashboard widgets if present.
- `rbac.spec.ts`: restricted user cannot access admin pages; receives 403 or redirect.

### 5.3 E2E run and artifacts
- Run: `npx playwright test --reporter=list`
- Show report: `npx playwright show-report`
- Collect artifacts: `playwright-report/`, `test-results/` (videos, traces, screenshots)

### 5.4 CI pipeline (GitHub Actions) — `.github/workflows/test.yml`
- Set up PHP with Xdebug, cache Composer; start MySQL; prepare landlord/tenant test DBs (import schema/dumps).
- Run phpunit with coverage: junit to `storage/test-artifacts/junit.xml`; coverage HTML to `storage/coverage/`.
- Upload artifacts (junit, coverage HTML).
- Playwright headless matrix: chromium/firefox/webkit; upload `playwright-report/` and `test-results/`.
- Optional: split Unit vs Feature and parallelize.

### 5.5 Static analysis & style
- Add `phpstan.neon` (Larastan), run in CI; fail on new high-severity issues.
- Add `.php-cs-fixer.php`, enforce style in CI.

### 5.6 Security and dependencies
- `composer audit` in CI; fail on criticals (or log per policy).
- Enforce lockfile usage / reproducible installs.

### 5.7 Mutation testing
- Add Infection config; target DA-critical logic first; set initial low threshold and raise gradually.

### 5.8 Performance (optional)
- Add k6 scripts in `tests/perf/` for auth, sales export, DA posting; optional thresholds; optional CI job.

### 5.9 Test data management
- Deterministic seeders/snapshots; provide restore scripts/commands for landlord/tenant test DBs.
- Optional scheduled dump refresh workflow.

### 5.10 Reporting and badges
- CI summary: pass/fail, coverage %, slow/flaky tests.
- Coverage badge from artifact; link to HTML coverage, Playwright report, QA report.

### 5.11 Deliverables
- Playwright: `playwright.config.ts`, `tests/e2e/*.spec.ts` (auth, catalog, purchase, sale, reports, rbac)
- CI: `.github/workflows/test.yml`
- Quality: `phpstan.neon`, `.php-cs-fixer.php`
- Performance (optional): `tests/perf/*.js`
- Docs: CI usage, artifacts, thresholds, and E2E instructions

### 5.12 Acceptance criteria
- All E2E specs implemented and passing locally and in CI (headless).
- PHPUnit and Playwright artifacts uploaded in CI runs.
- Static analysis/style steps integrated; CI fails on new issues.
- Mutation/perf steps present (non-blocking at first) with docs.
- Documentation updated; coverage + CI badges available.

