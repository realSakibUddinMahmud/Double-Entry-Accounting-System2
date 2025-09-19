# QA Test Plan — Fintech Laravel (Double-Entry Accounting)

Version: 1.0  
Owner: QA  
Tooling: Playwright (TypeScript)

## 1. Objectives & Scope

- Validate all end-user features exposed via Blade/Livewire views, including authentication, CRUD modules, accounting workflows (double-entry integrity), reports, and exports.
- Enforce Bangladesh-specific phone number rules across all relevant inputs.
- Assert double-entry accounting integrity (every journal: total debit = total credit).
- Cover security controls: CSRF, XSS, SQL Injection, file upload restrictions.

In Scope (key areas):
- Authentication: login, registration, password reset (OTP), verify/update OTP flows
- Profile & Company settings
- Stores, Customers, Suppliers CRUD
- Products (create/edit), Units, Categories, Taxes
- Roles, Permissions, User-role assignment (RBAC)
- Settings (journal visibility)
- Sales (create), Sales payments
- Purchases (create), Purchase payments
- Stock Adjustment
- DEAccounting package: Accounts, Payments, Expense, Income, Fund Transfer, Loan/Investment, Loan Return, Security Deposit, file operations
- Journals & Ledgers search
- Reports: Sales, Purchase, Trial Balance, Account Transactions (and PDF exports)

Out of Scope:
- Third‑party integrations not visible in UI.
- Non-UI performance/load tests.

## 2. Test Strategy

- Framework: Playwright + @playwright/test (TypeScript), parallel execution, retries for flakiness-sensitive flows.
- Environments: baseURL configurable via env var `BASE_URL` (default `http://localhost:8000`).
- Browsers: Chromium (required). Optional: Firefox, WebKit in CI matrix.
- Data: Prefer creating/cleaning via UI for end-to-end coverage; allow API/DB seeding for heavy prerequisites (optional).
- Security: Negative inputs for XSS/SQLi; CSRF token presence on POST forms; file type/size validation.
- Accounting: For each journal-producing operation, assert DR=CR on the UI where visible (invoice journals, trial balance totals). Where UI-only, cross-check via derived totals.

## 3. Bangladesh Phone Validation Rules (Reusable)

- Local format: `01XXXXXXXXX` (11 digits total) with prefixes: 013, 014, 015, 016, 017, 018, 019.
- International format: `+8801XXXXXXXXX` (13 characters inc `+`), `+880` replaces leading `0`.
- Reject: 010, 011, 012, non-numeric digits in local form, wrong lengths.

## 4. Test Types

- Functional happy paths + negative/edge/boundary inputs for all forms.
- Security/abuse inputs (XSS/SQLi), CSRF checks.
- Role-based access controls (visibility and hard enforcement).
- End-to-end accounting flow from transaction entry through reporting.

## 5. Test Data & Accounts

Environment variables for credentials (to avoid hardcoding):
- `ADMIN_PHONE`, `ADMIN_PASSWORD`: Admin user
- `USER_PHONE`, `USER_PASSWORD`: Standard user

Other env:
- `BASE_URL` (e.g., `http://localhost:8000` or staging URL)

Data guidelines:
- Use deterministic names with timestamp suffix to avoid collisions.
- Clean up created entities where feasible (delete/archive), or use isolated tenant/store.

## 6. Execution & Command Matrix

Local:
- Install deps and browsers (first time):
  - `npm install`
  - `npx playwright install chromium`
- Run all tests headless: `npx playwright test`
- Run headed for debug: `npx playwright test --headed`
- Open HTML report: `npx playwright show-report`

CI (suggested):
- Jobs: `test:chromium`, `test:firefox`, `test:webkit` (optional)
- Artifacts: HTML report, traces on first retry, screenshots/video on failure

## 7. Reporting

- Reporters: `list`, `html` (always). Optionally `junit` for CI.
- Artifacts per failure: screenshot, video (retain-on-failure), trace (on-first-retry).

## 8. Entry/Exit Criteria

Entry:
- Test environment reachable at `BASE_URL`.
- At least one admin user available.

Exit:
- All critical P0/P1 scenarios pass (authentication; sales/purchase flows; accounting integrity; permissions; reports exports).
- No open critical/blocker defects; acceptable residual risk.

## 9. Risks & Mitigations

- OTP handling: Prefer dedicated test user with stable OTP backdoor or DB seeding; otherwise, limit to UI validation tests.
- Data dependencies: Provide seed data or create on-the-fly in setup.
- Date-sensitive logic: Freeze dates in tests or pick dynamic ranges ≤ today.

## 10. Test Suite Structure (Playwright)

```
tests/
  e2e/
    auth.spec.ts                # login/registration/OTP validation UI
    profile-company.spec.ts     # profile & company profile
    parties-crud.spec.ts        # stores/customers/suppliers CRUD + BD phone rules
    product.spec.ts             # product create/edit, additional fields, images
    de-accounts.spec.ts         # account creation (bank dynamic fields)
    de-modules.spec.ts          # payments/expense/income/fund-transfer/loan/return/security-deposit
    sales.spec.ts               # sale creation, payment states, journals visibility
    purchases.spec.ts           # purchase creation, payments
    stock-adjustment.spec.ts    # stock adjustments
    journals-ledgers.spec.ts    # search filters, PDF triggers
    reports.spec.ts             # sales/purchase/trial balance/account tx + PDF
    settings-rbac.spec.ts       # settings toggles, role-permission gating
    security.spec.ts            # CSRF/XSS/SQLi/file validation
    e2e-accounting.spec.ts      # full end-to-end accounting flow
```

## 11. Feature → Coverage Matrix (high level)

- Authentication: positive/negative phone + BD rules, password mismatch, remember me; OTP UI validation.
- CRUD modules: required/optional fields, BD phone validation where applicable, status toggles.
- Accounting: DR=CR assertions via invoice journal sections & trial balance totals.
- Reports: filters date boundaries; PDF export links produce downloads.
- RBAC: no-access flows render Access Denied; with roles, controls visible.
- Security: escaped outputs; blocked uploads for disallowed types; 419 on CSRF missing.

## 12. Test Data Catalog (examples)

- BD Phones (valid): `01712345678`, `+8801812345678`
- BD Phones (invalid): `01012345678`, `0171234567`, `+8801212345678`, `01712abc678`
- Amount edges: `0`, `0.01`, `999999999999.99` (14 chars), over-precision `1.999`, non-numeric `1a`

## 13. Scheduling & Cadence

- Smoke (pre-merge): auth + one core flow.
- Nightly: full regression matrix.
- On-demand: targeted subsets per module.

## 14. Exit Deliverables

- HTML report and artifacts per run.
- Defect list with reproduction steps and impacted area.

