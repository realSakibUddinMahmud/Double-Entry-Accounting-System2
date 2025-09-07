# Tests Guide

## Environments

- Runtime: `.env` (landlord: `landlord_master`, tenant: `tenant_demo`)
- Testing: `.env.testing` (landlord: `landlord_master_test`, tenant: `tenant_demo_test`)

## Install and prerequisites

```bash
# PHP deps
composer install --no-interaction --prefer-dist

# MySQL testing DBs (already provisioned by dumps)
mysql -h 127.0.0.1 -uroot -psecret -e "CREATE DATABASE IF NOT EXISTS landlord_master_test; CREATE DATABASE IF NOT EXISTS tenant_demo_test;"
mysql -h 127.0.0.1 -uroot -psecret landlord_master_test < db/dumps/landlord_master_test.sql
mysql -h 127.0.0.1 -uroot -psecret tenant_demo_test < db/dumps/tenant_demo_test.sql
```

## Running tests

```bash
# Unit + Feature with coverage + junit
XDEBUG_MODE=coverage php -d xdebug.mode=coverage vendor/bin/phpunit --log-junit=storage/test-artifacts/junit.xml

# Or via composer script
composer run test:cov

# Artifacts
# - JUnit: storage/test-artifacts/junit.xml
# - HTML coverage: storage/coverage/index.html
```

## E2E (Playwright)

```bash
npm ci
npx playwright install --with-deps

# Start app for E2E
php artisan serve --host=127.0.0.1 --port=8081 &

# Run tests (baseURL set in playwright.config.ts)
npx playwright test --reporter=list
npx playwright show-report

# Artifacts
# - playwright-report/index.html
# - test-results/ (screenshots/videos/traces)
```

## CI (GitHub Actions)

- Workflow: `.github/workflows/test.yml`
- Steps: Composer install, MySQL service, DB prep, PHPUnit (coverage+junit), Playwright headless, artifact uploads, PHPStan + CS Fixer (best-effort), composer audit (best-effort).

## Factories

Factories live in `database/factories/` and cover:

- `User`, `Company`, `Store`, `Category`, `Brand`, `Unit`, `Product`, `Supplier`, `Customer`, `Tax`
- Pivots/line-items included: `ProductStore`, `PurchaseItem`, `SaleItem`, `ProductStockAdjustment`, `CustomFieldValue`

## Test builders

Reusable builders for common flows:

- `Tests/Support/Builders/ProductStoreBuilder::make()`
- `Tests/Support/Builders/PurchaseBuilder::makeWithItems($n)`
- `Tests/Support/Builders/SaleBuilder::makeWithItems($n)`

RBAC helper trait: `Tests/Support/WithRoles` to `assignRole($user, $role)` and `givePermission($user, $permission)`.

