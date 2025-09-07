# QA Report

## Environment & Repro Steps
- OS: Ubuntu (CI ubuntu-latest)
- PHP: 8.3/8.4; Node: 20; MySQL: 8.0
- Steps: composer install; set .env; create DBs; migrate landlord/tenant; run Unit/Feature; serve; run Playwright

## Methodology & Coverage Matrix
- See `docs/qa/TEST_MATRIX.md`
- Suites: Unit, Feature/API, E2E (Playwright), DA invariants, Multitenancy

## Pass/Fail Summary
- Overall status: TBD (from CI)
- Failing tests: none/see CI logs
- Defects: list issues with severity and repro steps

## Performance Results
- Targets: auth p95 < 400ms; stock report p95 < 2s; sales export p95 < 2s
- k6 nightly: see CI artifacts; Performance tests timing in `tests/Performance`

## Recommendations & Next Steps
- Raise PHPStan level gradually
- Add more E2E around returns and reversal flows
- Index tuning per `PERF_DB_AUDIT.md`; cache aggregates

