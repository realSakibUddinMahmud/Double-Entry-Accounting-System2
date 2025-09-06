# Tests Guide

## Environments

- Runtime: `.env` (landlord: `landlord_master`, tenant: `tenant_demo`)
- Testing: `.env.testing` (landlord: `landlord_master_test`, tenant: `tenant_demo_test`)

## Install and prerequisites

```bash
# PHP deps
php /workspace/composer.phar install --no-interaction --prefer-dist

# MySQL testing DBs (already provisioned by dumps)
mysql -h 127.0.0.1 -uroot -psecret -e "CREATE DATABASE IF NOT EXISTS landlord_master_test; CREATE DATABASE IF NOT EXISTS tenant_demo_test;"
mysql -h 127.0.0.1 -uroot -psecret landlord_master_test < db/dumps/landlord_master_test.sql
mysql -h 127.0.0.1 -uroot -psecret tenant_demo_test < db/dumps/tenant_demo_test.sql
```

## Running tests

```bash
# Unit + Feature with coverage + junit
XDEBUG_MODE=coverage php -d xdebug.mode=coverage vendor/bin/phpunit --log-junit=storage/test-results/junit.xml

# Artifacts
# - JUnit: storage/test-results/junit.xml
# - HTML coverage: storage/coverage/index.html
```

## E2E (Playwright)

```bash
npm ci
npx playwright install --with-deps chromium
BASE_URL=http://127.0.0.1:8080 npm run test:e2e
npm run test:e2e:report

# Artifacts
# - playwright-report/index.html
# - test-results/ (screenshots/videos/traces)
```

## Factories

Factories live in `database/factories/` and cover:

- `User`, `Company`, `Store`, `Category`, `Brand`, `Unit`, `Product`, `Supplier`, `Customer`, `Tax`
- Add more as needed for pivots: `ProductStore`, `PurchaseItem`, `SaleItem`

