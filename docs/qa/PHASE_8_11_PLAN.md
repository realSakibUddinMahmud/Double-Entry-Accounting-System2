### Phases 8–11 Plan (Detailed)

## Phase 8 — Continuous Integration (GitHub Actions)
Goal: Run all tests on push/PR and publish artifacts.

Tasks:
- Create `.github/workflows/tests.yml`:
  - ubuntu-latest, PHP 8.3+, cache Composer
  - MySQL service; create DBs: `landlord_master`, `tenant_demo`, testing
  - Migrate landlord/tenant; seed roles/permissions; create test user; seed views if needed
  - Run Unit/Feature tests (coverage + junit), Playwright E2E
  - Upload artifacts: `storage/test-artifacts/junit.xml`, `storage/coverage/`, `playwright-report/`, `test-results/`, sample exports, `docs/qa/QA_REPORT.pdf`
  - Fail build on any failing test; optional coverage gate

Deliverable: `.github/workflows/tests.yml`

## Phase 9 — Final QA report
Goal: Produce professional, reproducible report.

Tasks:
- Create `docs/qa/QA_REPORT.md`:
  - Environment & reproducible steps
  - Methodology & coverage matrix (link to `TEST_MATRIX.md`)
  - Pass/fail summary, defects with severity & repro steps
  - Performance results & thresholds
  - Recommendations & next steps
- Convert to PDF: `pandoc docs/qa/QA_REPORT.md -o docs/qa/QA_REPORT.pdf`

Deliverables: `docs/qa/QA_REPORT.md`, `docs/qa/QA_REPORT.pdf`

## Phase 10 — Handover package
Goal: Bundle all outputs for review and future runs.

Tasks:
- Create `/artifacts/INDEX.md` with links to:
  - `docs/qa/QA_PLAN.md`, `docs/qa/TEST_MATRIX.md`, `docs/qa/QA_REPORT.md/.pdf`
  - `storage/test-artifacts/junit.xml`, `storage/coverage/`
  - `playwright-report/`, `test-results/`
  - Sample exports (PDF/CSV)
  - Optional: ERDs, seeded SQL dumps
- Verify all paths exist and sizes > 0

Deliverable: `/artifacts/INDEX.md`

## Phase 11 — Run and publish
Goal: Run the full pipeline locally and archive artifacts.

Tasks:
- Run: Unit/Feature/E2E & generate QA report PDF locally
- Archive artifacts per Phase 10 list
- Produce concise summary with links and sizes

